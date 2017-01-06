+++
description = ""
date = "2017-01-04"
linktitle = ""
author = "MrRaph_"
title = "2017 sera l'année de l'automatisation !"
featuredalt = ""
featuredpath = ""
featured = "/images/2017/01/hugo-logo.png"
categories = []
draft = true
slug = "2017-sera-lannee-de-lautomatisation"
categories = ["Docker","iOS", "Blog", "Trucs et Astuces"]
tags = ["Docker","iOS", "Blog", "Trucs et Astuces"]
+++

# Les constatations

En ce début d'année, vous aurez peut être remarqué quelques changements sur mon blog. J'ai en effet pris la décision de ne plus utiliser [Ghost](https://ghost.org/fr/) ce moteur de blog m'a pourtant donné satisfaction, il est rapide et efficace. Mais il souffre encore de pas mal de manques ...

Dans un premier temps, [Ghost](https://ghost.org/fr/) nécessitait une base de données, alors certes on peut l'utiliser avec une base SQLite mais étant donné le nombre d'heures passées à écrire mes articles, je préférais être sûr, et j'avais opté pour MySQL. De plus, comme j'utilisais [Ghost](https://ghost.org/fr/) dans Docker avec plusieurs containers, le risque de corruption aurait été trop élevé avec une "simple" base de données SQLite.

La seconde raison qui m'a poussée à changer est que [Ghost](https://ghost.org/fr/) ne propose pas d'application sur iOS, le projet en propose [une pour les ordinateurs](https://blog.ghost.org/desktop/) mais dès que l'on souhaite écrire sur un périphérique mobile, il faut utiliser l'interface d'administration qui se révèle être plutôt frustrante ...

# Naissance d'une idée

Fort de ces constatations, j'ai décidé de me pencher sur une solution - pas forcément plus simple - mais intégrée sur iOS. Les concepts que j'ai mis en place ici ne devraient toute fois pas être compliqués à mettre en place sur Android ou toute autre plateforme mobile, à condition toute fois que des applications équivalentes existent.

J'ai donc opté pour un système de blog statique, nommé  [Hugo](https://gohugo.io/). Ce n'est pas mon coup d'essai sur cette plateforme, [je l'ai déjà brièvement utilisée au printemps dernier](https://techan.fr/publier-automatiquement-sur-facebook-les-nouveaux-posts-dans-hugo/). L'avantage des blogs statique, c'est que l'on s'affranchit des moteurs qui génèrent les pages à la volée. Avec [Hugo](https://gohugo.io/) - et les autres blog statiques - les articles sont des fichiers plats, écrit en Markdown en général. Lorsque l'on écrit un article, on ajoute un fichier et un binaire permet de regénérer les fichiers HTML du blog après cela, plus rien ne bouge sur le site. Ce mécanisme permet de réduire les besoins nécessaires à l'hébergement du site, au lieu de nécessiter l'installation d'un outil, il ne suffit que d'un serveur web. Dans mon cas, j'ai remplacé les containers gourmands embarquant NodeJS et Ghost par des containers très simples embarquant uniquement Nginx.


Voici ce que donne, sous forme de schéma, le fruit de mes réflexions.

![Schéma d'automatisation du blog](/images/2017/01/blog_automations.png)

Les différents composants que je met en oeuvre sont :
* mon téléphone
* un dépôt Github
* un repository Docker
* deux services dans mon infrastructure Docker
* une recette [IFTTT](https://ifttt.com)

# Mais encore ?

Dans le détail voici donc ce que cela implique. J'ai tout d'abord créé un dépôt GitHub contenant les sources de mon site, en utilisant [Hugo](https://gohugo.io/). Les sources du site sont les articles bien entendu, mais également le thème et fichiers statiques - images, JavaScript, CSS, ...

J'ai installé une application me permettant d'intéragir avec les dépôts Git sur mon téléphone dont je me sert pour éditer mes articles. Lorsque mon édition est terminée, je pousse mes modifications dans le dépôt.

![Builds automatiques sur le Docker Hub](/images/2017/01/docker_hub_automated_builds.png)

C'est là que la magie opère ! Dans le [Docker Hub](https://hub.docker.com), j'ai créé un repository "automated build". Cela signifie que l'image Docker que ce repository représente se regénère à chaque "push" dans GitHub. C'est ici que les fichiers HTML du blog sont regénérés. Le top du top, c'est que je n'ai même pas à assumer le coût en ressources de la génération du blog.

J'ai un total de deux Dockerfile, une pour la production - le vrai blog - et une pour la version "beta" du blog, elle me permet de tester les modifications. Une fois les modifications validées en "beta", je merge la branche "next" dans "master" et la production est regénérée.

Lorsque le [Docker Hub](https://hub.docker.com) a fini de travailler et que la nouvelle version de l'image est prête, je lui ai demandé d'appeler un WebHook.

![WebHook sur le Docker Hub](/images/2017/01/docker_hub_webhooks.png)

Ce WebHook pointe vers un service qui est hébergé sur mon infrastructure Docker 1.12, ce dernier est composé d'un script Python qui reçoit requêtes HTTPS. Son rôle est mettre à jour un des services du blog "prod" ou "next", en fonction des données que le Docker Hub lui envoie. La mise à jour de ces services, force mon cluster Docker à télécharger la nouvelle version de l'image et de lancer une ["rolling upgrade" sur le service](https://techan.fr/les-rolling-updates-avec-docker-1-12/). Le script Python valide également que les demandes sont réalisées avec un "tocken" autorisé, afin que n'importe qui ne puisse pas lancer des mises à jour de mon blog.

![Réception du WebHook](/images/2017/01/blog_webhook_update.png)

Dans les faits, lorsque le service de mise à jour reçoit une demande et qu'il a pu valider le "tocken", il exécute un script qui lance la mise à jour du blog et qui appelle un autre WebHook, chez [IFTTT](https://ifttt.com) cette fois, en utilisant le service "Maker".

Voici comment cette recette est configurée chez [IFTTT](https://ifttt.com) :

![Réception du WebHook](/images/2017/01/blog_automation_ifttt.png)

Et encore de la magie !

![Réception de la notification sur le téléphone](/images/2017/01/blog_automation_ios_notification.jpeg
)

Dans les prochains articles, je reviendrai sur les différentes automatisations que j'ai mises en place sur mon téléphone !
