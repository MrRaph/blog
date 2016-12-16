+++
title = "[Oracle] Gérer les utilisateurs"
author = "MrRaph_"
categories = ["Oracle","Survival Guide","Trucs et Astuces"]
tags = ["Oracle","Survival Guide","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
slug = "oracle-gerer-les-utilisateurs"
draft = false
date = 2014-10-16T12:08:30Z
description = ""

+++


Un utilisateur Oracle est un schéma Oracle, c’est un login associé à un mot de passe. Ce compte peut contenir des objets ou utiliser les objets d’autres utilisateurs s’il en a le droit.  
  
  

### Lister les utilisateurs d’une base Oracle

Ceci peut être fait via une requête SQL très simple :

select username from dba_users ;

[![image2014-4-4 13-36-50](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-36-50.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-36-50.png)

<span style="text-decoration: underline;">**Attention :**</span> Ceci liste <span style="text-decoration: underline;">**tous**</span> les utilisateurs présents dans la base, même les utilisateurs systèmes d’Oracle.

 

### Créer un utilisateur

La requête suivante permet de créer un utilisateur dans Oracle.

create user <USERNAME> identified by <PASSWORD> ;

[![image2014-4-4 13-40-28](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-40-28.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-40-28.png)

Ceci va créer l’utilisateur « izual » avec le mot de passe « izualpass ».

<span style="text-decoration: underline;">**Attention :**</span>

- Pour les versions 10gR2 et antérieures, les mots de passe **ne sont pas case sensitive**.
- Pour les versions 11gR1 et suivante, les mots de passe **sont case sensitive**.

 

##### Donner quelques droits basiques à l’utilisateur

Par défaut, un utilisateur Oracle ne peut rien faire, même pas se connecter à la base.

Les privilèges basique a donner sont :

- **connect **: Permet à l’utilisateur de se connecter à la base.
- **resource** : Permet à l’utilisateur d’utiliser de l’espace dans son tablespace.

 

Donner ces privilèges se fait via cette requête SQL :

grant connect, resource to <USERNAME> ;

[![image2014-4-4 13-49-44](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-49-44.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-49-44.png)

A partir de maintenant, l’utilisateur « izual » peut se connecter à la base et créer des objets.

 

### Modifier un utilisateur Oracle

##### Mot de passe

[![image2014-4-4 13-53-9](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-53-9.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-53-9.png)

Le mot de passe du compte « izual » est maintenant « izualnewpass ».

 

##### Changer le tablespace par défaut

Le tablepsace par défaut, est l’endroit ou sont stockés les objets les objets si l’on ne spécifie pas un tablespace en particulier.

Par défaut, le tablepspace par défaut est « USERS ».

[![image2014-4-4 13-54-51](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-54-51.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-13-54-51.png)

On peut changer ce default tablepsace en utilisant la commande suivante.

alter user <USERNAME> default tablespace EXAMPLE ;

 

[![image2014-4-4 14-1-0](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-1-0.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-1-0.png)

Le tablespace par défaut est maintenant « EXAMPLE ».

 

### Vérouiller et dévérouiller des comptes

Verrouiller des compte peut être utile si l’on souhaite empêcher des applications ou des utilisateurs de se connecter sur une base Oracle.

 

##### Verrouiller un compte

La commande suivante permet de verrouiller un compte :

alter user <USERNAME> account lock ;

[![image2014-4-4 14-3-37](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-3-37.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-3-37.png)

Le compte « izual » est maintenant verrouillé, personne ne peux plus se connecter à la base en l’utilisant.  
[![image2014-4-4 14-4-33](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-4-33.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-4-33.png)

 

##### Déverrouiller un compte

Voici la requête qui permet de déverrouiller un compte :

alter user <USERNAME> account unlock ;

[![image2014-4-4 14-5-37](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-5-37.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-5-37.png)

On peut de nouveau se connecter avec le compte « izual ».

[![image2014-4-4 14-5-51](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-5-51.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-4-14-5-51.png)

 

### Sauvegarder le mot de passe d’un utilisateur

Dans Oracle, on ne peut accéder au mot de passe en clair, on peut seulement récupérer le hashage des mots de passe.

Cette manipulation est intéressante si l’on souhaite recréer un compte avec le même mot de passe qu’un autre mais sans le connaitre.

 

##### Oracle 10gR2 et antérieur

On peut utiliser cette requête pour récupérer le hashage du mot de passe :

SQL> select username, password from dba_users where username='<USERNAME>' ;

 

##### Oracle 11gR1 et supérieur

A partir de la version 11gR1, Oracle a modifié sa stratégie de stockage des mots de passe. Ils ne sont plus accessible dans la vue dba_users.

Il faut maintenant utiliser la méthode suivante pour récupérer les mots de passe.

SQL> select dbms_metadata.get_ddl('USER','<USERNAME>') from dual ;

 

**<span style="text-decoration: underline;">Note :</span>** Il ne faut pas oublier le « set long 999999 » qui permet d’avoir l’affichage complet, non tronqué de la sortie de cette commande.

[![image2014-4-7 11-19-7](https://techan.fr/wp-content/uploads/2014/10/image2014-4-7-11-19-7.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-7-11-19-7.png)

 

### Créer un utilisateur en utilisant le hashage du mot de passe

Si vous avez récupérer un hash de mot de passe et que vous souhaitez remettre ce mot de passe à un utilisateur, voici la marche à suivre :

alter user <USERNAME> identified by values '<PASSWORD HASH VALUE>' ;

 

[![image2014-4-7 11-22-9](https://techan.fr/wp-content/uploads/2014/10/image2014-4-7-11-22-9.png)](https://techan.fr/wp-content/uploads/2014/10/image2014-4-7-11-22-9.png)


