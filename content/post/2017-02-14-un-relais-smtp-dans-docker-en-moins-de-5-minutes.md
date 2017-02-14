+++
slug = "un-relais-smtp-dans-docker-en-moins-de-5-minutes"
draft = false
date = "2017-02-11T15:46:12+01:00"
image = "/images/2016/11/docker_clean_up.png"
type = "post"
description = ""
title = "Un relais SMTP dans Docker en moins de 5 minutes !"
author = "MrRaph_"
categories = ["Docker","Docker1.12","Trucs et Astuces", "Postfix", "Relais SMTP", "SMTP"]
tags = ["Docker","Docker1.12","Trucs et Astuces", "Postfix", "Relais SMTP", "SMTP"]
+++


Vous avez un domaine, un site web, mais pas de serveur de mail ? Ou vous possèdez pleiiiiins de domaines dans lesquels vous utilisez quelques adresses mail que vous souhaiteriez unifier vers une seule ? Ou comme moi, vous hébergiez vos mails et vous souhaitez revenir simplement vers l'un des services de messagerie bien connus, tout cela sans forcément prendre le temps de migrer toutes les adresses mails de tous les comptes que vous avez sur l'Internet entier et sans perdre de mails ? Et bien c'est possible, et je vais vous expliquer comment faire.

Je pars du principe que vous avez :
* un nom de domaine
* une machine avec une IP publique
* [Docker]() installé sur cette machine


Aller, 5 minutes montre en main, lancez le chronomètre !

# 5 minutes pour créer un relais SMTP, c'est possible !

Tout d'abord, nosu allons exporter une variable dans laquelle nous configurons l'adresse source et celle vers laquelle rediriger le courrier. Dans l'exemple ci-dessous, on redirigerait tous les mails arrivant pour `testi@testo.com` vers l'adresse `test@test.com`. Simple non ?

    export SMF_CONFIG='testi@testo.com:test@test.com'

Vous voulez rediriger les messages des toutes adresses mail d'un domaine vers une adresse spécifique ? C'est aussi simple que cela :

    export  SMF_CONFIG='@testo.com:all@test.com'

Vous avez positionné la variable avec succès ? Maintenant, démarrons le container et adminirons le travail.

    docker run -e SMF_CONFIG="$SMF_CONFIG" -p 25:25 zixia/simple-mail-forwarder

Et voilà ! :-)

Vous devriez avoir mis moins de 5 minutes pour faire cela ! Bon j'ai quelque peu triché, maintenant, il vous faudra configurer votre DNS pour que les mails arrivent vers votre relais !

# Créons un service pour cela

En bonus, voici un script qui permet de créer un service pour cela, histoire d'être tranquile :-)

    #!/bin/bash
    export SMF_CONFIG='@testo.com:all@test.com'

    docker service create --replicas 1 \
    --restart-condition any --name smtp-relay \
    --publish 25:25 \
    --env SMF_CONFIG="$SMF_CONFIG" \
    zixia/simple-mail-forwarder
