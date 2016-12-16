+++
categories = ["OSMC","PlexBMC","Raspberry"]
slug = "osmc-avec-plexbmc-et-le-replay-francais-sur-raspberry-pi-2"
title = "OSMC avec PleXBMC et le Replay Francais sur Raspberry PI 2"
tags = ["OSMC","PlexBMC","Raspberry"]
image = "https://techan.fr/wp-content/uploads/2015/06/Raspi_Colour_R.png"
description = ""
draft = false
date = 2015-09-23T11:17:16Z
author = "MrRaph_"

+++


Me voilà l’heureux propriétaire de deux nouvelles [Rapsberry PI](https://www.amazon.fr/gp/product/B01CYQJP9O/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1642&creative=6746&creativeASIN=B01CYQJP9O&linkCode=as2&tag=techan0f-21), ces petites nouvelles vont remplacer – avantageusement – la box TV fournie par mon fournisseur d’accès à internet. Comme je dispose d’un serveur Plex, il aurait été logique que j’installe la distribution [Rasplex](http://www.rasplex.com/) sur mes petites PI. Rasplex est une distribution basée sur OpenELEC sur laquelle est implantée le client Plex – Plex Home Theater. Cette distribution est très très agréable a utiliser et fonctionne à merveille, mais dans mon cas, je souhaitais pouvoir accéder aux sites de replay depuis mes télévisions, ce que Plex et donc Rasplex ne proposent pas.

 

J’avais remarqué que plusieurs addons intéressants existaient pour Kodi – anciennement XMBC – notamment un qui permet d’accéder au serveur Plex via Kodi – PleXBMC et un seconde qui permet d’accéder aux vidéos en Replay – FReplay. C’est donc pour cela que j’ai opté pour [OSMC](https://osmc.tv/), une distribution pour la PI basée sur Debian et embarquant Kodi.

Je vais décrire ici comment disposer d’OSMC avec PleXBMC et le Replay Francais sur Raspberry PI 2.


## Installation d’OSMC sur la PI

Le processus d’installation d’OSMC est très simple et peut se depuis n’importe quel système d’exploitation. Les étapes sont simples et un installeur va vous guider. Voire dans la partie **Sources** pour le lien de téléchargement.

**Note :** Il est conseillé par OSMC de disposer d'un <a rel="nofollow" href="https://www.amazon.fr/gp/product/B013UDL5RU/ref=as_li_tl?ie=UTF8&camp=1642&creative=6746&creativeASIN=B013UDL5RU&linkCode=as2&tag=techan0f-21">carte mémoire microSDHC de classe 10</a><img src="http://ir-fr.amazon-adsystem.com/e/ir?t=techan0f-21&l=as2&o=8&a=B013UDL5RU" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />, ceci permet à la [Rapsberry PI](https://www.amazon.fr/gp/product/B01CYQJP9O/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1642&creative=6746&creativeASIN=B01CYQJP9O&linkCode=as2&tag=techan0f-21) de réaliser des lecture/écriture performantes.


[![OSMC avec PleXBMC et le Replay Francais sur Raspberry PI 2](https://techan.fr/wp-content/uploads/2015/09/winstaller.png)](https://techan.fr/wp-content/uploads/2015/09/winstaller.png)

Lorsque que votre [Rapsberry PI](https://www.amazon.fr/gp/product/B01CYQJP9O/ref=as_li_qf_sp_asin_il_tl?ie=UTF8&camp=1642&creative=6746&creativeASIN=B01CYQJP9O&linkCode=as2&tag=techan0f-21) est correctement installé et qu’OSMC a démarré pour la première fois, récupérer l’adresse IP de votre PI.


## Installation des addons

Pour cela, connectez-vous en SSH sur votre PI, vous pouvez utiliser pour cela le programme [PuTTY](http://the.earth.li/~sgtatham/putty/latest/x86/putty.exe).

Le login par défaut est **osmc** et le mot de passe par défaut est **osmc**.

 

Tout d’abord, faisons quelques mises à jour du système.

    sudo apt-get update sudo apt-get upgrade sudo apt-get dist-upgrade

 

Nous allons maintenant télécharger les addons directement sur la PI.

    wget https://github.com/hippojay/plugin.video.plexbmc/archive/helix.zip
    wget https://github.com/hippojay/script.plexbmc.helper/archive/master.zip -O script.plexbmc.helper.zip
    wget https://github.com/pecinko/skin.amber/archive/master.zip -O amber.zip
    wget http://media-passion.fr/addons/Download.php/plugin.video.freplay/plugin.video.freplay-0.5.5.zip

 

Puis activer les addons dans cet ordre :

1. helix.zip
2. script.plexbmc.helper.zip
3. amber.zip
4. plugin.video.freplay-0.5.5.zip

 

La marche à suivre pour installer les plugins est la suivante. Depuis les paramètres de Kodi, allez dans la section **Extensions** puis dans l’options **Installer des extensions**. Ensuite de faire :

1. Installer depuis un fichier ZIP
2. Choisr « Depuis le dossier personnel »
3. Sélectionner l’addon et il s’installe.

 

Lorsque vous installer le thème **Amber**, Kodi va vous demander si vous souhaiter utiliser ce thème, répondez **oui**.

 

Lorsque tout est installé, vous utiliserez alors le thème **Amber**, naviguer dans l’interface jusqu’à la section **Paramètres**, appuyer sur la flèche vers le bas du clavier pour sélectionner l’option **Aller vers Plex**, validez avec **Entrée** et le tour est joué !

 


## Ajouter du swap

Ajouter du swap sur OSMC permet d’accroitre un peu les perfomances du système en lui ajoutant de la mémoire vive supplémentaire – moins performante car placée sur la carte SD.

 

Voici les actions a réaliser pour ajouter du swap. Tout d’abord, il faudra vous connecter à la PI en SSH et lancer les commandes suivantes.

 

    sudo dd if=/dev/zero of=/swap count=2097152
    sudo mkswap /swap
    sudo chmod 600 /swap

 

Éditez le fichier **/etc/fstab.**

    sudo vi /etc/fstab

Ajoutez la ligne suivante à la fin de ce fichier.

    /swap none swap defaults,_netdev,nobootwait 0 0

 

Editez le fichier **/etc/init.d/swap**.

    sudo vi /etc/init.d/swap

Ajoutez-y le contenu suivant.

    #!/bin/bash
    ### BEGIN INIT INFO
    # Provides: mountswap
    # Required-Start: $network $local_fs
    # Required-Stop: $local_fs
    # Default-Start: 2 3 4 5
    # Default-Stop: 0 1 6
    # X-Start-After: nbd-client
    # Short-Description: Workaround to mount an NBD device as swap OS device. IMPORTANT: add '_netdev' mount option to the swap device in /etc/fstab 
    ### END INIT INFO
    . /lib/lsb/init-functions
    case "${1:-''}" in 'start') log_daemon_msg "Activating swap devices" /sbin/swapon -a [ $? -eq 0 ] && log_end_msg 0 || log_end_msg 1 ;; esac

 

On rend le script exécutable et on active le swap !

    sudo chmod +x /etc/init.d/swap sudo swapon -a

 

La commande suivante permet de vérifier que le swap est bien actif sur le système.

    sudo free -m
    total used free shared buffers cached
    Mem: 2023 1867 156 57 134 1232
    -/+ buffers/cache: 500 1522
    Swap: 1023 0 1023

 

 


## Sources

- [ilogblog.wordpress.com (Anglais)](https://ilogblog.wordpress.com/2015/06/03/osmc-with-plexbmc/)
- [OSMC – Download](https://osmc.tv/download/)


