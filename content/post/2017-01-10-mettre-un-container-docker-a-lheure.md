+++
author = 'MrRaph_'
draft = true
title = 'Mettre un container Docker à l\'heure'
date = '2017-01-10'
categories = ["Docker", "iOS", "IFTTT", "automatisation"]
slug = 'mettre-un-container-docker-a-lheure'
description = ''
image = '/images/2016/11/docker.png'
+++



    ENV TZ=America/Los_Angeles
    RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
