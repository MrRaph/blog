+++
author = "MrRaph_"
categories = ["Datafiles","g rer les tablespaces et les datafiles","gérer les tablespaces et les datafiles","Oracle","Survival Guide","Tablespaces"]
image = "https://techan.fr/images/2014/10/SQL_term.png"
date = 2015-01-28T10:21:42Z
tags = ["Datafiles","g rer les tablespaces et les datafiles","gérer les tablespaces et les datafiles","Oracle","Survival Guide","Tablespaces"]
description = ""
slug = "gerer-les-tablespaces-et-les-datafiles"
draft = false
title = "Gérer les tablespaces et les datafiles"

+++



## A propos des tablespaces et des datafiles

Les tablespaces sont la plus grosse unité de stockage logicielle d’Oracle, un tablespace est composé d’un ou plusieurs datafile.

Un datafile est un fichier physique, visible sur le file system de la machine hôte, il ne peut appartenir qu’à un et un seul tablespace. Il s’agit d’un fichier spécial dont le contenu n’est pas lisible, il est « formaté » par Oracle.

**<span style="text-decoration: underline;">Attention :</span>**<span style="text-decoration: underline;">Vous ne pouvez ni ne devez</span> compresser, ziper, gziper un datafile. Si vous le faites toutes les données qu’il contient seront perdues !

Un tablespace Oracle peut être dédié à un utilisateur qui peut y stocker tout ou partie de ses données.

A l’intérieur d’un datafile, les objets sont stockés dans des « segments » et des « extents ». Les « extents » sont logiques et composés de « segments » physiques, dans ces « segment », on trouve des blocks. Les blocks sont la plus petites unité de stockage dans une base Oracle, leur taille est fixe et spécifiée lors de la création de la base, **<span style="text-decoration: underline;">elle ne peut être changé sans recréer la base</span>** (leur taille par défaut est 8 Ko).


## Les vues utiles pour gérer les tablespaces et les datafiles

### dba_tablespaces

[![Gérer les tablespaces et les datafiles](https://techan.fr/images/2015/01/tbs_dbf_1.png)](https://techan.fr/images/2015/01/tbs_dbf_1.png)

Je vais décrire les champs les plus important dans le tableau ci-dessous :

<div class="table-wrap" style="text-align: justify;"><table class="confluenceTable tablesorter"><thead><tr class="sortableHeader"><th class="confluenceTh sortableHeader" data-column="0"><div class="tablesorter-header-inner">Champ</div></th><th class="confluenceTh sortableHeader" data-column="1"><div class="tablesorter-header-inner">Description</div></th></tr></thead><tbody><tr><td class="confluenceTd">tablespace_name</td><td class="confluenceTd">Nom du tablespace</td></tr><tr><td class="confluenceTd">status</td><td class="confluenceTd">Peut être : Online, Offline, Read Only</td></tr></tbody></table></div>### dba_data_files

[![Gérer les tablespaces et les datafiles](https://techan.fr/images/2015/01/tbs_dbf_2.png)](https://techan.fr/images/2015/01/tbs_dbf_2.png)

Je vais décrire les champs les plus important dans le tableau ci-dessous :

<div class="table-wrap" style="text-align: justify;"><table class="confluenceTable tablesorter"><thead><tr class="sortableHeader"><th class="confluenceTh sortableHeader" data-column="0"><div class="tablesorter-header-inner">Champ</div></th><th class="confluenceTh sortableHeader" data-column="1"><div class="tablesorter-header-inner">Description</div></th></tr></thead><tbody><tr><td class="confluenceTd">file_name</td><td class="confluenceTd">Chemin complet vers le datafile</td></tr><tr><td class="confluenceTd">file_id</td><td class="confluenceTd">Numéro séquentiel donné à chaque fichier, cela peut etre utile lorsque l’on utilise RMAN.</td></tr><tr><td class="confluenceTd" colspan="1">tablespace_name</td><td class="confluenceTd" colspan="1">Nom du tablespace auquel appartient le fichier</td></tr><tr><td class="confluenceTd" colspan="1">bytes</td><td class="confluenceTd" colspan="1">Taille du fichier en bytes, conversion de l’attribut « SIZE » utilisé lors de la création du fichier.</td></tr><tr><td class="confluenceTd" colspan="1">autoextensible</td><td class="confluenceTd" colspan="1">Est ce que le fichier peut être étendu automatiquement ? Si oui, Oracle va être capable d’ajouter automatiquement de l’espace à ce fichier lorsqu’il est presque plein. <span style="text-decoration: underline;">**Ceci n’est pas recommandé !**</span></td></tr></tbody></table></div>
## Créer et modifier des tablespaces

### Créer un tablespace

Lorsque vous créer un tablespace, il faudra également créer un datafile, pas de souci, tout tient dans la même ligne 