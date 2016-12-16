+++
date = 2014-10-17T10:51:50Z
categories = ["Linux","Mac","Time Capsule"]
image = "https://techan.fr/wp-content/uploads/2014/10/tm.png"
description = ""
slug = "linux-transformer-votre-linux-en-time-capsule"
draft = false
title = "[Linux] Transformer votre Linux en Time Capsule"
tags = ["Linux","Mac","Time Capsule"]
author = "MrRaph_"

+++


Si vous disposez d’un Mac que vous voulez sauvegarder sur le réseau, vous avez le choix d’acheter un boitier Apple proposant Time Machine. Mais cette solution peut revenir assez cher. Par contre, si vous disposez d’un Linux avec un peu (beaucoup) de disque disponible, vous pouvez faire croire à votre Mac qu’il est une Time Capsule.  
  
  

Voici la marche a suivre pour ce faire.

 

### Sur le Linux

##### Installer et configurer netatalk

Installez netatalk.

aptitude install netatalk

 

Éditez le fichier de configuration de NetATalk.

vi /etc/default/netatalk

 

Son contenu doit ressembler à cela, modulo le nom du serveur.

cat /etc/default/netatalk | grep -ve "^#" -e "^$" ATALK_NAME=Baal ATALK_UNIX_CHARSET='LOCALE' ATALK_MAC_CHARSET='MAC_ROMAN' export ATALK_UNIX_CHARSET export ATALK_MAC_CHARSET CNID_METAD_RUN=yes AFPD_RUN=yes ATALKD_RUN=no PAPD_RUN=no TIMELORD_RUN=no A2BOOT_RUN=no

 

Éditez ensuite les partages proposés via AppleTalk.

vi /etc/netatalk/AppleVolumes.default

 

Son contenu doit ressemble à ceci :

cat /etc/netatalk/AppleVolumes.default | grep -ve "^#" -e "^$" :DEFAULT: options:upriv,usedots ~/ "Home Directory" /TimeMachine "Time Capsule" allow:@raphael options:usedots,upriv,tm

Dans mon cas, le dossier qui va être utilisé pour les sauvegardes Time Machine est /TimeMachine et l’utilisateur autorisé est « raphael ». Il s’agit d’un utilisateur sur le Linux, pas d’un utilisateur sur le Mac.

 

On redémarrer netatalk.

service netatalk restart Restarting Netatalk Daemons (this will take a while)Stopping Netatalk Daemons: afpd cnid_metad papd timelord atalkd. ..Starting Netatalk services (this will take a while): cnid_metad afpd. done.

##### 

##### Installer et configurer avahi

Avahi est l’implémentation de Bonjour sur Linux, il faut l’installer avec la commande suivante.

aptitude install avahi-daemon libnss-mdns

 

Ensuite, il nous faut éditer quelques fichiers de configuration.

vi /etc/nsswitch.conf

La ligne :

hosts: files mdns4_minimal [NOTFOUND=return] dns

Doit devenir :

hosts: files mdns4_minimal [NOTFOUND=return] dns mdns4 mdns

Il faut créer un fichier de configuration pour qu’avahi propose afp comme service.

vi /etc/avahi/services/afpd.service

Ajouter ce contenu au fichier :

<?xml version="1.0" standalone='no'?><!--*-nxml-*-->  <service-group> <name replace-wildcards="yes">%h</name> <service> <type>_afpovertcp._tcp</type> <port>548</port> </service> <service> <type>_device-info._tcp</type> <port>0</port> <txt-record>model=Xserve</txt-record> </service> </service-group>

### 

On redémarre avahi :

service avahi-daemon restart avahi-daemon stop/waiting avahi-daemon start/running, process 23251

Tout est bon sur notre Linux ! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

### Sur Le Mac

Il faut ouvrir le terminal, et taper la commande suivante :

defaults write com.apple.systempreferences TMShowUnsupportedNetworkVolumes 1

 

Ensuite, tout se fait graphiquement !

Ouvrez le menu Time Machine et laissez vous guider.

 

<div class="wp-caption aligncenter" id="attachment_258" style="width: 310px">[![time_machine_setup_1](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_1-300x173.png)](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_1.png)Cliquer sur « Choisir un disque… »

</div> 

<div class="wp-caption aligncenter" id="attachment_259" style="width: 310px">[![Cliquer sur le disque réseau nouvellement créé. Dans mon cas : "Time Capsule sur Baal".](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_2-300x172.png)](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_2.png)Cliquer sur le disque réseau nouvellement créé.  
Dans mon cas : « Time Capsule sur Baal ».

</div><div class="wp-caption aligncenter" id="attachment_260" style="width: 310px">[![Dans la fenêtre d'authentification, il faut renseigner le compte Linux utilisé dans le fichier AppleVolumes.default et son mot de passe.](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_3-300x171.png)](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_3.png)Dans la fenêtre d’authentification, il faut renseigner le compte Linux utilisé dans le fichier AppleVolumes.default et son mot de passe.

</div><div class="wp-caption aligncenter" id="attachment_261" style="width: 310px">[![Et voilà ! Vous êtes paré !](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_4-300x172.png)](https://techan.fr/wp-content/uploads/2014/10/time_machine_setup_4.png)Et voilà ! Vous êtes paré !

</div> 


