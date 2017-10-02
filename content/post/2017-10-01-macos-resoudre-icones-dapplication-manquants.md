+++
slug = "macos-resoudre-icones-dapplication-manquants"
draft = false
date = "2017-10-01T14:46:12+01:00"
image = "/images/2017/10/macos_bad_icon.png"
type = "post"
description = ""
title = "macOS, résoudre le problème des icônes d'application manquants"
author = "MrRaph_"
categories = ["Trucs et Astuces","macOS","SOS", "Trucs et Astuces"]
tags = ["Trucs et Astuces","macOS","SOS", "Trucs et Astuces"]
+++



Parfois, il arrive que les icônes d'application disparaissent sur macOS, ce n'est pas très grave, mais cela peut vite devenir pénible. Il devient en effet vite compliqué d'identifier les applications lorsque l'on a des icônes toutes identiques comme ceci.

![Icônes moches](/images/2017/10/macos_bad_icon.png)


On peut également constater des icônes manquantes dans le dossier Applications du Mac, la méthode de résolution sera identique.


# macOS, résoudre le problème des icônes d'application manquants

Il existe toute fois un moyen de résoudre ceci, via le Terminal. Il s'agit en fait d'un cache qui perd les pédalles. La commande que nous passerons dans le Terminal permet de le remettre d'aplomb.

Voici ladite commande :

    /System/Library/Frameworks/CoreServices.framework/Versions/A/Frameworks/LaunchServices.framework/Versions/A/Support/lsregister -kill -seed


Si toute fois cette commande ne suffisait pas, il faut forcer un rechargement du Dock avec la commande suivante.

    killall Dock

Ceci devrait faire rentrer les choses dans l'ordre. Si une ou deux applications se montrent récalcitrantes après ces deux commandes, il suffira de le retirer et de le remettre dans le Dock.