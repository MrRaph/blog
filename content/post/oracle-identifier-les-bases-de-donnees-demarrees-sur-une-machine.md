+++
title = "[Oracle] Identifier les bases de données démarrées sur une machine"
date = 2014-10-16T09:39:57Z
author = "MrRaph_"
tags = ["Oracle","Survival Guide","Trucs et Astuces"]
description = ""
slug = "oracle-identifier-les-bases-de-donnees-demarrees-sur-une-machine"
draft = false
categories = ["Oracle","Survival Guide","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"

+++


### Détecter les bases Oracle installées sur la machine

Lorsqu’une base est créée avec les outils Oracle, une ligne est ajoutée dans le fichier /etc/oratab. Il est de bon ton d’ajouter une ligne dans ce fichier lorsque les bases sont créées à la main également.  
  
 Ce fichier est utilisé par pas mal d’outils afin de détecter les bases installées sur une machine.

 

Voici comment ce fichier se présente.

[![image2014-4-10 12-35-45](https://techan.fr/wp-content/uploads/2014/10/image2014-4-10-12-35-45.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-10-12-35-45.png)

Pour chaque entrée, les champs sont séparés par des « : » , voici ce que chacun de ces champs représentent.

<SID>:<ORACLE_HOME>:<AUTO START>

Dans l’exemple ci dessus, on peut voir que deux bases sontenregistrées sur cette machine : « lora12c1001d » et « TFTI1 ».

- lora12c1001d utilise un Oracle Home en version 12c.
- TFTI1 utilise un Oracle Home en version 11gR2.

Le dernier champ peut avoir la valeur « Y » ou « N ».

- Y : la base démarre automatiquement avec le système.
- N : la base ne démarre pas avec le système.

 

### Lister les bases démarrées sur la machine

##### Sur Linux/UNIX

On peut avoir la liste des bases démarrées en utilisant la commande « ps ».

$ ps -ef | grep smon

On cherche toutes les processus qui contiennent « smon » dans leur nom, « smon » est un processus unique pour chaque base de données.

 

[![image2014-4-10 12-39-40](https://techan.fr/wp-content/uploads/2014/10/image2014-4-10-12-39-40.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-10-12-39-40.png)

On voit ici que deux bases sont démarrées : « lora12c1001d » et « TFTI1 ».

 


