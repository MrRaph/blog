+++
slug = "optimiser-la-consommation-electrique-de-linux"
title = "Optimiser la consommation électrique de Linux"
date = 2015-02-06T10:21:09Z
tags = ["Linux","tlp","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
description = ""
author = "MrRaph_"
categories = ["Linux","tlp","Trucs et Astuces"]
draft = false

+++


Je suis tombé plutôt par hasard sur un outil en ligne de commande qui permet d’optimiser la consommation électrique de Linux. Il se base pour cela sur pas mal d’outils bas niveau que l’on a pas forcément l’idée de configurer par soi même. Cet utilitaire permet de gagner de l’autonomie lorsqu’on utilise un portable sur batterie mais également de réduire sa facture d’électricité quand on a une machine toujours allumée. Je suis dans ce deuxième cas.

L’outil est capable de mettre les disques en veille lorsqu’ils ne sont pas utilisés, mettre les carte PCI/PCIe, les périphériques USB, la carte Wifi en veille et de baisser la fréquence du CPU tout cela dynamiquement en fonction de l’activité de la machine.

Cet outil s’appelle « tlp », je vous parlerai également de « powertop » qui permet de monitorer en temps réel l’utilisation de puissance électrique de la machine. TLP peut être configuré pour une utilisation sur batterie et/ou sur branché sur le courant.


## Installation des packages

yum install tlp tlp-rdw smartmontools powertop

La configuration de TLP se fait dans le fichier : /etc/default/tlp, voici les paramètres que j’ai changé dans un premier temps.

#CPU_SCALING_GOVERNOR_ON_AC=ondemand -> CPU_SCALING_GOVERNOR_ON_AC=ondemand #CPU_SCALING_GOVERNOR_ON_BAT=ondemand -> CPU_SCALING_GOVERNOR_ON_BAT=ondemand SCHED_POWERSAVE_ON_AC=0 -> SCHED_POWERSAVE_ON_AC=1 DISK_DEVICES="sda sdb" -> DISK_DEVICES="sda sdb sdc sdd" DISK_APM_LEVEL_ON_AC="254 254" -> DISK_APM_LEVEL_ON_AC="254 127 127 127"

Ensuite, on démarre TLP :

[root@xxxxx ~]# tlp ac TLP started in ac mode.

Ensuite, vous pouvez récupérer des informations avec les commandes suivantes :

tlp stat powertop

Par exemple, la commande « powertop » m’apprend que la fréquence de mon CPU0 est 1,7 GHz alors que la fréquence nominale du CPU est 3,3 GHz.

[![Optimiser la consommation électrique de Linux](https://techan.fr/wp-content/uploads/2015/02/screenshot.1423041272.png)](https://techan.fr/wp-content/uploads/2015/02/screenshot.1423041272.png)

La commande « tlp stat » donne quand a elle des informations sur le système et les paramètres que tlp lui applique.

[![Optimiser la consommation électrique de Linux](https://techan.fr/wp-content/uploads/2015/02/screenshot.1423041485.png)](https://techan.fr/wp-content/uploads/2015/02/screenshot.1423041485.png)

Ici , on voit les bornes de fréquences qu’impose tlp au CPU.


