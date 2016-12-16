+++
draft = false
title = "Configurer les archive logs d'Oracle"
categories = ["Archive Log","configurer les archive logs d oracle","Oracle","Survival Guide"]
description = ""
slug = "configurer-les-archive-logs-doracle"
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
date = 2015-01-23T16:40:06Z
author = "MrRaph_"
tags = ["Archive Log","configurer les archive logs d oracle","Oracle","Survival Guide"]

+++



## A propos des archive logs

Les archive logs sont des copies des redo logs d’Oracle. Ils contiennent l’historique d’activité de la base.

Il sont utilisés pour « re »-jouer l’activité qu’il y a eu sur la base dans le cas ou l’on devrait restaurer la base depuis un backup le fait de re-jouer les archive logs depuis l’heure ou a été pris le backup et l’heure du dernier archive log disponible assure que l’on perde le moins de données possible.

Les archive logs doivent être stockés en de multiples endroits, la requête SQL ci-dessous affiche les destinations configurées pour les archive logs.

SQL> show parameter log_archive_dest

[![Configurer les archive logs d'Oracle](https://techan.fr/wp-content/uploads/2015/01/archive_logs_1.png)](https://techan.fr/wp-content/uploads/2015/01/archive_logs_1.png)

Sur cette base, il n’y a qu’une destination pour les archive logs, c’est le dossier : ‘/data/oracle/product/11.2.0/db_2/tfti_archive’.


## Vérifier si les archive logs sont activés

SQL> archive log list ;

[![Configurer les archive logs d'Oracle](https://techan.fr/wp-content/uploads/2015/01/archive_logs_2.png)](https://techan.fr/wp-content/uploads/2015/01/archive_logs_2.png)

Le mode archive log est activé sur cette base.


## Activer et désactiver les archive logs

<div class="aui-message warning shadowed information-macro" style="text-align: justify;">Vous pouvez passer du mode archive log activé à désactivé et vice-versa <span style="text-decoration: underline;">uniquement</span> si la base est dans l’état « **mount**« .

**<span style="text-decoration: underline;">Attention :</span>** Changer ce paramètre sur une base active nécessite un reboot !

#### Activer les archive logs

SQL> shutdown immediate ; SQL> startup mount ; SQL> alter database archivelog ; SQL> alter database open ; SQL> archive log list ;

 

[![Configurer les archive logs d'Oracle](https://techan.fr/wp-content/uploads/2015/01/archive_logs_3.png)](https://techan.fr/wp-content/uploads/2015/01/archive_logs_3.png)

#### Désactiver le mode archive logs

SQL> shutdown immediate ; SQL> startup mount ; SQL> alter database noarchivelog ; SQL> alter database open ; SQL> archive log list ;

 

[![Configurer les archive logs d'Oracle](https://techan.fr/wp-content/uploads/2015/01/archive_logs_4.png)](https://techan.fr/wp-content/uploads/2015/01/archive_logs_4.png)


## Changer la destination d’archivage des logs

Changer la destination d’archivage peut être requis si le file system de la destination principale est plein. Cela empêchera Oracle d’écrire de nouveau archive log dans cette destination pleine et évitera un blocage de la base.

Si Oracle ne peut pas sauver son activité en générant des archive logs, le système va bloquer toutes les transactions, il ne sera plus possible de faire quoi que ce soit sur la base tant que la destination d’archivage ne sera pas de nouveau disponible ou vidée.

Dans ce cas, vous verrez l’erreur ORA- suivante dans l’alert.log et dans les clients :

</div><div class="aui-message warning shadowed information-macro" style="text-align: justify;">ORA-00257: archiver error. Connect internal only, until freed.

 

Pour vider la destination d’archivage, vous pouvez la backuper avec l’option « delete » qui supprime les archive logs déjà sauvegardés. Mais cela peut prendre pas mal de temps pendant lequel vous pouvez modifier la destination d’archivage principale vers un file system avec de l’espace libre.

N’oubliez pas de remettre cela d’aplomb une fois le backup terminé.

</div><div class="aui-message warning shadowed information-macro">Vous pouvez modifier les destinations d’archivage avec cette requête SQL :

SQL> alter system set log_archive_dest_<NUMBER_OF_THE_DESTINATION>='LOCATION=<NEW_DIRECTORY>' ;

Par exemple, je vais changer la destination d’archivage de ma base de « /data/oracle/product/11.2.0/db_2/tfti_archive » vers « /data/oracle/archives/TFTI1 » :

[![Configurer les archive logs d'Oracle](https://techan.fr/wp-content/uploads/2015/01/archive_logs_5.png)](https://techan.fr/wp-content/uploads/2015/01/archive_logs_5.png)

</div>
