+++
description = ""
title = "[Linux] Astuce pour retrouver les permissions sur un fichier"
date = 2014-10-17T15:49:32Z
author = "MrRaph_"
tags = ["Linux","Permissions","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
categories = ["Linux","Permissions","Trucs et Astuces"]
slug = "linux-astuce-pour-retrouver-les-permissions-sur-un-fichier"
draft = false

+++


J’ai du retrouver les permissions octales sur un fichier pour pouvoir les ré-appliquer sur un autre suite à ue montée de version. On écrase les fichiers avec les nouveaux, et paf ! les permissions disparaissent …  

  

J’ai donc du retrouver les permissions sur les anciens pour pouvoir les remettre sur les nouveaux.

 

Pour avoir les permissions originales (en notation octale), on utilisera la commande suivante :

    [root@xxxxxx ~]# stat -c "%a %n" /opt/documentum/product/6.6/bin/documentum 6750 /opt/documentum/product/6.6/bin/documentum

 

Pour les repositionner c’est simple :

    [root@xxxxxx documentum]# chmod 6750 ./product/6.6/bin/documentum

Et le tour est joué !

 

 

 
