+++
description = ""
date = 2014-11-14T14:36:51Z
image = "https://techan.fr/images/2014/11/Linux.png"
draft = false
title = "[Linux Tuning] Ajuster la swappiness"
author = "MrRaph_"
categories = ["Linux","Swappiness","TrucsAstuces","Tuning"]
tags = ["Linux","Swappiness","TrucsAstuces","Tuning"]
slug = "linux-tuning-ajuster-la-swappiness"

+++


La swappiness est un paramètres du noyau Linux (modifiable à chaud) prend une valeur entre 0 et 100. Ce paramètre définit la priorité avec laquelle le noyau va swapper ses pages mémoires de la RAM vers le Disque.  

 Linux a tendance a swapper les processes qui tournent longtemps car il n’utilisent jamais tout le temps toute la mémoire qui leur ait dévolue. Genre, Oracle n’a jamais toute sa mémoire active, certaines zones sont « dormantes » et ont tendance à être swappées.

Sur les RedHat / Oracle Linux la valeur est donc par défaut à 60 alors qu’une valeur à 20 ou 10 permettrait d’avoir sans doute plus de perfermormance (moins d’accès disques lorsqu’on remonte des pages mémoires depuis le disque).

Par contre, il ne faut jamais mettre 0, cela empêche totalement le système de swapper, ce qui peut être dommage en cas de manque de RAM (OOM Killer bonjour !).

 


## Modification de la swappiness :

##### A chaud (temporaire):

Pour descendre la valeur à 20 :

    echo 20 > /proc/sys/vm/swappiness

#####  Modification permanente :

Ajouter ou modifier la ligne

    vm.swappiness=20

dans le fichier « /etc/sysctl.conf ».
