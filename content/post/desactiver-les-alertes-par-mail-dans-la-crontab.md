+++
author = "MrRaph_"
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
draft = false
categories = ["alertes","crontab","Linux","mail"]
tags = ["alertes","crontab","Linux","mail"]
slug = "desactiver-les-alertes-par-mail-dans-la-crontab"
title = "Désactiver les alertes par mail dans la crontab"
date = 2014-09-23T10:10:51Z

+++


Il est souvent pénible de recevoir toute une flopée de mail lors de l’exécution des jobs planifiés dans la crontab de vos Linux.

Il existe plusieurs moyens de les désactiver toutes ou partiellement.

 

Pour rappel, l’édition de la crontab se fait en utilisant la commande suivante :

crontab -e

 

 

### Désactiver partiellement les alertes

La désactivation partielle se fait en ajoutant une redirection de flux à la fin de chaque ligne active de la crontab. Cette méthode permet de choisir quelles planification on souhaite rendre muette et quelles autres on souhaite toujours recevoir.

Il suffit d’ajouter à la fin des lignes a rendre silencieuse, une redirection de flux vers /dev/null.

0 1 5 10 * /path/to/script.sh >/dev/null 2>&1

Ou

0 1 5 10 * /path/to/script.sh &> /dev/null

 

Sauver et quitter la crontab. Vous pouvez éventuellement relancer le daemon « cron ».

/etc/init.d/crond restart

 

 

### 

### Désactiver totalement les alertes

Pour désactiver complètement les alertes, il s’agit d’ajouter une ligne en haut du fichier qui videra l’adresse du destinataire des mails d’alerte.

MAILTO=""

 

 

 


