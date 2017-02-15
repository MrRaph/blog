+++
author = "MrRaph_"
tags = ["CLI","TrucsAstuces","Ubuntu","VNC"]
image = "https://techan.fr/images/2014/11/Linux.png"
date = 2014-11-14T10:35:06Z
categories = ["CLI","TrucsAstuces","Ubuntu","VNC"]
description = ""
slug = "ubuntu-activer-le-partage-decran-depuis-la-ligne-de-commande"
draft = false
title = "[Ubuntu] Activer le partage d'écran depuis la ligne de commande"

+++


***<span style="text-decoration: underline;">[Edit 06/05/2015] :</span>** Testé et approuvé sur Ubuntu 15.04*

Comme d’habitude, je me suis rendu compte que je n’avais pas activé l’accès à distance au bureau sur le serveur Ubuntu de la maison au mauvais moment, celui ou je n’étais pas à la maison …

 

J’ai donc fouiner sur l’internet multimédia pour trouver comment faire ça depuis la ligne de commande et j’ai fini par trouver.  

 Déjà, il faut installer « vino » :

    aptitude install vino

Ensuite, il faut activer le partage de bureau, <span style="text-decoration: underline;">ceci est à exécuter en étant connecté avec le compte de l’utilisateur qui va partager son bureau</span>.

    $ export DISPLAY=:0 $ gsettings set org.gnome.Vino enabled true

Et ensuite, il faut lancer le serveur « vino » :

    raphael@xxxx:~$ DISPLAY=:0.0 /usr/lib/vino/vino-server & [1] 30950
    raphael@xxxx:~$ disown 30950

La commande « disown » permet de détacher le processus de votre session en cours, « vino » continuera de tourner même si vous fermez votre session SSH.

 

Si jamais vous avez des erreurs d’encryption incompatibles entre votre client VNC et le serveur « vino », voici la commande à utiliser :

    gsettings set org.gnome.Vino require-encryption false

 
