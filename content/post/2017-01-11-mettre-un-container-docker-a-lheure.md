+++
author = 'MrRaph_'
draft = false
title = "Mettre un container Docker à l'heure !"
date = '2017-01-11'
categories = ["Docker", "Trucs et Astuces"]
slug = 'mettre-un-container-docker-a-lheure'
description = ''
image = '/images/2016/11/docker.png'
+++

Vous en avez marre des container Docker qui indiquent toujours la mauvaise heure ? Cela fausse vos statistiques ? Cela impacte vos cron ? Et bien voici la solution à ce problème ! Il vous suffit d'ajouter ces lignes dans vos Dockerfile !

    ENV TZ=America/Los_Angeles
    RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

Et voilà ! Adieu la frustration ! :-)