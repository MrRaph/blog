+++
categories = ["Oracle","Survival Guide","Trucs et Astuces"]
tags = ["Oracle","Survival Guide","Trucs et Astuces"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
description = ""
date = 2014-10-16T15:33:21Z
author = "MrRaph_"
slug = "oracle-les-etapes-darret-et-de-demarrage"
draft = false
title = "[Oracle] Les étapes d'arrêt et de démarrage."

+++


Quand une base de données Oracle démarre ou s’arrête, elle passe par différentes étapes successives.  
 On peut démarrer une base Oracle à plusieurs de ces étapes pour réaliser des actions spécifiques.

### Les étapes de démarrage

##### nomount

C’est la première étape, Oracle lit le fichier SPFILE (Server Parameter File) ou le PFILE (Parameter File) pour connaître les paramètres qui ont été positionnés par les DBAs.

Une fois qu’Oracle a pris connaissance de ces paramètres, comme par exemple la quantité de mémoire a allouer, il se réserve sa mémoire et démarre ses processus de background.

C’est le démarrage de l’instance.

##### mount

Dans cet état, l’instance a déjà été démarrée.

Oracle va lire ses « control files », ces fichiers contiennent des informations cruciales sur la base de données, comme la localisation des fichiers de données.

Les « data files » ne sont pas ouverts à pendant cette étape.

<span style="text-decoration: underline;">**Note :**</span> Le mode « mount » est beaucoup utilisé pour restaurer la base ou pour faire des recovers avec RMAN.

##### 

##### open

C’est le dernier stade du démarrage de la base. Oracle ouvre ses data files qui ont été identifiés pendant l’étape « mount ».

Oracle vérife que tous ses fichiers sont consistants et ouvre la base de données aux utilisateurs.

<span style="text-decoration: underline;">**Note :**</span> Le mode « open » est le mode de production, les utilisateurs et les applications peuvent se connecter à la base et faire leurs opérations.

### Les étapes d’arrêt

Pendant l’arrêt, Oracle passe successivement du mode ouver au mode mount, du mode mount au mode nomount et du mode nomount au mode closed, sauf si l’option « aboter » a été utilisée.

### Démarrer une base de données

Il est possible de démarrer une base dans l’un des trois états décrit plus haut.

Voici les différentes commandes pour faire ça :

SQL> startup nomount ; --starts DB in nomount mode SQL> startup mount ; --starts DB in mount mode SQL> startup ; --start DB in open mode

Si vous avez ouvert la base dans une des étapes intermédiaires avant le open, vous pourrez pousser la base dans les étapes suivantes mais vous ne pourrez pas redescendre dans les étapes plus basses.

Pour faire cela, vous devrez éteindre et redémarrer la base dans un mode plus bas.

Voici les commandes pour passer la base dans un mode d’ouverture plus haut :

SQL> alter database mount ; --Switch a DB in nomount mode to mount mode SQL> alter database open ; --Switch a DB in nomount or mount mode to open mode

 

### Options de démarrage spéciales

##### Restrict

L’option restrict est utilisée pour éviter toute connections non privilégiée à la base. La base est techniquement « ouverte » mais seuls les DBAs peuvent s’y connecter.

SQL> startup restrict ; --Start a DB in restrict mode

##### Upgrade

Le mode upgrade porte bien son nom, il est utilisé pour passer des script de mise à jour d’Oracle (patch). C’est un mode restrict spécial qui permet de démarrer une base avec des binaires plus récents que ceux utiliser pour la créer.

Cette option est utilisée pour upgrader des bases de la 10gR2 vers la 11G par exemple.

SQL> startup upgrade ; --Start a DB in upgrade mode

 

### Éteindre une base

La commande pour arrêter une bases est la suivante :

SQL> shutdown ; --Shut a database down

Vous trouverez ci-dessous les différentes options que l’on peut ajouter à cette commande.

##### IMMEDIATE

Causes :

- Les requêtes des clients en cours d’exécution sont autorisées a continuer
- Les transactions non commitées sont rollbackées
- Tous les utilisateurs sont déconnectés

SQL> shutdown immediate ; --Shut a database down

C’est le mode d’arrêt le plus fréquent, il laisse la base dans un état consistant.

##### TRANSACTIONAL

Causes :

- Les clients qui font des transactions sont autorisés a les terminer.
- Les clients ne peuvent plus commencer de nouvelles transactions, ceux qui tentes de commencer une nouvelle transaction sont déconnectés.
- Une fois toutes les transactions commitées ou terminées, tout client toujours connecté est déconnecté.

SQL> shutdown transactional ; --Shut a database down

 

##### NORMAL

Causes :

- Pas de nouvelles connections
- On attend que les utilisateurs se déconnectent.

Le prochain démarrage ne nécessitera pas de recovery.

C’est l’optiond’arrêt par défaut.

SQL> shutdown normal; --Shut a database down SQL> shutdown ; --Shut a database down

 

##### ABORT

Causes :

- Termine immédiatement toutes les exécutions SQL en cours
- Les transactions non commitées ne seront pas rollbackées avant le prochain démarrage.
- Déconnecte tous les utilisateurs.

Une recovery de l’instance sera nécessaire au prochain démarrage.

A utiliser avec précaution !!!

SQL> shutdown abort ; --Abort a database instance

Cette option va forcer le kill du processus principal de l’instance Oracle. Cela laisse la base dans un état totalement incohérent !!!

<span style="text-decoration: underline; color: #ff0000;">**Important !!!**</span>  
 Après un shutdown abort, vous devrez faire un startup/shutdown immediate/startup afin de permettre à Oracle de retrouver sa cohérence.

Ce cycle force Oracle a néttoyer les data files pour qu’ils soient cohérents.

SQL> shutdown abort ; --Abort a database instance SQL> startup ; SQL> shutdown immediate ; SQL> startup ;

 


