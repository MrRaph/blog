+++
description = ""
draft = false
categories = ["Centos","Fedora","Linux","Swap","Trucs et Astuces","Ubuntu"]
tags = ["Centos","Fedora","Linux","Swap","Trucs et Astuces","Ubuntu"]
title = "Identifier les processus swapés sur Linux"
date = 2015-04-22T10:04:55Z
author = "MrRaph_"
image = "https://techan.fr/images/2014/11/Linux.png"
slug = "identifier-les-processus-swapes-sur-linux"

+++


Il est fréquent de voir un Linux swaper, c’est normal et l’agressivité du processus de mise en swap peut être réglée (voir [[Linux Tuning] Ajuster la swappiness](https://techan.fr/linux-tuning-ajuster-la-swappiness/)). Cependant, il peut être intéressant de savoir quels processus sont actuellement swapés. Malheureusement, il est assez compliqué de trouver cette information dans le système.

<div class="wp-caption aligncenter" id="attachment_1222" style="width: 876px">[![Identifier les processus swapés sur Linux](https://techan.fr/images/2015/04/htop_swap.png)](https://techan.fr/images/2015/04/htop_swap.png)Un Linux qui swape un petit peu

</div> 

Voici donc une commande qui permet de lister tous les processus présents dans le swap, ainsi que la taille qu’ils occupent dans cet espace.

 


## La commande

    # for file in /proc/*/status ; do awk '/VmSwap|Name|^Pid:/{printf $2 " " $4 " " $3}END{ print ""}' $file; done | sort -k 3 -n -r | less

 

Voici un extrait du retour de cette commande sur l’une de mes machines.

    mysqld 27370 120096 kB
    memcached 5388 65860 kB
    java 14287 55308 kB
    uwsgi 5436 47300 kB
    uwsgi 5434 44684 kB
    uwsgi 5431 42552 kB
    uwsgi 5432 39248 kB
    uwsgi 5433 32960 kB
    uwsgi 5437 29628 kB
    uwsgi 5420 20568 kB
    uwsgi 5438 16412 kB
    uwsgi 5435 16316 kB
    /usr/sbin/postg 11405 14304 kB
    named 1721 14152 kB
    MCMA2_Linux_x86 15355 11212 kB
    /usr/sbin/apach 24671 10704 kB
    /usr/sbin/apach 26361 6832 kB

On voit que MySQL, memcached, uwsgi et apache ont été swapés, ainsi que la taille qu’il occupent dans le swap – près de 117 Mo pour MySQL.

 


## Forcer un vidage du swap

Il est possible de vider le cache de manière brutale en désactivant/réactivant l’espace de swap. La désactivation de l’espace de swap force le Linux a écrire les pages en swap dans sa mémoire. La  réactivation rend l’espace de swap de nouveau disponible.

 

*<span style="color: #ff0000;">**<span style="text-decoration: underline;">Attention :</span> Avant de vider le swap, assurez vous d’avoir assez de mémoire disponible pour absorber le contenu du swap, et même un peu de marge, sinon le système risque de killer des processus !**</span>*

 

    # swapoff -a # swapon -a

<span style="text-decoration: underline;">Note :</span> Le vidage du swap peut être un peu long en fonction de la taille utilisée.

<div class="wp-caption aligncenter" id="attachment_1225" style="width: 882px">[![Identifier les processus swapés sur Linux](https://techan.fr/images/2015/04/htop_swap_vide.jpg)](https://techan.fr/images/2015/04/htop_swap_vide.jpg)Après le vidage du swap

</div> 
