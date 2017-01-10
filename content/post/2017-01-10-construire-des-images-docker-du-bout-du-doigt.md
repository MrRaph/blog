+++
author = 'MrRaph_'
draft = true
title = 'Construire des images Docker du bout du doigt'
date = '2017-01-10'
title = 'Construire des images Docker du bout du doigt'
categories = ["Docker", "iOS", "IFTTT", "automatisation"]
slug = 'construire-des-images-docker-du-bout-du-doigt'
description = ''
image = '/images/2017/01/ifttt_button_maker.jpeg'
+++

Je décrivais il y a quelques jours [comment j'ai automatisé le déploiement de mon blog](/2017-sera-lannee-de-lautomatisation) en utilisant [Hugo](https://gohugo.io/), le [Docker Hub](https://hub.docker.com) et quelques outils personnalisés. J'ai écrit un article il y a quelques temps de cela pour expliquer comment [poster automatiquement les nouveaux articles sur les réseaux sociaux](/publier-automatiquement-sur-facebook-les-nouveaux-posts-dans-hugo).

Jusqu'à présent, le blog était reconstruit à chaque fois que je faisait un commit dans le dépôt Git. C'est pratique mais parfois cela ajoute un petit peu de lourdeur, en effet, il fait quelques minutes pour que l'image soit construite. Par ailleurs j'ai remarqué qu'à un instant T je ne pouvais avoir que deux constructions en même temps pour une image donnée sur le [Docker Hub](https://hub.docker.com), une en cours de construction, l'autre en file d'attente.

# Le problème

Ce comportement m'était problématique surtout lorsque je dois modifier des éléments de style sur le site. Ces modifications m'amènent à faire des commit fréquents et attendre que l'image soit construite pour valider le résultat, modifier de nouveau si je ne suis pas satisfait, attendre de nouveau. Des que deux push sont déjà en cours de construction dans le [Docker Hub](https://hub.docker.com), les suivants sont ignorés par ce dernier tant qu'il n'y a pas de place disponible dans la file.

Afin de simplifier et accélérer le processus de développement et d'écriture de nouveau contenu, j'ai donc désactivé la fonctionnalité de construction automatique lorsqu'un push est réalisé dans Git.

Ceci se passe dans le [Docker Hub](https://hub.docker.com), plus précisément dans les "Build Settings".

![Docker Hub désactiver les builds automatiques](/images/2017/01/docker_hub_disable_auto_builds.jpeg)

# La nouvelle solution !

La nouvelle solution que j'utilise est un "build trigger", cela consiste en une API que l'on appelle avec un token et un payload JSON. Ce dernier permet de spécifier la branche GitHub à partie de laquelle construire l'image.

L'activation du "build trigger" se fait également dans les "Build Sertings".

![Docker Hub activer le build trigger](/images/2017/01/docker_hub_build_triggers.jpeg)

Notez bien l'URL que vous donne le [Docker Hub](https://hub.docker.com), elle va servir dans [IFTTT](https://ifttt.com).

Et maintenant, [IFTTT](https://ifttt.com) arrive de nouveau sur le devant de la scène. La plateforme permet de déclencher des actions lors d'un tap sur un bouton virtuel.

Le déclencheur est donc le service "Button Widget" et le service déclenché est le désormais incontournable service "Maker" !

![IFTTT widget Boutond](/images/2017/01/ifttt_button_maker.jpeg)


![Recette IFTTT pour déclencher le build](/images/2017/01/ifttt_button_push_to_trigger_build.png)
