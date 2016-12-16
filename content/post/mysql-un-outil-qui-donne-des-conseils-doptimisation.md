+++
date = 2014-09-29T09:21:14Z
author = "MrRaph_"
categories = ["MySQL","Outils","Performances","script"]
tags = ["MySQL","Outils","Performances","script"]
description = ""
slug = "mysql-un-outil-qui-donne-des-conseils-doptimisation"
draft = false
title = "[MySQL] Un outil qui donne des conseils d'optimisation"

+++


Voici un outil en ligne de commande assez pratique qui audit votre serveur MySQL et vous donne des pistes pour améliorer ses performances.

 

Cet outil est disponible directement dans les dépots d’Ubuntu, son petit nom mysqltuner.  
  
  

root@kelthuzad:~# aptitude search mysqltuner p mysqltuner - high-performance MySQL tuning script

 

Cet outil propose une sortie écran très claire avec des axes d’amélioration. Attention toute fois, il faut que votre dameon MySQL tourne depuis quelques jours sans reboot pour que les conseils soient plus pertinents.

root@xxxx:~# /root/bin/mysqltuner.pl >> MySQLTuner 1.3.0 - Major Hayden <major@mhtx.net> >> Bug reports, feature requests, and downloads at http://mysqltuner.com/ >> Run with '--help' for additional options and output filtering [OK] Logged in using credentials from debian maintenance account. [OK] Currently running supported MySQL version 5.5.38-0ubuntu0.14.04.1-log [OK] Operating on 64-bit architecture -------- Storage Engine Statistics ------------------------------------------- [--] Status: +ARCHIVE +BLACKHOLE +CSV -FEDERATED +InnoDB +MRG_MYISAM [--] Data in PERFORMANCE_SCHEMA tables: 0B (Tables: 17) [--] Data in MEMORY tables: 0B (Tables: 2) [--] Data in InnoDB tables: 12M (Tables: 40) [--] Data in MyISAM tables: 109M (Tables: 479) [!!] Total fragmented tables: 42 -------- Security Recommendations ------------------------------------------- [!!] User 'xxxx@%' has no password set. -------- Performance Metrics ------------------------------------------------- [--] Up for: 28d 0h 42m 18s (8M q [3.694 qps], 184K conn, TX: 5B, RX: 1B) [--] Reads / Writes: 79% / 21% [--] Total buffers: 188.0M global + 2.7M per thread (50 max threads) [OK] Maximum possible memory usage: 322.4M (16% of installed RAM) [OK] Slow queries: 0% (146/8M) [OK] Highest usage of available connections: 50% (25/50) [OK] Key buffer size / total MyISAM indexes: 20.0M/33.1M [OK] Key buffer hit rate: 98.7% (35M cached / 464K reads) [OK] Query cache efficiency: 79.1% (6M cached / 8M selects) [!!] Query cache prunes per day: 3720 [OK] Sorts requiring temporary tables: 0% (1 temp sorts / 49K sorts) [OK] Temporary tables created on disk: 9% (4K on disk / 47K total) [OK] Thread cache hit rate: 97% (5K created / 184K connections) [!!] Table cache hit rate: 0% (200 open / 66K opened) [OK] Open file limit used: 30% (312/1K) [OK] Table locks acquired immediately: 99% (2M immediate / 2M locks) [OK] InnoDB buffer pool / data size: 128.0M/12.7M [OK] InnoDB log waits: 0 -------- Recommendations ----------------------------------------------------- General recommendations: Run OPTIMIZE TABLE to defragment tables for better performance Increase table_open_cache gradually to avoid file descriptor limits Read this before increasing table_open_cache over 64: http://bit.ly/1mi7c4C Variables to adjust: query_cache_size (> 8M) table_open_cache (> 200)

Voici  pour finir un petit script qui optimise les tables MySQL et qui lance mysqltuner.

 

#!/bin/bash mysqlcheck -u root -pPassw0rd --auto-repair --optimize --all-databases > /tmp/mysql_opti.lst /root/bin/mysqltuner.pl >> /tmp/mysql_opti.lst cat /tmp/mysql_opti.lst | mail -s "[Kelthuzad] MySQL Tuner" me@mondomaine.fr rm -f /tmp/mysql_opti.lst

 

Et on ajoute une petite planification pour ce script :

## Optim MySQL 0 2 * * * /root/bin/mysql_optimize.sh >> /dev/null

 


