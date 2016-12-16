+++
tags = ["Installation","installer ubuntu mate 15 04 sur une raspberry pi 2","Raspberry Pi 2","Ubuntu"]
image = "https://techan.fr/wp-content/uploads/2015/06/Raspi_Colour_R.png"
slug = "installer-ubuntu-mate-15-04-sur-une-raspberry-pi-2"
draft = false
title = "Installer Ubuntu MATE 15.04 sur une RaspBerry Pi 2"
categories = ["Installation","installer ubuntu mate 15 04 sur une raspberry pi 2","Raspberry Pi 2","Ubuntu"]
author = "MrRaph_"
description = ""
date = 2015-06-28T13:44:27Z

+++


Depuis hier je suis l’heureux propriétaire d’un [Raspberry Pi](https://www.amazon.fr/gp/product/B01CYQJP9O/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1642&creative=6746&creativeASIN=B01CYQJP9O&linkCode=as2&tag=techan0f-21), et je dois dire que cette toute petite machine m’a très vite séduit ! Sa simplicité tout d’abord, on déballe l’emballage, on la glisse dans sa boite, on insère une carte SD puis on branche clavier/souris et écran, on met sous tension et c’est parti ! Bon ok, c’est je suis passé un peu vite sur l’installation du système … Mais c’est enfantin ! Je ne vais pas redécrire ici la marche à suivre pour installer le système sur la carte SD car un super article à ce sujet existe déjà sur [raspbian-france.fr](http://raspbian-france.fr/creez-carte-sd-raspbian-raspberry-pi-windows/).

Dans l’article, les gens de [raspbian-france.fr](http://raspbian-france.fr) décrive la marche à suivre pour installer Raspbian, et bien les étapes sont les mêmes pour installer Ubuntu MATE 15.04 sur une RaspBerry Pi 2 - ou 3 -, c’est juste l’image qui change. Il faut aller [la télécharger par ici](http://master.dl.sourceforge.net/project/ubuntu-mate/15.04/armhf/ubuntu-mate-15.04-desktop-armhf-raspberry-pi-2.img.bz2). Lors du premier démarrage, vous pourrez customiser Ubuntu MATE et créer votre utilisateur. L’installer n’est cependant pas parfait et il vous faudra réaliser quelques actions – agrandir le file system, créer du swap, … – à la main, c’est ce que je vais décrire ici.


## Installer les programmes vitaux

Même s’il y a déjà presque tout ce qu’il faut dans cette distribution, il manque quand même quelques utilitaire vitaux – selon moi. Vous comment les installer.

    $ sudo aptitude update
    $ sudo aptitude install htop openssh-server
    $ sudo aptitude upgrade
    $ sudo reboot

J’ajoute une petite mise à jour du système au passage 
 