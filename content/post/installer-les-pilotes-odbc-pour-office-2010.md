+++
image = "https://techan.fr/wp-content/uploads/2014/12/windows_logo_mini.png"
description = ""
title = "Installer les pilotes ODBC pour Office 2010"
date = 2014-12-19T17:07:52Z
categories = ["installer les pilotes odbc pour office 2010","ODBC","Office","TroubleShooting","Windows"]
tags = ["installer les pilotes odbc pour office 2010","ODBC","Office","TroubleShooting","Windows"]
slug = "installer-les-pilotes-odbc-pour-office-2010"
draft = false
author = "MrRaph_"

+++


Pour les besoins d’une application, il m’a fallu chercher comment installer les pilotes ODBC pour Office 2010 et pas moyen de trouver une documentation sur Internet qui explique ce qu’il faut installer … Après avoir pas mal pataugé, j’ai enfin trouver comment faire.  
  
  


## Trouver l’architecture d’Office installée

Tout d’abord, il faut trouver l’architecture de l’Office installé sur la machine (32 ou 64 bits) afin de savoir quel outil utiliser pour installer les pilotes ODBC pour Office 2010.

Pour trouver cette information, il faut lancer Excel par exemple et aller dans « Fichier » -> « Aide ». Dans le panneau de droite vous trouverez une bonne tartine d’informations dont celle que l’on cherche.

[![version_office](https://techan.fr/wp-content/uploads/2014/12/version_office.png)](https://techan.fr/wp-content/uploads/2014/12/version_office.png)

Dans mon cas, j’ai une version 32 bits d’Office 2010 installée sur une machine 64 bits, le cas le plus délicieux.


## **Installer les pilotes ODBC pour Office 2010**

Rendez-vous dans le panneau de configuration puis dans Programmes et fonctionnalités sélectionnez Office et cliquez sur Modifier.

[![install_outil_office_1](https://techan.fr/wp-content/uploads/2014/12/install_outil_office_1.png)](https://techan.fr/wp-content/uploads/2014/12/install_outil_office_1.png)

Dans le programme d’installation d’Office, choisissez la première option.

 

[![install_outil_office_2](https://techan.fr/wp-content/uploads/2014/12/install_outil_office_2.png)](https://techan.fr/wp-content/uploads/2014/12/install_outil_office_2.png)

Sélectionnez « Microsoft Query » pour installation dans la catégorie « Outils Office ».

[![Installer les pilotes ODBC pour Office 2010](https://techan.fr/wp-content/uploads/2014/12/install_outil_office_3.png)](https://techan.fr/wp-content/uploads/2014/12/install_outil_office_3.png)

Cliquez sur Continuer sans fin jusqu’à ce que l’installation soit terminée et voila.


## Valider l’installation des pilotes ODBC

Alors dans un premier temps ce qu’il savoir c’est que sur les systèmes 64 bits, il y a les deux versions (32 et 64 bits) de l’outil de configuration de sources ODBC. Voici ou se trouvent ces versions respectives, <span style="text-decoration: underline;">**attention c’est très logique**</span> !

- Version 64 bits : C:\Windows\system32\odbcad32.exe
- Version 32 bits : C:\Windows\SysWOW64\odbcad32.exe

Voila, voila, j’adore …

Une fois qu’on sait ça, et qu’on fait exactement l’inverse de la logique, tout se passe bien !

Donc on lance la version qui va bien pour l’architecture d’Office, dans mon cas 32 bits, donc dans le répertoire 64 (non je ne m’en remet pas !).

[![outil_admin_odbc](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc.png)](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc.png)

On voit que mes pilotes sont bien apparus :

 

[![outil_admin_odbc_avec_office](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_office.png)](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_office.png)

Et comble du bonheur, on peut configurer les sources avec ces pilotes !

[![outil_admin_odbc_avec_office_qui_marche](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_office_qui_marche.png)](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_office_qui_marche.png)

Alors qui on lance la version 64 bits de l’outil, il nous insulte carrément …

[![outil_admin_odbc_avec_probleme_1](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_probleme_1.png)](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_probleme_1.png)

[![outil_admin_odbc_avec_probleme_2](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_probleme_2.png)](https://techan.fr/wp-content/uploads/2014/12/outil_admin_odbc_avec_probleme_2.png)


## Et si vous êtes vraiment malchanceux

L’application qui devait se servir de ces pilotes ODBC ne supporte pas la version 32 bits des sources ODBC et là vous êtes bons pour désinstaller Office 32 bits, installer Office 64 bits et recommencer cette manipulation. Courage !


