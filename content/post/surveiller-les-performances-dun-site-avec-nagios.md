+++
author = "MrRaph_"
date = 2015-03-31T15:03:16Z
image = "https://techan.fr/images/2015/03/nagios.png"
description = ""
slug = "surveiller-les-performances-dun-site-avec-nagios"
draft = false
title = "Surveiller les performances d'un site avec Nagios"
categories = ["Bash","Nagios","surveiller les performances d un site avec nagios","Web performances"]
tags = ["Bash","Nagios","surveiller les performances d un site avec nagios","Web performances"]

+++


J’ai eu besoin de créer un script pour pouvoir surveiller les performances d’un site avec Nagios. Seul souci, ce site web est protégé par un SSO et il me fallait récupérer un cookie pour pouvoir récupérer la page de contenu avec « wget ». Heureusement, il est « assez » simple de gérer les cookies avec « wget ».


##  Le script

Voici donc le fameux script, anonymisé bien sûr !

#!/bin/bash ####################################################### ### Monitor_website.sh ### ### Auteur : MrRaph_ ### ### Site : https://techan.fr ### ### Date : 31/03/2015 ### ### ### ####################################################### ####################################################### ### Constantes ### ####################################################### export TMP_DIRECTORY='/tmp/Monitor' export COOKIE_BASE_NAME='cookie_' export WGET="/usr/bin/wget" export DATE=/bin/date ####################################################### ### Les paramètres ### ####################################################### export HOST=$1 export PORT=$2 export WARN=$3 export CRIT=$4 ####################################################### ### Le script ### ####################################################### mkdir -p ${TMP_DIRECTORY}/${PORT} cd ${TMP_DIRECTORY}/${PORT} export COOKIE=${TMP_DIRECTORY}/${PORT}/${COOKIE_BASE_NAME}${PORT} STARTTIME=$($DATE +%s%N) wget --cache=off -nv -p -H --cookies=on --post-data 'username=USER&password=PASS' --load-cookies=${COOKIE} --keep-session-cookies --save-cookies=${COOKIE} http://${HOST}:${PORT}/LOGINPAGE >/dev/null 2>&1 wget --cache=off -nv -p -H --cookies=on --post-data 'username=USER&password=PASS' --load-cookies=${COOKIE} --keep-session-cookies --save-cookies=${COOKIE} --refer=http://${HOST}:${PORT}/LOGINPAGE http://${HOST}:${PORT}/CONTENTPAGE >/dev/null 2>&1 ENDTIME=$($DATE +%s%N) TIMEDIFF=$((($ENDTIME-$STARTTIME)/1000000)) if [ "$TIMEDIFF" -lt "$WARN" ]; then STATUS=OK elif [ "$TIMEDIFF" -ge "$WARN" ] && [ "$TIMEDIFF" -lt "$CRIT" ]; then STATUS=WARNING elif [ "$TIMEDIFF" -ge "$CRIT" ]; then STATUS=CRITICAL fi OUTMSG="$TIMEDIFF ms" cd ${TMP_DIRECTORY} rm -rf ${PORT} echo "RESPONSE: $STATUS - $OUTMSG""|Response="$TIMEDIFF"ms;"$WARN";"$CRIT";0" if [ "$STATUS" = "OK" ]; then exit 0 elif [ "$STATUS" = "WARNING" ]; then exit 1 elif [ "$STATUS" = "CRITICAL" ]; then exit 2 fi exit 3

Il vous faudra adapter :

- Les champs du formulaire de la page de connexion (dans le –post-data)
- Les URL des pages a cibler


## Intégration dans Nagios

Afin d’intégrer le script dans Nagios, je l’ai copié dans le dossier « /usr/lib64/nagios/plugins », mon dossier $USER1$.

####  Création de la commande[![Surveiller les performances d'un site avec Nagios](https://techan.fr/images/2015/03/screenshot.182.jpg)](https://techan.fr/images/2015/03/screenshot.182.jpg)

#### Création du service

[![Surveiller les performances d’un site avec Nagios ](https://techan.fr/images/2015/03/screenshot.183.jpg)](https://techan.fr/images/2015/03/screenshot.183.jpg)

Avec ces réglages on aura :

- Une alerte « WARNING » lorsque la page mettra plus de 5 secondes à charger.
- Une alerte « CRITICAL » lorsque la page mettra plus de 7 secondes à charger.

#### Et voilà !

[![Surveiller les performances d’un site avec Nagios ](https://techan.fr/images/2015/03/screenshot.179.jpg)](https://techan.fr/images/2015/03/screenshot.179.jpg)


