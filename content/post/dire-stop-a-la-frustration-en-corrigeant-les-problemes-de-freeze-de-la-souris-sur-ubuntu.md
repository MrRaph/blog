+++
title = "Dire Stop à la frustration en corrigeant les problèmes de freeze de la souris sur Ubuntu"
image = "/images/2016/12/touchpad_64.png"
slug = "dire-stop-a-la-frustration-en-corrigeant-les-problemes-de-freeze-de-la-souris-sur-ubuntu"
draft = false
date = 2016-12-12T12:48:35Z
author = "MrRaph_"
categories = ["Ubuntu","Trucs et Astuces"]
tags = ["Ubuntu","Trucs et Astuces"]
description = ""

+++

Depuis mainteant presque huit mois, je n'utilises plus qu'Ubuntu pour mes besoins professionels. Bon, je l'avoue tout de suite, j'ai quand même une VM Windows pour certains besoins - client VPN exotiques, applications très spécifiques, ... J'ai réussi à trouver une solution satisfaisante pour tous mes besoins.

Je travaille sur un poste Lenovo, autant dire que je n'utilise pas le pavé tactile, en fait, je n'utilise ces choses que sur mon Mac. Je trouve - c'est un avis personnel hein ! - que les pavé tactiles non Mac sont beaucoup trop limités et limitants. J'utilise donc en permanence ma bonne vieille <a target="_blank" href="https://www.amazon.fr/gp/product/B0152YTWPW/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1642&creative=6746&creativeASIN=B0152YTWPW&linkCode=as2&tag=techan0f-21">Razer Orochi</a> quelque soient mes besoins et ce depuis des années. Sa capacité à être à la fois une souris Bluetooth et une souris filaire couplée à sa petite taille sont des qualités essentielles à ma mobilité.

Malheureuseument, sous Ubuntu cette bonne vieille souris freezait de manière intempestive, le pointeur qui se bloque en plein milieu d'un déplacement, LE truc carrément pénible. Il est donc temps de dire Stop à la frustration en corrigeant les problèmes de freeze de la souris sur Ubuntu !

J'ai sévi en deux temps, tout d'abord, j'ai installé des pilotes Razer pour Ubuntu, ensuite j'ai installé Touchpad-indicator. Ce dernier programme bloque le pavé tactile lorsqu'une souris USB est connectée.


# Trop long, j'ai pas lu

Voici les commandes utilisées dans ce post pour ajouter les deux [PPA](https://doc.ubuntu-fr.org/ppa), installation des paquets et activation du module noyau Razer.

    sudo add-apt-repository ppa:atareao/atareao
    sudo add-apt-repository ppa:terrz/razerutils
    sudo apt-get update
    sudo apt install touchpad-indicator python3-razer razer-kernel-modules-dkms razer-daemon razer-doc
    sudo modprobe razerkbd

# Première action, installer le pilote Razer

Le pilote pour les produits Razer en fourni sous la forme d'un module pour le noyau Linux. Nous devons tout d'abord, ajouter le [PPA](https://doc.ubuntu-fr.org/ppa) nécessaire.

    sudo add-apt-repository ppa:terrz/razerutils
    sudo apt-get update

Maintenant que nous disposons du nouveau dépot, et que les sources d'APT sont à jour, nous installons les paquets contenant le pilote.

    sudo apt install python3-razer razer-kernel-modules-dkms razer-daemon razer-doc

Pour que le pilote soit opérationnel - pour que le module noyau soit chargé - il faut _redémarrer_ la machine. Si vous ne pouvez pas le faire, ou que vous avez tout simplement la flemme de rémarrer - je vous comprend ! - vous pouvez activer le module manuellement avec la commande qui suit.

    sudo modprobe razerkbd


# Deuxième action, installer touchpad-indicator


## Installation de l'outil


L'application `Touchpad-indicator` permet de désactiver le touchpad lorsqu'une souris USB est connectée à l'ordinateur. Ceci est très pratique lorsque vous utilisez beaucoup le clavier, cela évite les changements de fenêtres intempestifs et pleins de petits tracas ...

Cette application ne fait pas partie des dépots officiels, il faut donc, de nouveau, ajouter un [PPA](https://doc.ubuntu-fr.org/ppa).

    sudo add-apt-repository ppa:atareao/atareao
    sudo apt-get update

L'installation de l'application se fait en utilisant la commande qui suit.

    sudo apt install touchpad-indicator


## Configuration de l'outil

Touchpad-indicator démarre lorsque vous ouvrez votre session sur Ubuntu. Il y a cependant quelques actions de configuration simples à réaliser à son permier lancement. Pour cela, lancez l'application "Touchpad-indicator" depuis le launcher d'Ubuntu.

**Note :** Si vous venez d'installer le programme, il est possible qu'il n'apparaîssent pas dans la liste des programmes que vous propose le launcher. Pour qu'il apparaîse, fermez et rouvrez votre session ou redémarrez l'ordinateur.


La première chose à faire est de vérifier qu'un raccourci clavier est bien paramètré et activé. Je vous conseille d'en définir un le cas échéant. C'est extrêmement pratique, surtout lorsque l'ordinateur - ou Touchpad-indicator - n'a pas détecté que la souris a été débranchée, c'est très rare, mais ça arrive ...

![Définir et activer un raccourci clavier](/content/images/2016/12/touchpad-indicator_raccourci.png)


Rendez-vous ensuite dans l'onglet "Actions" afin d'activer LA fonctionalité de l'outil, la désactivation du touchpad lorsqu'un souris est connectée.


![Activer la désactivation du touchpad lorsqu'une souris est connectée](/content/images/2016/12/touchpad-indicator_actions.png)


Finalement, rendez-vous dans l'onglet "Configuration" afin d'activer Touchpad-indicator au lancement de votre session.

![](/content/images/2016/12/touchpad-indicator_demarrage.png)


# Sources

* [Lauchpad : Touchpad-indicator](https://launchpad.net/touchpad-indicator)
* [Lauchpad : Razerutils](https://launchpad.net/~terrz/+archive/ubuntu/razerutils)
