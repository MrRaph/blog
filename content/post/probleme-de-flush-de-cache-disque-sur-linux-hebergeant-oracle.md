+++
description = ""
slug = "probleme-de-flush-de-cache-disque-sur-linux-hebergeant-oracle"
author = "MrRaph_"
categories = ["ext4_sync_file","Linux","ORA-00239","ORA-00494","Oracle","problème de flush de cache disque sur linux hébergeant oracle","TroubleShooting"]
tags = ["ext4_sync_file","Linux","ORA-00239","ORA-00494","Oracle","problème de flush de cache disque sur linux hébergeant oracle","TroubleShooting"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
title = "Problème de flush de cache disque sur Linux hébergeant Oracle"
date = 2015-06-24T19:32:29Z
draft = false

+++


En arrivant chez mon client ce matin, je me suis rendu compte en ouvrant ma boite mail qu’ils avaient du passer une assez sale nuit … En effet, une livraison était prévue sur une des bases Oracle critique de la société. Cette livraison comprenait entre autre l’exécution de scripts sur la-dite base. Lorsque que le script SQL a été lancé, la personne qui réalisait ces actions a remarquer que l’exécution des commandes était de plus en plus lente, jusqu’à ne plus passer du tout. Quelques minutes après la base s’arrêtait violemment … Impossible alors de relancer la base, il lui a fallut redémarrer la VM pour pouvoir relancer Oracle.

J’ai donc pris mon client SSH préféré et voici ce que j’ai trouvé dans l’alert.log de la base.

WARNING:io_getevents timed out 600 sec Tue Jun 23 20:21:56 2015 Errors in file /u01/oracle/diag/rdbms/labase/LABASE/trace/LABASE_ora_30952.trc  (incident=58427): ORA-00494: mise en file d'attente [CF] détenue pendant trop longtemps (plus de 900 secondes) par 'inst 1, osid 5336' Incident details in: /u01/oracle/diag/rdbms/labase/LABASE/incident/incdir_58427/LABASE_ora_30952_i58427.trc Killing enqueue blocker (pid=5336) on resource CF-00000000-00000000 by (pid=30952) by killing session 815.1

Finalement le « pmon » a terminé l’instance … Je suis donc allez enquêter sur le pourquoi de cette interruption soudaine. Dans le fichier /var/log/messages j’ai trouvé des erreurs inquiétantes, pas mal de processus – dont certains appartenant à Oracle – ont été bloqués.

Jun 23 19:46:15 le-serveur kernel: INFO: task kworker/0:144:24895 blocked for more than 120 seconds. Jun 23 19:46:15 le-serveur kernel: "echo 0 > /proc/sys/kernel/hung_task_timeout_secs" disables this message. Jun 23 19:46:15 le-serveur kernel: kworker/0:144   D 0000000000000000     0 24895      2 0x00000080 Jun 23 19:46:15 le-serveur kernel: ffff88010edb3c58 0000000000000046 ffff88010edb3fd8 0000000000013fc0 Jun 23 19:46:15 le-serveur kernel: ffff88010edb2010 0000000000013fc0 0000000000013fc0 0000000000013fc0 Jun 23 19:46:15 le-serveur kernel: ffff88010edb3fd8 0000000000013fc0 ffff88010f318040 ffff88015dee24c0 Jun 23 19:46:15 le-serveur kernel: Call Trace: Jun 23 19:46:15 le-serveur kernel: [<ffffffff815924f9>] schedule+0x29/0x70 Jun 23 19:46:15 le-serveur kernel: [<ffffffff815927ee>] schedule_preempt_disabled+0xe/0x10 Jun 23 19:46:15 le-serveur kernel: [<ffffffff81590e27>] __mutex_lock_slowpath+0x177/0x220 Jun 23 19:46:15 le-serveur kernel: [<ffffffff8109dd44>] ? dequeue_entity+0x1a4/0x630 Jun 23 19:46:15 le-serveur kernel: [<ffffffff81590c8b>] mutex_lock+0x2b/0x50 Jun 23 19:46:15 le-serveur kernel: [<ffffffffa01976ef>] ext4_sync_file+0x9f/0x290 [ext4] Jun 23 19:46:15 le-serveur kernel: [<ffffffff811c02ae>] vfs_fsync_range+0x2e/0x30 Jun 23 19:46:15 le-serveur kernel: [<ffffffff811c0311>] generic_write_sync+0x41/0x50 Jun 23 19:46:15 le-serveur kernel: [<ffffffff811cbbbb>] dio_complete+0x11b/0x140 Jun 23 19:46:15 le-serveur kernel: [<ffffffff811cbd34>] dio_aio_complete_work+0x24/0x30 Jun 23 19:46:15 le-serveur kernel: [<ffffffff8107b8f0>] process_one_work+0x180/0x420 Jun 23 19:46:15 le-serveur kernel: [<ffffffff8107d92e>] worker_thread+0x12e/0x390 Jun 23 19:46:15 le-serveur kernel: [<ffffffff8107d800>] ? manage_workers+0x180/0x180 Jun 23 19:46:15 le-serveur kernel: [<ffffffff81082c7e>] kthread+0xce/0xe0 Jun 23 19:46:15 le-serveur kernel: [<ffffffff81082bb0>] ? kthread_freezable_should_stop+0x70/0x70 Jun 23 19:46:15 le-serveur kernel: [<ffffffff8159bf2c>] ret_from_fork+0x7c/0xb0 Jun 23 19:46:15 le-serveur kernel: [<ffffffff81082bb0>] ? kthread_freezable_should_stop+0x70/0x70

Le site [oracleseeds.wordpress.com](https://oracleseeds.wordpress.com) m’a fourni une bonne partie de la réponse.

[![Problème de flush de cache disque sur Linux hébergeant Oracle](https://techan.fr/wp-content/uploads/2015/06/Capture-d’écran-2015-06-24-à-19.16.02.png)](https://techan.fr/wp-content/uploads/2015/06/Capture-d’écran-2015-06-24-à-19.16.02.png)

 

Donc le système se garde par défaut 40% de la mémoire du système pour faire du cache au niveau du File System.

[root@le-serveur log]# sysctl vm.dirty_ratio vm.dirty_ratio = 20

 

Dans le cas de cette VM, le paramètre « vm.dirty_ratio » est positionné à 20 donc 20% des 18 Go de RAM dont elle dispose ça fait 3,6 Go de cache. Quand ces 3,6 Go sont pleins, le système écrit ce cache sur le disque, les nouvelles I/O réalisées pendant ce processus deviennent <span style="text-decoration: underline;">synchrones</span>.

Le système a une limite de 120 secondes pour flusher son cache d’ou le calcul de la mort, pour flusher 3,6 Go en 120 secondes, il faut un écrire 30,72 Mo/s. Ce qui n’était malheureusement pas le cas de cette VM à ce moment là. Dans les statistiques de l’ESXi qui l’héberge, j’ai pu voir que la vitesse d’écriture maximum au moment de ce flush était de 18 Mo/s.

 

Une première action corrective sera de passer le paramètre « vm.dirty_ratio » à 10, ainsi on n’aura que 1,8 Go de RAM a flusher en 120 secondes.

[root@le-serveur log]# sysctl vm.dirty_ratio=10

Pour rendre cette modification persistante après un reboot de la machine, il faut l’ajouter dans le fichier « /etc/systcl.conf ».

 

Il faudra également améliorer les performances d’écritures de l’ESXi et de cette VM Oracle pour se prémunir de futures erreurs comme celle-ci.

 


## Sources

- [blog.ronnyegner-consulting.de](http://blog.ronnyegner-consulting.de/2011/10/13/info-task-blocked-for-more-than-120-seconds/comment-page-1/)
- [oracleseeds.wordpress.com](https://oracleseeds.wordpress.com/2012/03/02/dedicated-and-shared-server-processes/)

 


