+++
date = 2014-11-14T09:52:45Z
author = "MrRaph_"
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
draft = false
title = "[NFS] Lister les partages NFS sur une machine distante"
categories = ["Linux","NFS","Troubleshoot","TrucsAstuces"]
tags = ["Linux","NFS","Troubleshoot","TrucsAstuces"]
slug = "nfs-lister-les-partages-nfs-sur-une-machine-distante"

+++


Voici une commande qui peut aider nos amis Linuxiens que j’ai découverte lors d’investigations sur un serveur NAS récalcitrant.

Elle permet de lister depuis une autre machine Linux les exprots NFS fait sur un serveur. Elle montre également les hôtes ayant des autorisations sur les partages.  

  

    raphael@xxxx:~$ showmount -e xxxx.xxxx.fr
    Export list for xxxx.xxxx.fr:
    /partage 10.0.0.200

On voit ici que la machine xxxx.xxxx.fr partage /partage avec la machine 10.0.0.200.
