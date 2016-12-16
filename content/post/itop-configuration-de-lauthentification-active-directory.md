+++
tags = ["Active Directory","Authentification","iTop","Linux"]
description = ""
slug = "itop-configuration-de-lauthentification-active-directory"
draft = false
title = "[iTop] Configuration de l'authentification Active Directory"
date = 2014-10-24T13:48:33Z
author = "MrRaph_"
categories = ["Active Directory","Authentification","iTop","Linux"]

+++


iTop est une application web éditée par la société Combodo. Elle permet de faire la gestion de parc informatique (CMDB) ainsi que de la gestion de tickets suivant la norme ITIL.

C’est un outil très sympa à utiliser et très « user friendly ».

Cependant, il manque d’une interface d’administration centralisée. Beaucoup de tâches d’administration doivent être faites en éditant les fichiers de configuration directement sur le serveur web.

Je vais détailler ici comment utiliser l’authentification avec Active Directory dans cet outil.  
  
  

La configuration de authentification se fait dans le fichier de préférences d’iTop qui se trouve dans le dossier suivant : « /chemin/vers/itop/web/conf/production/ », son petit nom est « config-itop.php ».

 

Dans ce fichier, vous trouverez une section « authent-ldap », c’est ici que nous allons configurer l’accès à l’Active Directory.

 

Modifiez ce bloc pour qu’il ressemble à ceci, en adaptant avec vos paramètres :

/** * * Modules specific settings * */ $MyModuleSettings = array( 'authent-ldap' => array ( 'host' => 'DNS ou IP du serveur AD', 'port' => 389, 'default_user' => 'DOMAINE\compte AD', 'default_pwd' => 'Mot de passe', 'base_dn' => 'dc=domaine,dc=fr', 'user_query' => '(&(samaccountname=%1$s)(objectCategory=User))', 'options' => array ( 17 => 3, 8 => 0, ), 'debug' => false, ), 'itop-attachments' => array ( 'allowed_classes' => array ( 0 => 'Ticket', ), 'position' => 'relations', ), );

 

Et voilà, l’authentification via l’AD est maintenant possible, pour ce faire, il faut créer un contact dans l’application puis le lier à un compte de type « Utilisateur LDAP ».

 

<span style="text-decoration: underline;">**Source :**</span>[La doc officielle](https://wiki.openitop.org/doku.php?id=active_directory_integration)


