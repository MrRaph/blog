+++
author = "MrRaph_"
tags = ["Active Directory","Authentification","importer des utilisateurs active directory dans itop","iTop","Linux"]
description = ""
draft = false
date = 2016-01-25T10:13:08Z
categories = ["Active Directory","Authentification","importer des utilisateurs active directory dans itop","iTop","Linux"]
image = "https://techan.fr/images/2016/01/itop-logo.png"
slug = "importer-des-utilisateurs-active-directory-dans-itop"
title = "Importer des utilisateurs Active Directory dans iTop"

+++


Il y a très longtemps, j’ai déjà parlé de la mise en place de l’authentification via l’Active Directory dans iTop – voir [[iTop] Configuration de l’authentification Active Directory](https://techan.fr/itop-configuration-de-lauthentification-active-directory/) – aujourd’hui, je vous propose d’aller un peu plus loin en important les comptes Active Directory dans iTop. Ceci permet de ne plus avoir a créer les comptes utilisateurs et les contacts associés lorsque l’authentification Active Directory est activée. Croyez moi, c’est un gain de temps énorme ! :-)

 


## Passons à l’action !

Tout d’abord, il faut récupérer le script ([ici](http://www.combodo.com/documentation/AD_import_accounts.txt)) développé par [Combodo](http://www.combodo.com/) – l’éditeur d’iTop – et le placer dans le dossier **<ITOP_Directory>/webservices**. Partons du principe que vous l’appellerez : **AD_<span class="search_hit">import</span>_accounts.php.**

 

Une fois le script en place, éditez le. La partie à configurer se trouve tout au début.

    ////////////////////////////////////////////////////////////////////////////////
    // Configuration parameters: adjust them to connect to your AD server
    // And configure the mapping between AD groups and iTop profiles 
    $aConfig = array( 
    // Configuration of the Active Directory connection 
    'host' => '<AD Server IP ou DNS>', 
    // IP or FQDN of your domain controller 
    'port' => '389', 
    // LDAP port, 398=LDAP, 636= LDAPS 
    'dn' => 'DC=<EXAMPLE>,DC=<COM>', 
    // Domain DN 
    'username' => '<DOMAIN>\\<UTILISATEUR>', 
    // username with read access 
    'password' => '<MOT DE PASSE>', 
    // password for above 
    // Query to retrieve and filter the users from AD 
    // Example: retrieve all users from the AD Group "iTop Users" 
    //'ldap_query' => '(&(objectCategory=user)(memberOf=OU=__Internal Users__TeamWork,DC=twm,DC=ch))', 
    // Example 2: retrieves ALL the users from AD 'ldap_query' => '(&(objectCategory=user))', 
    // Retrieve all users 
    // Which field to use as the iTop login samaccountname or userprincipalname ? 
    'login' => 'samaccountname', 
    //'login' => 'userprincipalname', 
    // Mapping between the AD groups and the iTop profiles 
    'profiles_mapping' => array( 
    //AD Group Name => iTop Profile Name 
    //'Administrators' => 'Administrator', ),
    // Since each iTop user must have at least one profile, assign the profile 
    // Below to users for which there was no match in the above mapping 
    'default_profile' => 'Portal user', 
    'default_language' => 'EN US', 
    // Default language for creating new users
    'default_organization' => <ID de l'organisation dans laquelle créer les utilisateurs>, 
    // ID of the default organization for creating new contacts 
    ); 
    // End of configuration

 

Et voilà, tout devrait être OK, maintenant, vous n’avez plus qu’à lancer le script soit directement en ligne de commande :

    php -q AD_import_accounts.php --auth_user=<iTop_admin_user> --auth_pwd=<iTop_admin_pwd>

Vous pouvez également le lancer depuis votre navigateur Web, le résultat est bien plus sympa de cette façon. Pour cela il suffit d’ouvrir l’URL suivante :

*http://itop.example.com/webservices/AD_import_accounts.php*

 

Par défaut ce script fonctionne en mode « Dry Run », rien ne sera donc créé ou modifié dans votre iTop. Pour que le script réalise les modifications, il faut ajouter un paramètre à la ligne de commande ou dans l’URL.

- php -q AD_import_accounts.php --auth_user=<iTop_admin_user> --auth_pwd=<iTop_admin_pwd> --simulation=0
- http://itop.example.com/webservices/AD_import_accounts.php?simulation=0

 


## Sources

- [wiki.openitop.org (Anglais)](https://wiki.openitop.org/doku.php?id=active_directory_integration&s[]=active&s[]=directory&s[]=import)


