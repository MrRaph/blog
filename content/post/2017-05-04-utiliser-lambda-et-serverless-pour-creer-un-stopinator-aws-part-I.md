+++
slug = "utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-I"
draft = false
date = "2017-05-04T18:46:12+01:00"
image = "/images/2017/05/Logo_Lambda_Stopinator.png"
type = "post"
description = ""
title = "Utiliser Lambda et ServerLess pour creer un stopinator AWS - Partie 1"
author = "MrRaph_"
categories = ["AWS","Lambda","Trucs et Astuces", "Cloud"]
tags = ["AWS","Lambda","Trucs et Astuces", "Cloud"]
+++

# Un stopina...QUOI ?

Un _stopinator_ est un programme permettant d'arrêter - de _stopiner_ :p - des machines, ou n'importe quoi en fait. Ceci est très utilisé lorsque l'on souhaite alléger sa facture auprès de son fournisseur de services dans le nuage. Ces fournisseurs - comme [AWS](https://aws.amazon.com/fr/what-is-aws/) pour ne citer que lui - font en général payer les ressources consommées à l'heure. On peut facilement imaginer des plans visant à éteindre les ressources qui ne sont pas utiles la nuit par exemple et les rallumer le matin lorsque les gens reviennent au travail. Ceci permet d'économiser facilement de l'argent.

Dans le contexte [AWS](https://aws.amazon.com/fr/what-is-aws/) dont je vais parler dans cet article, les choses sont relativement simple car l'API mis à disposition d'Amazon est très bien fournie et permet de faire beaucoup de chose en CLI - ligne de commandes - de plus, les nombreux SDK disponibles sont également très complets. J'utiliserai le SDK Python dans le cadre de cette suite d'article, il s'appelle [Boto3](https://aws.amazon.com/fr/sdk-for-python/).

Il y a plusieurs manières de mettre en place des _stopinators_. On peut, par exemple, utiliser une instance qui sera elle toujours allumée, peut être une passerelle ou autre, et lui ajouter une tâche planifiée qui va aller éteindre d'autres ressources. Dans le cadre de cet article, je vais décrire la mise en place d'un processus un peu plus évolué utilisant une fonction [Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/).amazon.com/fr/lambda/details/) et des règles [CloudWatch](https://[AWS](https://aws.amazon.com/fr/what-is-aws/).amazon.com/fr/cloudwatch/details/).


# Heu ... Et Lambda ? Késako ?

[Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/) fait partie de l'offre [_Compute_ d'AWS](https://aws.amazon.com/fr/products/compute/). Cette offre _Compute_ est pour la plupart des gens limitée aux instances [EC2](https://aws.amazon.com/fr/ec2/), les VMs qu'AWS héberge dans son nuage. Mais il existe d'autres produits AWS qui permettent de réaliser des traitements dans le nuage, je veux parler d'[ECS](https://aws.amazon.com/fr/ecs/), la plateforme d'hébergement de containers proposée par Amazon et ... de [Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/) bien sûr !

[Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/) est une plateforme de *FaaS* - pour les IT-psters - ou plus simplement, une plateforme *[Serverless](http://www.serverless.com/)*.

> Non mais attends ... "*[Serverless](http://www.serverless.com/)*" ça veut dire "_sans serveurs_" comment on peut faire du "computing" "_sans serveurs_" ?

Et bien, là est toute la force et la magie de [Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/) ! Amazon garde jalousement le secret sur la manière dont cette plateforme fonctionne, mais elle peut rapidement votre façon de voire les infrastructures informatiques.

Le principe derrière [Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/) est simple, et peut être résumé en quelques étapes :

- Vous écrivez une fonctions dans un langage supporté.
- Vous mettez en place un événement qui va déclencher son exécution.
- Vous sortez les Pop-Corn et vous admirez !


Actuellement, les langages supportés par [Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/) sont : `Node.js`, `Python`, `Java` et `C#`.

La cerise sur le gateau, c'est qu'avec [Lambda](https://[AWS](https://aws.amazon.com/fr/what-is-aws/), vous ne payez que ce que l'exécution de votre fonction consomme. Alors que les instances EC2 sont facturées à l'heure - toute heure entamée est due bien sûr - les fonctions Lambda elles ne coûte que le nombre de secondes pendant lesquelles elles ont été exécutées sur la plateforme AWS.

Par ailleurs le _Free Tier_ de Lambda est très intéressant. Le _Free Tier_ représente un quota d'utilisation qu'Amazon vous offre, il en existe un pour une grande majorité de services AWS - n'est pas limité dans le temps ! En effet, une grande majorité des _Free Tiers_ sont limité à un an à partir de la création du compte AWS. Celui de Lambda est disponible à vie et il est relativement confortable - 400 000 Go-secondes par mois ! Pour exemple, ce _Free Tier_ permet de faire tourner, de manière continue, une fonction Lambda - configurée pour utiliser jusqu'à 128 Mo de mémoire - pendant 3 200 000 secondes, soit 888 heures ou 37 jours tous les mois.


# Et maintenant, parlons de [Serverless](http://www.serverless.com/)


[[Serverless](http://www.serverless.com/)](https://serverless.com) est un framework fourni par AWS pour déployer des fonctions Lambda sur AWS. Dans les faits, ce framework sait également parler avec Azure, mais ceci est un autre débat - :p - !

La force de ce framework est de simplifier grandement le déploiement des fonctions Lambda. Ce processus n'est pas si simple lorsqu'il faut le réaliser à la main. Tout d'abord, il faut déjà télécharger toutes les librairies nécessaires au projet et les zipper avec les sources des fonctions Lambda, uploader le tout sur S3 et configurer la fonction. [[Serverless](http://www.serverless.com/)](https://serverless.com) gère tout cela à votre place.

Il est également capable de créer toutes sortes d'autres composants AWS en lien avec votre/vos fonction(s) Lambda. Dans l'exemple que nous allons traiter, je vais me servir de [[Serverless](http://www.serverless.com/)](https://serverless.com) pour créer les programmations de l'exécution de mon _stopinator_ avec des règle CloudWatch. Il va aussi prendre se charger de la création du rôle IAM - la briques AWS qui gère les autorisations - qui sera associé à notre Lamdba afin qu'elle ai les droits nécessaires pour agir sur les instances EC2.

Le framework permet également de simplifier grandement les tests de fonctions Lambda, que ce soit en local ou sur la plateforme AWS.

# Bon, maintenant qu'on connait tout cela, à quoi va ressembler le STOPINATOR ?

Et bien, cela ressemblera à cela !

![Schéma du Stopinator Lambda](/images/2017/05/Lambda_Stopinator.png)

On voit ici les deux déclencheurs CloudWatch qui vont provoquer l'exécution de la fonction Lambda. On remarque que notre fonction aura besoin de permissions IAM spécifiques pour pouvoir interagir avec les instances EC2. De l'autre côté de la fonction Lambda, on voit qu'elle va interagir avec l'API EC2 et non avec les instances elles mêmes.

Dans un premier temps, la fonction va filter les instances pour ne cibler que celles qu'elle est chargée d'éteindre ou d'allumer. Puis dans un second temps, elle envoie ses instructions à l'API EC2 pour éteindre ou allumer les instances EC2. Ce sont ces trois actions - décrire, démarrer, éteindre des instances EC2 - qui nécessitent des autorisations IAM.

# La suite au prochain épisode !

Dans la seconde partie, nous verrons comment configurer le framework [Serverless](http://www.serverless.com/) pour notre cas d'usage. Nous créerons également la fonction Lambda qui sera utilisée pour _stopiner_ nos instances.

[>> Suivant](/utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-II)
