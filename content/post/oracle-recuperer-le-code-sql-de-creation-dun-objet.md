+++
date = 2014-10-23T08:18:00Z
categories = ["Oracle","Survival Guide","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
description = ""
draft = false
title = "[Oracle] Récupérer le code SQL de création d'un objet"
slug = "oracle-recuperer-le-code-sql-de-creation-dun-objet"
author = "MrRaph_"
tags = ["Oracle","Survival Guide","Trucs et Astuces"]

+++


Une chose qui rend souvent service dans le monde des DBAs, c’est de récupérer le code SQL qui a servi à la création d’un objet, d’un schéma, d’un tablespace … Ceci dans le but de le recréer tel quel ailleurs ou de modifier légèrement ce code pour créer un objet ressemblant dans la même base.  
  
  

Cette fonctionnalité est souvent proposée de base dans les outils d’administration ou de développement SQL ou PL/SQL. Mais lorsque l’on se retrouve dans SQL*Plus, il faut connaitre la commande qui va bien.

 

La voici donc cette commande :

SQL> set long 99999999 SQL> select dbms_metadata.get_ddl('USER','SCOTT') from dual ; DBMS_METADATA.GET_DDL('USER','SCOTT') -------------------------------------------------------------------------------- CREATE USER "SCOTT" IDENTIFIED BY VALUES 'S:07921277EB685F9816BA4776231FA31B0 C0A84DD4DF70E5DEC761A6F6B53;F894844C34402B67' DEFAULT TABLESPACE "USERS" TEMPORARY TABLESPACE "TEMP" PASSWORD EXPIRE ACCOUNT LOCK

Le « set long 99999999 » permet de ne pas avoir un retour tronqué.

En copiant/collant le code ci-dessus, on pourra recréer le user « Scott » tel qu’il est défini dans la base source, mot de passe inclus.

 

Vous l’avez compris, le premier paramètre de la fonction « get_ddl » du package « dbms_metadata » est le type d’objet dont on veut le code SQL, le second n’est autre que le nom d’objet lui même.


