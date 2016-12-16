+++
tags = ["Copie bit à bit","dd","Linux","USB"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
slug = "linux-creer-une-copie-bit-a-bit-dune-clef-usb"
title = "[Linux] Créer une copie bit à bit d'une clef USB"
author = "MrRaph_"
categories = ["Copie bit à bit","dd","Linux","USB"]
description = ""
draft = false
date = 2014-10-24T10:24:47Z

+++


Linux propose un outil en ligne de commande qui permet de faire de la copie bit à bit d’un fichier/périphérique vers un autre, son petit nom : dd.  
  
  

Cet outil est utile notamment pour sauvegarder le contenu de clef USB, dans l’exemple, je vais sauvegarder une clef USB bootable. DD copie également la MBR de la clef.

 

root@Baal:/etc/varnish# dd if=/dev/sdd1 of=~/AldaKey.img 15628288+0 enregistrements lus 15628288+0 enregistrements écrits 8001683456 octets (8,0 GB) copiés, 732,343 s, 10,9 MB/s

Description des paramètres :

- **if** : (Input File) le fichier/périphérique en entrée
- **of** : (Output File) le fichier/périphérique en sortie.

Dans mon cas, l’entrée est donc la clef et la sortie est le fichier « ~/AldaKey.img ».

 


