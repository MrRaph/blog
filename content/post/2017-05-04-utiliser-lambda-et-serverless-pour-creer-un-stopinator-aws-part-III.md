+++
slug = "utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-III"
draft = true
date = "2017-05-04T18:46:12+01:00"
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

Avec ces paramètres, la fonction serait fonctionnelle, mais il nous faut un moyen de l'exécuter tous les soirs, afin d'éteindre les instances que les étourdis ont oubliées ! :p Nous allons pour cela utiliser une fonction de CloudWatch.

      events:
        - schedule:
            name: DEVEveningShutDownEC2
            description: 'Shut down DEV EC2 at 19:50 PM'
            rate: cron(50 17 ? * 2-6 *) # AWS CloudWatch Events time are in UTC !
            enabled: true
            input:
              ENV: DEV




# Et voilà !

[<< Précédent](https://techan.fr/utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-ii/)

*Note :* Tous les codes présentés dans cette suite d'articles [sont disponible dans ce dépôt GitHub](https://github.com/MrRaph/article-stopinator).
