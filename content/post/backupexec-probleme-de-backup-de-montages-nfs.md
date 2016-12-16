+++
description = ""
slug = "backupexec-probleme-de-backup-de-montages-nfs"
draft = false
title = "[BackupExec] Problème de backup de montages NFS"
date = 2014-11-14T11:08:10Z
author = "MrRaph_"
categories = ["Backup","BackupExec","NFS"]
tags = ["Backup","BackupExec","NFS"]

+++


Récemment, nous avons eu un souci de sauvegarde de partage NFS via BackupExec. Nous utilisons un serveur Linux sur lequel sont montés les partages a sauvegarder, l’agent du Linux réalise alors les backups depuis cette machine.

Sur certains partages, les backups étaient marqués comme « succesfull » mais ne pesaient qu’un peu plus d’1 Ko alors qu’ils contiennent plusieurs (centaines) de Go de données.  
  
 Dans les logs on voyait bien que l’agent « passait » (Skip) tous les dossiers dans ces montages NFS. Après pas mal de recherches infructueuses sur Internet et l’appel à un ami, j’ai trouvé ceci dans l’admin guide de BackupExec.

[![be_nfs_admin_guide](https://techan.fr/wp-content/uploads/2014/11/be_nfs_admin_guide-300x238.png)](https://techan.fr/wp-content/uploads/2014/11/be_nfs_admin_guide.png)Le plus dur après a été de trouver ou renseigner cette option … Voici ou cela se trouve :

<div class="wp-caption aligncenter" id="attachment_334" style="width: 310px">[![Ouvrez les jobs définis sur le serveur puis : Clic droit -> Edit sur le job qui ne fonctionne pas](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs1-300x230.png)](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs1.png)Ouvrez les jobs définis sur le serveur puis :  
Clic droit -> Edit  
sur le job qui ne fonctionne pas

</div> 

<div class="wp-caption aligncenter" id="attachment_335" style="width: 310px">[![Dans la fenêtre qui s'ouvre, cliquer sur "Edit" en bas de la colonne "Backup".](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs2-300x210.png)](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs2.png)Dans la fenêtre qui s’ouvre, cliquer sur « Edit » en bas de la colonne « Backup ».

</div><div class="wp-caption aligncenter" id="attachment_336" style="width: 310px">[![Dans la nouvelle fenêtre qui s'ouvre, cliquer sur "Linux and Macintosh" dans le menu à gauche.](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs3-300x187.png)](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs3.png)Dans la nouvelle fenêtre qui s’ouvre, cliquer sur « Linux and Macintosh » dans le menu à gauche.

</div><div class="wp-caption aligncenter" id="attachment_337" style="width: 310px">[![Cocher l'option "Follow remonte mount points".](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs4-300x188.png)](https://techan.fr/wp-content/uploads/2014/11/be_option_nfs4.png)Cocher l’option « Follow remonte mount points ».

</div>Relancer ensuite le backup, tout devrait mieux se passer …


