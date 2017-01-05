+++
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
categories = ["bannir définitivement les habitués de fail2ban","fail2ban","Linux","Trucs et Astuces","ufw"]
tags = ["bannir définitivement les habitués de fail2ban","fail2ban","Linux","Trucs et Astuces","ufw"]
slug = "bannir-definitivement-les-habitues-de-fail2ban"
draft = false
title = "Bannir définitivement les habitués de Fail2ban"
date = 2015-01-16T16:18:37Z
author = "MrRaph_"

+++


Fail2ban est un outil écrit en Python, il permet en scannant des fichier de log de bannir les rigolos qui tentent de se connecter à un de services disponible sur un Linux et essayant d’y entrer frauduleusement. Le cas classique d’utilisation de Fail2ban est la protection du daemon SSH qui est régulièrement attaqué à coup de brut force. Fail2ban va donc traquer les erreurs d’authentification dans le fichier de log du daemon SSH et banni les IP qui font plus d’un certain nombre d’erreurs de mot de passe dans une période de temps donnée. Les contrevenants ne peuvent plus essayer de nouveaux mot pendant la période ou ils sont exclus.

La liste des personnes bloquées par cet outil est vite assez impressionnantes, on compte parmi eux pas mal de petits malins qui ne tente leur chance que quelques fois, se font bannir et reviennent plus. Mais on remarque aussi très vite quelques « habitués » se distinguent rapidement. C’est dans ce but que j’ai écrit un script pour bannir définitivement les habitués de Fail2ban. C’est un script en Bash, qui va lire le log de Fail2ban et qui crée une règle dans ufw pour bloquer définitivement les zozos.

Voici donc ce script :

#!/bin/bash for banned in $(grep "ban" /var/log/fail2ban.log* | grep actions | grep -v 'already' | awk -F' ' '{print $7}' | grep -v '=' | uniq -c | awk '{print $1 "_" $2}') do nb_bans=$(echo $banned | awk -F'_' '{print $1}') ip=$(echo $banned | awk -F'_' '{print $2}') if [[ nb_bans -gt 5 ]] then echo "$ip banned $nb_bans times." ufw insert 1 deny from $ip fi done | mail -s "Fail2Ban 2 UFW" user@domain.net

Une fois ajouté dans la crontab, ce script va régulièrement bannir définitivement les IP qui sont exclues plus de 5 fois par Fail2ban.


