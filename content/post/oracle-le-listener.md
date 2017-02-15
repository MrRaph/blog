+++
date = 2014-10-24T10:39:45Z
categories = ["Listener","Oracle","Survival Guide"]
tags = ["Listener","Oracle","Survival Guide"]
slug = "oracle-le-listener"
title = "[Oracle] Le listener"
author = "MrRaph_"
image = "https://techan.fr/images/2014/10/SQL_term.png"
description = ""
draft = false

+++


Le listener est un programme fournit par Oracle qui écoute sur un port réseau, le 1521 par défaut, c’est la porte d’entrée dans le monde Oracle.  

 Ce programme reçoit les connexions clientes et les dispatche sur la bonne base Oracle. Un seul listener peut gérer les connexions vers plusieurs base de données.

On peut toute fois mettre en place pas mal de configurations différentes avec cet outil :

- Un seul listener pour toutes les bases de la machine
- Un listener par base sur le host (chacun aura un port différent)
- Un lister par version d’Oracle sur la machine (un listener pour les 10g, un autre pour les 11g, …)

 

### Lister tous les listeners démarrés sur une machine

Sur UNIX/Linux :

[![image2014-4-10 13-20-14](https://techan.fr/images/2014/10/image2014-4-10-13-20-14.png)](https://techan.fr/images/2014/10/image2014-4-10-13-20-14.png)

 

Dans cet exemple, on voit que la machine n’a qu’un seul listener démarré qui s’appelle : LISTENER.

 

### Afficher les bases enregistrées dans un listener

Les base Oracle vont s’enregistrer dans le listener, en faisant cela, elles deviennent accessibles par les clients.

On peut afficher les bases enregistrées dans un listener en utilisant l’outil « lsnrctl », c’est l’outil qui sert a administrer les listener d’Oracle.  
[![image2014-4-10 13-24-40](https://techan.fr/images/2014/10/image2014-4-10-13-24-40.png)](https://techan.fr/images/2014/10/image2014-4-10-13-24-40.png)

Le listener « LISTENER » écoute sur le poste 1512 et supporte deux bases Oracle lora12c1001d et TFTI1.

Dans cet affichage, on trouve également l’emplacement du fichier de log du listener.

 

### Démarrer / arrêter / recharger un listener

##### Stopper un listener

    lsnrctl <LISTENER NAME> stop

[![image2014-4-10 13-36-17](https://techan.fr/images/2014/10/image2014-4-10-13-36-17.png)](https://techan.fr/images/2014/10/image2014-4-10-13-36-17.png)

<span style="text-decoration: underline;">** Note :**</span> Stopper un listener va empêcher les nouvelles connexions aux base que ce listener supporte. Cela ne coupe pas les connexions déjà ouvertes, car elles ne passent alors plus apr le listener mais vont directement à la base Oracle.

 

##### Démarrer un listener

    lsnrctl <LISTENER NAME> start

[![image2014-4-10 13-38-26](https://techan.fr/images/2014/10/image2014-4-10-13-38-26.png)](https://techan.fr/images/2014/10/image2014-4-10-13-38-26.png)

 

##### Recharger un listener

Cette opération force le listener a relire et recharger sa configuration sans pour autant l’arrêter.

    lsnrctl reload <LISTENER NAME>

[![image2014-4-10 13-40-13](https://techan.fr/images/2014/10/image2014-4-10-13-40-13.png)](https://techan.fr/images/2014/10/image2014-4-10-13-40-13.png)

<span style="text-decoration: underline;">**Note :**</span>  Cette action est très rapide, n’interrompt pas les connexions actives, ni les nouvelles connexions pendant le rechargement de la configuration.

 

### Fichier de configuration du listener

La configuration du listener est situé dans le dossier suivant :

- UNIX/Linux : $ORACLE_HOME/network/admin
- Windows : %ORACLE_HOME%\network\admin

[![image2014-4-10 13-46-36](https://techan.fr/images/2014/10/image2014-4-10-13-46-36.png)](https://techan.fr/images/2014/10/image2014-4-10-13-46-36.png)

Le nom du fichier de configuration est : « listener.ora ».
