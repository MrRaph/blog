+++
categories = ["OneDrive","Trcus Astuces","Ubuntu"]
tags = ["OneDrive","Trcus Astuces","Ubuntu"]
description = ""
date = 2015-05-12T15:37:41Z
author = "MrRaph_"
image = "https://techan.fr/images/2015/05/ubuntu_et_onedrive_logo.jpg"
slug = "synchroniser-votre-onedrive-sur-ubuntu"
draft = false
title = "Synchroniser votre OneDrive sur Ubuntu"

+++


J’utilise [OneDrive ](https://onedrive.live.com/)depuis quelques temps pour synchroniser mes documentations client entre mes différents ordinateurs. C’est également très pratique pour partage ces informations avec les clients. De plus, une petite astuce – toute petite hein – permet de passer des 15 Go gracieusement offerts par Microsoft à 30 Go. OneDrive vous offre ces 15 Go supplémentaires dès lors que vous activer la sauvegarde de vos photos dans l’outil. Vous pouvez le désactiver directement, vous conserverez cet espace.

 

Il me manquait toute fois la possibilité de synchroniser ces dossiers sur mon serveur Ubuntu à la maison – une sauvegarde de plus, au cas ou – mais évidement Microsoft ne propose pas d’application pour Linux, contrairement à OS X. Heureusement, de joyeux bidouilleurs ont mis les mains dans le cambouis pour nous proposer une application à la fois en ligne de commande et en interface graphique.

 


## Installation des pré requis

 

raphael@xxxx:~/bin/onedrive-d$ sudo aptitude install python3-gi psutils python3-psutil python3-dev python3-gobject inotify-tools python3-setuptools

 

Une fois les paquets requis installés, il faut récupérer le programme depuis GitHub.

raphael@xxxx:~/bin$ git clone https://github.com/xybu/onedrive-d.git Clonage dans 'onedrive-d'... remote: Counting objects: 876, done. remote: Total 876 (delta 0), reused 0 (delta 0), pack-reused 876 Réception d'objets: 100% (876/876), 287.45 KiB | 0 bytes/s, fait. Résolution des deltas: 100% (472/472), fait. Vérification de la connectivité... fait.

 


## Installation de OneDrive-d

 

L’installation en elle même est très simple, les scripts fournis vont tout faire pour vous, il suffit de les lancer !

raphael@xxxx:~/bin$ cd onedrive-d/ raphael@xxxx:~/bin/onedrive-d$ sudo python3 setup.py install raphael@xxxx:~/bin/onedrive-d$ sudo python3 setup.py clean

 

On termine l’installation en créant le dossier de configuration et le fichier de log.

raphael@xxxx:~/bin/onedrive-d$ mkdir ~/.onedrive raphael@xxxx:~/bin/onedrive-d$ cp ./onedrive_d/res/default_ignore.ini ~/.onedrive/ignore_v2.ini raphael@xxxx:~/bin/onedrive-d$ sudo touch /var/log/onedrive_d.log raphael@xxxx:~/bin/onedrive-d$ sudo chown `whoami` /var/log/onedrive_d.log

 


## Configuration de OneDrive-d

 

Pour configurer l’outil, c’est comme pour l’installation, un outil va vous guider. J’ai personnellement choisi de le configurer et de l’utiliser en ligne de commande – je préfère – sachez qu’il est possible de faire pareil avec une interface graphique. Il suffit d’ajouter l’option « –ui=gtk » à la fin de la commande.

raphael@xxxx:~/bin/onedrive-d$ onedrive-pref Loading configuration ... OK [2015-05-12 14:14:14,326] DEBUG: thread_mgr: started. Setting up onedrive-d... (STEP 1/4) Do you want to authorize sign in with your OneDrive account? [Y/n] You will need to visit the OneDrive sign-in page in a browser, log in and authorize onedrive-d, and then copy and paste the callback URL, which should start with "https://login.live.com/oauth20_desktop.srf". The callback URL is the URL where the sign-in page finally goes blank. Please visit the sign-in URL in your browser: https://login.live.com/oauth20_authorize.srf?client_id=00000000XXXXXXXX&redirect_uri=https%3A%2F%2Flogin.live.com%2Foauth20_desktop.srf&locale=en&scope=wl.skydrive+wl.skydrive_update+wl.offline_access&display=touch&response_type=code Please paste the callback URL:

A ce stade, il va vous falloir copier l’URL fourni par le programme de configuration dans votre navigateur Web préféré. L’URL à cette tête là : « https://login.live.com/oauth20_authorize.srf?client_id=00000000XXXXXXXX&redirect_uri=https%3A%2F%2Flogin.live.com%2Foauth20_desktop.srf&locale=en&scope=wl.skydrive+wl.skydrive_update+wl.offline_access&display=touch&response_type=code »

Une fois que vous aurez chargé la page, il va falloir vous connecter avec votre compte OneDrive.

<div class="wp-caption aligncenter" id="attachment_1362" style="width: 402px">[![Synchroniser votre OneDrive sur Ubuntu](https://techan.fr/images/2015/05/screenshot.458.jpg)](https://techan.fr/images/2015/05/screenshot.458.jpg)Connecter vous à votre compte OneDrive

</div> 

Et autoriser l’application.

 

<div class="wp-caption aligncenter" id="attachment_1359" style="width: 375px">[![Synchroniser votre OneDrive sur Ubuntu](https://techan.fr/images/2015/05/screenshot.455.jpg)](https://techan.fr/images/2015/05/screenshot.455.jpg)Autoriser ensuite l’application à accéder à votre OneDrive.

</div> 

Vous allez être redirigé vers une page blanche, copiez son URL et donnez la en réponse au programme d’installation. Vous avez encore à répondre à quelques questions et ça sera prêt !

 

[2015-05-12 14:24:38,125] DEBUG: MainThread: config saved. onedrive-d has been successfully authorized. (STEP 2/4) Do you want to specify path to local OneDrive repository? [Y/n] Please enter the abs path to sync with your OneDrive (default: /home/raphael/OneDrive): The path "/home/raphael/OneDrive" does not exist. Try creating it. [2015-05-12 14:24:41,216] DEBUG: MainThread: config saved. Path successfully set. (STEP 3/4) Do you want to change the numeric settings? [Y/n] y How many seconds to wait for before retrying a network failure (current: 10)? Files larger than what size (in MiB) will be uploaded blocks by blocks? (current: 4.0)? When a file is uploaded blocks by blocks, what is the block size (in KiB)? (current: 512.0)? [2015-05-12 14:16:26,069] DEBUG: MainThread: config saved. (STEP 4/4) Do you want to edit the ignore list file? [Y/n] Calling your default editor... You have exited from the text editor. All steps are finished. [2015-05-12 14:16:36,670] DEBUG: Dummy-2: config saved.

 

Voilà ! Vous pouvez maintenant démarrer onedrive-d !

 

raphael@xxxx:~/bin/onedrive-d$ onedrive-d start Loading configuration ... OK [2015-05-12 14:25:15,551] DEBUG: MainThread: running in daemon node. Starting onedrive-d ... OK

 

Pour qu’il démarre automatiquement avec votre système, ajouter la ligne suivante dans le fichier « /etc/rc.local » avant la ligne « exit 0 ».

 

raphael@xxxx:~/bin/onedrive-d$ sudo vi /etc/rc.local su - raphael -c '/usr/local/bin/onedrive-d start' exit 0

 


## Et voilà, OneDrive se synchronise !

 

raphael@xxxx:~/bin/onedrive-d$ cd ~/OneDrive/ raphael@xxxx:~/OneDrive$ ll total 32 drwxrwxr-x 5 raphael raphael 4096 mai 12 14:25 ./ drwxr-xr-x 26 raphael raphael 4096 mai 12 14:24 ../ drwxr-xr-x 4 raphael raphael 4096 mai 12 14:25 Documents/ drwxr-xr-x 176 raphael raphael 16384 mai 12 14:26 Images/ drwxr-xr-x 2 raphael raphael 4096 mai 12 14:25 Musique/ raphael@baal:~/OneDrive$ du -sh . 125M .

 

**<span style="text-decoration: underline;">Source :</span>**[github](https://github.com/xybu/onedrive-d)


