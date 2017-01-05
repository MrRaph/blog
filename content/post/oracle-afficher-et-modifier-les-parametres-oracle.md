+++
slug = "oracle-afficher-et-modifier-les-parametres-oracle"
title = "[Oracle] Afficher et modifier les paramètres Oracle"
categories = ["Oracle","Survival Guide","Trucs et Astuces"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
draft = false
date = 2014-10-20T11:33:23Z
author = "MrRaph_"
tags = ["Oracle","Survival Guide","Trucs et Astuces"]
description = ""

+++


### Emplacements des paramètres Oracle

Les paramètres Oracle peuvent se trouver dans plusieurs endroits différents :

- fichier pfile
- fichier spfile
- directement en mémoire

 

##### Parameter File (pfile)

C’est un fichier texte que le DBA peut éditer directement.

Il se trouve dans le dossier :

- $ORACLE_HOME/dbs sur UNIX/Linux
- $ORACLE_HOME\database sur Windows

Il sont en général nommés : init**<SID>**.ora

 

Ce fichier peut être édité avec n’importe quel éditeur de texte.

 

##### Server Parameter File (spfile)

Ce fichier est **binaire**, il ne doit pas être édité par le DBA.

Il se trouve au même endroit que le pfile :

- $ORACLE_HOME/dbs sur UNIX/Linux
- $ORACLE_HOME\database sur Windows

Il sont en général nommés : spfile**<SID>**.ora

 

##### Mémoire

Quand Oracle démarre, il va lire le spfile ou le pfile en fonction des option de démarrage ou de l’existence ou non du spfile.

Toutes les valeurs contenues dans ces fichiers de paramètres sont chargées et remplacent les valeurs par défaut des paramètres spécifiés.

 

Certains paramètres peuvent être modifiés directement en mémoire lorsque l’instance Oracle est démarrée. Cependant, ces modifications sont volatiles, ils font les faire également dans le spfile et/ou le pfile pour les rendre permanentes.

 

### Priorité des fichiers de paramètres

##### S’il n’y a pas de spfile pour la base

Dans ce cas, Oracle a besoin d’un fichier pfile pour démarrer.

##### S’il y a un spfile pour la base

Dans ce cas, si l’on ne précise aucune option au démarrage, Oracle va utiliser son spfile pour démarrer.

Si vous souhaitez démarrer la base en utilisant son pfile, vous pouvez utiliser la commande suivante :

SQL> startup pfile='/path/to/init<SID>.ora'

 

<span style="text-decoration: underline;">**Note :**</span> Démarrer une base à partir de son pfile restreint l’accès à certaines actions comme les backups a chaud avec RMAN. Ceci doit rester temporaire, vous pouvez recréer les spfile depuis le pfile et redémarrer la base sans options pour utiliser le spfile.

 

### Récupérer la valeur courante d’un paramètre

Pour récupérer la valeur d’un paramètres, vous avez deux options, soit utiliser la commande « show » soit via une requête SQL. L’utilisation de la commande « show » est nettement plus simple.

 

##### La commande « show »

Une fois connecté à la base, taper « show » suivit du nom du paramètre dont vous voulez la valeur, ou une partie de son nom.

[![image2014-4-3 14-34-35](https://techan.fr/images/2014/10/image2014-4-3-14-34-35.png)](https://techan.fr/images/2014/10/image2014-4-3-14-34-35.png)

##### Utiliser un requête SQL

Cette méthode est un peu plus compliquée mais vous permettra de voir si la valeur du paramètre est par défaut et/ou si elle a été modifiée.

[![image2014-4-3 14-42-44](https://techan.fr/images/2014/10/image2014-4-3-14-42-44.png)](https://techan.fr/images/2014/10/image2014-4-3-14-42-44.png)

 

### Modifier la valeur d’un paramètre

Pour modifier la valeur d’un paramètre, vous allez devoir utiliser la commande suivante :

SQL> alter system set [parameter_name]='[value]' [scope=both|memory|spfile];

 

L’option « scope » dit à Oracle à quel endroit doit être modifié le paramètre :

- **memory** : La valeur du paramètre sera modifiée **uniquement** en mémoire. Cette modification n’est pas persistante au reboot de la base.
- **spfile** : La modification est faite **uniquement** dans le spfile. Elle n’est pas active, elle le sera uniquement après avoir rebooter la base.
- **both **: La modification est faite en mémoire **et** dans le spfile.

##### Paramètres « chaud »

Les paramètres chaud sont ceux qui peuvent être modifiés soit instance allumée soit instance éteinte.

On peut utiliser le scope=memory pour modifier ces paramètres.

##### Paramètres « froid »

Ces paramètres sont modifiables uniquement base éteinte ou en utilisant un scope=spfile.

 

##### Exemple :

Nous allons modifier le paramètre « sessions », dans un premier temps, nous allons sauvegarder l’ancienne valeur, 247 dans notre cas.

[![image2014-4-3 15-51-39](https://techan.fr/images/2014/10/image2014-4-3-15-51-39.png)](https://techan.fr/images/2014/10/image2014-4-3-15-51-39.png)

Modifions la valeur du paramètre à 300.  
[![image2014-4-3 15-52-23](https://techan.fr/images/2014/10/image2014-4-3-15-52-23.png)](https://techan.fr/images/2014/10/image2014-4-3-15-52-23.png)

L’erreur indique qu’il s’agit d’un paramètre « froid », nous allons devoir le modifier dans le spfile et/ou dans le pfile.

[![image2014-4-3 15-53-36](https://techan.fr/images/2014/10/image2014-4-3-15-53-36.png)](https://techan.fr/images/2014/10/image2014-4-3-15-53-36.png)

La nouvelle valeur est maintenant 300.

 

### Réinitialiser la valeur d’un paramètre

Il est possible de remettre un paramètre à sa valeur par défaut, celle qu’Oarcle donne.

Pour ce faire, il faut utiliser la commande suivante :

SQL> alter system reset [parameter_name]='[value]' [scope=both|memory|spfile];

 

Nous allons réinitialiser la valeur du paramètre « sessions » que nous avons modifié juste avant.

[![image2014-4-3 15-55-7](https://techan.fr/images/2014/10/image2014-4-3-15-55-7.png)](https://techan.fr/images/2014/10/image2014-4-3-15-55-7.png)

Après un reboot de la base, la valeur est de nouveau 247 ! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

 


