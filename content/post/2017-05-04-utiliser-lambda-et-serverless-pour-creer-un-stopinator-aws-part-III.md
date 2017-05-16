+++
slug = "utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-III"
draft = false
date = "2017-05-16T20:46:12+01:00"
image = "/images/2017/05/Logo_Lambda_Stopinator_3.png"
type = "post"
description = ""
title = "Utiliser Lambda et ServerLess pour creer un stopinator AWS - Partie 3"
author = "MrRaph_"
categories = ["AWS","Lambda","Trucs et Astuces", "Cloud"]
tags = ["AWS","Lambda","Trucs et Astuces", "Cloud"]
+++

# Résumé des épisodes précédents

Dans la [partie 2](https://techan.fr/utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-ii/i) nous avons configuré le framework ServerLess et nous avons créé notre fonction Lambda. nous allons maintenant voir comment configurer la plateforme Lambda avec le framework Serverless et nous déploierons notre fonction.

*Note :* Tous les codes présentés dans cette suite d'articles [sont disponible dans ce dépôt GitHub](https://github.com/MrRaph/article-stopinator).


# La configuration de notre projet avec Serverless

Toute la configuration de notre projet, c'est à dire tout ce qui est nécessaire à la bonne exécution de notre fonction Lambda, se trouve simplifiée par le framework Serverless. Ce dernier nous permet de régler tous les points dans un fichier de configuration unique : `serverless.yml`. Dans ce fichier nous allons décrire comment ServerLess va se connecter à notre compte AWS pour gérer les déploiements de notre code, mais aussi la façon dont les fonctions seront appelées, les droits IAM nécessaires, etc ...

## Configuration générale du projet

Cette partie de la configuration regroupe toutes les informations générales de votre projet comme son nom, et les paramètres généraux du projet.
Je vais décrire le contenu du fichier `serverless.yml` par partie, vous pouvez le retrouver dans son intégralité [dans ce dépot GutHub](https://github.com/MrRaph/article-stopinator).

La ligne `service` documente le nom de votre projet.

    service: Stopinator

Le bloc `provider` décrit chez quel fournisseur d'InfoNuagique le projet sera déployé. Dans notre cas, cela sera AWS. Nous décrivons également les caractérisques de base de notre fonction Lambda dans ce bloc.

    provider:
      name: aws
      runtime: python2.7
      region: eu-west-1
      profile: profileName1
      cfLogs: false

* `runtime` décrit le langage de programation que nous allons Utiliser
* `region` précise la région - au sens AWS - dans laquelle le projet sera déployé, dans notre cas l'Irelande.
* `profile` reçoit le nom que l'on a donné aux informations de connexion à AWS dans la [première partie](https://techan.fr/utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-i/).
* `cfLogs` permet de désactiver les logs de la fonction Lambda, ceci permet de faire des économies dans notre cas. Ces logs peuvent être nécessaires pour débuger les projets.

      iamRoleStatements:
        - Effect: "Allow"
          Action:
            - "ec2:DescribeInstances"
            - "ec2:StopInstances"
          Resource: "*"

Le bloc `iamRoleStatements` permet d'ajouter des permissions supplémentaires à notre fonction Lambda. Elle en a besoin pour récupérer des informations sur les instances EC2 et pour pouvoir les éteindre.

Nous allons maintenant configurer les fonctions à proprement parler !

      functions:
        doStop:
          handler: handler.doStop
          description: Stops instances
          runtime: python2.7
          memorySize: 128 # optional, default is 1024
          timeout: 60 # optional, default is 6

Nous déclarons notre fonction `doStop` le bloc `functions`. Le handler est le "chemin" que Lambda va utiliser pour lancer la fonction, il est constitué du nom du fichier dans lequel la fonction est présente - sans son extension - et du nom de la fonction, le tout séparé par un point. Le paramètre `memorySize` décrit la mémoire maximale dont pourra disposer la fonctioner, il s'agit d'un des éléments définissant le prix que vous allez payer en utilsant cette fonction Lambda. Le paramètre `timeout` quant à lui définit le temps d'exécution maximale de la fonction, il a également un impact sur le prix que vous coûteront les exécutions des fonctions Lambda. Si le `timeout` est dépassé, Lambda met fin à l'exécution de la fonction. Il ne peut pas exéder 300 secondes.

Avec ces paramètres, la fonction serait fonctionnelle, mais il nous faut un moyen de l'exécuter tous les soirs, afin d'éteindre les instances que les étourdis ont oubliées ! :p Nous allons pour cela utiliser un évennement CloudWatch. CloudWatch est un service AWS permettant de monitorer des ressources, il propose également une fonction d'envoie d'évennements.

      events:
        - schedule:
            name: DEVEveningShutDownEC2
            description: 'Shut down DEV EC2 at 19:50 PM'
            rate: cron(50 17 ? * 2-6 *) # AWS CloudWatch Events time are in UTC !
            enabled: true
            input:
              ENV: DEV

Ce bloc `events` ajouté à notre fonction défini un évennement planifié du lundi au vendredi inclus à 19h50 - attention les heures sont au format UTC dans CloudWatch. Cet évennement passera également un argument `ENV` à notre fonction avec la valeur `DEV`. Ce dernier est utilisé par notre fonction pour filtrer les instances qui portent ce tag avec cette valeur via la ligne suivante.

    for instance in filterInstances(event['ENV'], 'stopped'):

# Déployons notre fonction !

Vous allez maintenant pouvoir admirer toutes la puissance de ServerLess, pour déployer le projet chez AWS, nous utilisons la commande suivante.

    $ serverless deploy

![Déploiement de la fonction avec ServerLess](/images/2017/05/Lambda_Stopinator_Serverless_deploy.png)


Cette commande sera la même si vous souhaitez pousser des modifications faites à votre fonction, ServerLess saura quels éléments modifier et ajustera son template CloudFormation en fonction. Comme beaucoup de processus d'automatisation autours d'AWS, ServerLess se base en effet sur CloudFormation, il s'agit d'un outil fort pratique permettant de définir des piles d'éléments et de les déployer chez AWS. Ces piles sont définies dans des `templates`, l'outil garanti que chaque exécution fournira toujours le même résultat, à condition bien sûr que le template ne change pas !

# Quelques autres fonctionalités sympa de ServerLess

## Métriques sur l'exécution de la Lambda

ServerLess permet facilement de récupérer quelques métriques simples sur l'exécution des projets qu'il gère. Voici comment récupérer ces statistiques depuis le 1er Mai 2017.

    $ serverless metrics --startTime 2017-05-01


![ServerLess Lambda métriques sur le mois de Mai](/images/2017/05/Lambda_Stopinator_Serverless_metrics.png)

## Invoquer la fonction Lambda depuis son poste de travail

Il est également possible avec ServerLess d'invoquer sa fonction Lambda depuis son poste de travail. Ceci évite une laborieuse opération via la console Web d'AWS. Ceci se fait avec la commande suivante.

    $ serverless invoke -f doStop -d '{"ENV": "DEV"}'


![Invoquer une fonction Lambda avec ServerLess](/images/2017/05/Lambda_Stopinator_Serverless_invoke.png)

*Note 1 :* Il faut bien sûr passer les arguments nécessaires à l'exécution de la fonction via l'option `-d`

*Note 2 :* Ceci vous est facturé comme une exécution normale de la fonction étant donné que cette exécution à bel et bien lieux chez AWS. Il est par contre possible de faire des tests exclusivement en local en utilisant la commande `serverless invoke local`.

# Et voilà !

Notre fonction est en place chez AWS et planifiée tous les soirs. La chasse au gaspi peut commencer !

[<< Épisode Précédent](https://techan.fr/utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-ii/)

*Note :* Tous les codes présentés dans cette suite d'articles [sont disponible dans ce dépôt GitHub](https://github.com/MrRaph/article-stopinator).
