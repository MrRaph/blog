+++
author = "MrRaph_"
categories = ["Agent","BackupExec","Debug","Linux"]
tags = ["Agent","BackupExec","Debug","Linux"]
description = ""
slug = "backupexec-mettre-lagent-linux-en-mode-debug"
draft = false
title = "[BackupExec] Mettre l'agent Linux en mode \"debug\""
date = 2014-11-14T11:16:11Z

+++


Voici une astuce pour mettre en agent BackupExec Linux en mode debug afin de pouvoir analyser ses logs (très très très très) verbeux.  
  
 Dans un premier temps, il faut arrêter l’agent :

root@xxxx # /opt/VRTSralus/bin/VRTSralus.init stop

Ensuite, on peut avoir toutes les options de lancement de l’agent en faisant la commande :

/opt/VRTSralus/bin/beremote --help

Et donc pour le mode debug, on peut soit tout envoyer vers la sortie écran :

/opt/VRTSralus/bin/beremote --log-console &

Soit envoyer sa sortie dans un fichier (ce que je vous recommande vu la quantité de lignes qu’il va sortir …

/opt/VRTSralus/bin/beremote --log-file </chemin/vers/le/log> &

 

**<span style="text-decoration: underline;">Source :</span>**

[Sur le site de symantec](http://www.symantec.com/business/support/index?page=content&id=TECH35477)


