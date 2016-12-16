+++
author = "MrRaph_"
image = "/images/2016/12/playonlinux.png"
description = ""
categories = ["PlayOnLinux","Ubuntu","Office","Trucs et Astuces"]
tags = ["PlayOnLinux","Ubuntu","Office","Trucs et Astuces"]
slug = "installer-office-2013-sur-ubuntu"
draft = true
title = "Installer Office 2013 sur Ubuntu"
date = 2016-12-14T11:32:27Z

+++



# Tout d'abord, les prérequis !

Dans un premier temps, il faudra que vous ayez installé quelques prérequis dont [PlayOnLinux](https://www.playonlinux.com/fr/) et Wine. La commande ci-dessous vous installera tout cela !

    wget -q "http://deb.playonlinux.com/public.gpg" -O- | sudo apt-key add -
    sudo wget http://deb.playonlinux.com/playonlinux_trusty.list -O /etc/apt/sources.list.d/playonlinux.list
    sudo apt-get update
    sudo apt-get install wine:i386 playonlinux winbind p11-kit:i386

L'autre prérequis de taille est de disposer d'une image ISO d'Office 2013 en **32 bits**. L'installation ne fonctionne pas avec une version 64 bits ni avec l'installeur en ligne - celui qui télécharge Office pendant l'installation - fourni sur le site de Microsoft.

Il ne nous reste plus qu'à monter - ouvrir - l'image ISO, pour cela, faites un clic droit sur le fichier et choisissez l'option "Ouvrir avec une autre application".

![Ouvrir avec une autre application](/content/images/2016/12/office_mount_iso_1.png)

Une nouvelle fenêtre s'ouvre, séléctionnez l'application "Monteur d'image disque" et cliquez sur "Sélectionner".

![Sélectionner "Monteur d'image disque"](/content/images/2016/12/office_mount_iso.png)


# Et maintenant, en avant !

Rentrons maintenant dans le vif du sujet, lancez [PlayOnLinux](https://www.playonlinux.com/fr/) et cliquer sur le bouton "Installer". Une fenêtre s'ouvre listant le programmes supportés par l'outil.

![Rechercher Office 2013](/content/images/2016/12/pol_install.png)

Vérifiez bien que la case "En test" est cochée, sélectionnez "Microsoft Office 2013" et cliquez sur "Installer".

![Acceptez l'avertissement](/content/images/2016/12/pol_accept_warning.png)

Acceptez l'avertissement que s'affiche.

![Cliquez sur Suivant](/content/images/2016/12/pol_office_install_1.png)


Cliquez sur "Suivant" pour passer la fenêtre de bienvenue.

![Utiliser le DVD-ROM](/content/images/2016/12/pol_office_install_2.png)

Dans cette nouvelle vue, choisissez l'option "Utiliser le(s) DVD-ROM(s)" puis cliquez sur "Suivant".

![Sélectionner le disque](/content/images/2016/12/pol_office_install_3.png)

Dans cette vue, vous devriez voir le nom du l'image ISO que l'on a montée dans les prérequis, sélectionnez la et cliquez sur "Suivant".

![Choisir "Overwrite"](/content/images/2016/12/pol_office_install_4.png)

Si PlayOnLinux vous montre cette vue, choisissez "Overwrite" et cliquez sur "Suivant".