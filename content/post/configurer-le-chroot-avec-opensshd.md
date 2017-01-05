+++
author = "MrRaph_"
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
title = "Configurer le chroot avec OpenSSHD"
categories = ["Chroot","Linux","SSH","Trucs et Astuces"]
tags = ["Chroot","Linux","SSH","Trucs et Astuces"]
slug = "configurer-le-chroot-avec-opensshd"
draft = false
date = 2015-01-30T10:20:37Z

+++


Le but de cet article est de décrire comment configurer le chroot avec OpenSSHD. Ce mécanisme permet de « coincer » un utilisateur pouvant se connecter en SSH dans un dossier spécifique. C’est très pratique dans le monde du web pour permettre à des gens de mettre à jour leur site web hébergé sur un serveur mutualisé par exemple. Pour que cela soit possible, il faut qu’OpenSSHD soit au moins installé en version 4.  
  
 Nous allons « chrooter » tous les users qui appartiennent au groupe « sftp ». Le groupe ‘sftp’ doit exister sur la machine :

[root@xxxxxx /etc/ssh> cat /etc/group | grep sftp sftp:x:501:

Si ce n’est pas le cas, le créer avec la commande :

[root@xxxxxx /etc/ssh> groupadd sftp

 


## Configuration du chroot

Editer le fichier de configuration d’openssh-server :

[root@xxxxxx /etc/ssh> vi /etc/ssh/sshd_config

Les dernières lignes du fichier doivent être :

# override default of no subsystems Subsystem sftp internal-sftp # These lines must appear at the *end* of sshd_config Match Group sftp ChrootDirectory /sftp_mnt/%u ForceCommand internal-sftp AllowTcpForwarding no

La ligne ChrootDirectory définie le dossier dans lequel l’utilisateur sera enfermé.

- %h remplace le chemin complet vers le dossier home de l’utilisateur.
- %u sera remplacé par le nom de l’utilisateur.

 

<span style="text-decoration: underline;">Note :</span> La configuration actuelle va donc emprisonner les utilisateurs dans un dossier portant leur nom, placé sous le dossier /sftp_mnt.

Il faut maintenant créer le dossier /sftp_mnt, puis lui donner les droits :

[root@xxxxxx /etc/ssh> chown root: /sftp [root@xxxxxx /etc/ssh> chown 755 /sftp

 

Une fois la configuration sauvée, il faut redémarrer le daemon SSHD :

[root@xxxxxx/etc/ssh> service sshd restart Stopping sshd: [ OK ] Starting sshd: [ OK ]

Les utilisateurs devant être chrootés doivent appartenir au groupe ‘sftp’.

Si l’utilisateur existe déjà :

[root@xxxxxx /etc/ssh> usermod -aG sftp usftp [root@xxxxxx /etc/ssh> id usftp uid=2890(usftp) gid=501(sftp) groups=501(sftp)

 

Le dossier dans lequel va être enfermé l’utilisateur et les dossiers au-dessus de ce dernier doivent impérativement appartenir à root:root :

[root@xxxxxx/app> chown root: /sftp/<nom_utilisateur> [root@xxxxxx/app> ls -lrt | grep <nom_utilisateur> drwxr-xr-x 12 root root 1024 Apr 29 14:33 <nom_utilisateur>

Pour que les autres utilisateurs puissent ‘descendre’ dans l’arborescence chrootée, il faut positionner les droits : 755

[root@xxxxxx/app> chown 755 /sftp/<nom_utilisateur>

 

<span style="text-decoration: underline;">Note :</span> A partir du moment où la configuration du serveur SSH a été rechargée et qu’un utilisateur a été ajouté dans le groupe sftp. Il ne lui sera plus possible de se connecter en SSH. Le compte ne sera plus non plus accessible par la commande su.

Il ne pourra plus faire que du sftp avec ce serveur.

 


