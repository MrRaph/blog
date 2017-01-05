+++
author = "MrRaph_"
title = "Accéder à Pluzz.fr et Spotify avec Plex"
tags = ["accéder à pluzz fr avec plex","accéder à pluzz fr et spotify avec plex","Plex","Pluzz","Pluzz.fr","PMS","Spotify","Trucs et Astuces"]
image = "https://techan.fr/images/2015/06/plex_logo.png"
featured = "plex_logo.png"
featuredalt = ""
featuredpath = ""
description = ""
slug = "acceder-a-pluzz-fr-et-spotify-avec-plex"
draft = false
date = 2015-11-16
categories = ["accéder à pluzz fr avec plex","accéder à pluzz fr et spotify avec plex","Plex","Pluzz","Pluzz.fr","PMS","Spotify","Trucs et Astuces"]

+++


Il  ya quelques temps, je suis tombé sur un post sur le forum de la communauté de Plex, dans ce post, un utilisateur présentait un plugin qu’il a réalisé. Celui-ci m’a particulièrement intéressé car il permet d’accéder au replay des chaines du groupes France Télévision – Pluzz.

 

![screenshot.565](https://techan.fr/images/2015/06/screenshot.565.jpg)

J’ai donc entrepris de l’installer. Par ailleurs, j’ai également déniché un plugin pour pouvoir écouter Spotify directement dans Plex !

 


## Installer le plugin pour Pluzz.fr

Voici la marche à suivre pour installer le plugin permettant d’accéder à Pluzz via Plex. Toutes ces actions sont a réaliser sur la machine qui hébèrge le serveur Plex.

    mkdir -p /opt/Plex && cd /opt/Plex
    git clone https://github.com/lotooo/Pluzz.bundle.git
    chown -R plex: Pluzz.bundle/
    ln -s /opt/Plex/Pluzz.bundle/ /var/lib/plexmediaserver/Library/Application\ Support/Plex\ Media\ Server/Plug-ins/
    chown -h plex: /var/lib/plexmediaserver/Library/Application\ Support/Plex\ Media\ Server/Plug-ins/Pluzz.bundle
    service plexmediaserver restart

 

Et voilà !

 

[![pluzz_plex](https://techan.fr/images/2015/06/pluzz_plex.jpg)](https://techan.fr/images/2015/06/pluzz_plex.jpg)

 


## Installer le plugin pour Spotify

De la même façon que pour Pluzz, voici la marche à suivre pour installer le support de Spotify dans Plex.

    mkdir -p /opt/Plex && cd /opt/Plex
    git clone https://github.com/pablorusso/Spotify2.bundle
    chown -R plex: Spotify2.bundle/
    ln -s /opt/Plex/Spotify2.bundle/ /var/lib/plexmediaserver/Library/Application\ Support/Plex\ Media\ Server/Plug-ins/
    chown -h plex: /var/lib/plexmediaserver/Library/Application\ Support/Plex\ Media\ Server/Plug-ins/Spotify2.bundle
    service plexmediaserver restart

 


## Sources

- [Plex Bundle](https://github.com/lotooo/Pluzz.bundle)
- [Spotify Bundle](https://iterando.wordpress.com/2014/06/11/listen-spotify-with-chromecast-and-dlna-using-plex/)

 
