+++
date = 2015-09-09T10:45:04Z
categories = ["redémarrage distant","redémarrer un ordinateur windows à distance","Trucs et Astuces","Windows"]
tags = ["redémarrage distant","redémarrer un ordinateur windows à distance","Trucs et Astuces","Windows"]
title = "Redémarrer un ordinateur Windows à distance"
author = "MrRaph_"
image = "https://techan.fr/images/2015/06/windows_10_logo.png"
description = ""
slug = "redemarrer-un-ordinateur-windows-a-distance-2"
draft = false

+++


Il est pratique de pouvoir redémarrer un ordinateur à distance surtout quand ce dernier se trouve dans un placard, sans clavier ni souris, voire même sans écran. Avec Linux la chose est très aisée, une petite connexion SSH, la commande reboot et le tour est joué ! Mais lorsque la machine tourne sous Windows la chose est un peu moins facile.

 

Il existe toute fois une commande DOS – équivalente à la commande **shutdown** sous Linux – qui permet de redémarrer, ou d’arrêter l’ordinateur.

 

<div class="wp-caption aligncenter" id="attachment_1712" style="width: 664px">[![Redémarrer un ordinateur Windows à distance](https://techan.fr/images/2015/09/screenshot.840.jpg)](https://techan.fr/images/2015/09/screenshot.840.jpg)Page d’aide de la commande shutdown.

</div> 

Comme indiqué dans l’aide, cette commande peut être utilisée sur l’ordinateur local ou bien sur une machine distante. La syntaxe pour l’utiliser sur un Windows distant est la suivante :

    shutdown -r -f -m \\<NOM DE L'ORDINATEUR> -t 0

 

L’option **-r** précise que l’on souhaite que l’ordinateur redémarre après l’arrêt, le flag **-f** quant à lui force l’action, l’option **-t** précise le temps – en secondes – dans lequel l’action sera réalisée ici j’ai mis **0** pour que ce soit fait immédiatement. Enfin, l’option **-m** est celle qui nous intéresse le plus, elle permet de spécifier la cible de la commande – l’ordinateur distant – notez que le nom de l’ordinateur est préfixé des deux « back slash » – **\\** – très Windowsiens.

 

Si comme dans mon cas cette commande vous renvoie une erreur d’authentification, il faut ajouter une commande supplémentaire avant de lancer le **shutdown**. On va s’identifier sur un partage spécial de l’ordinateur distant avant de lancer la commande. Cette opération se fait en utilisant la commande **NET USE** comme pour monter un partage réseau. Il vous faudra spécifier :

- Le nom de l’ordinateur distant
- Le mot de passe du compte administrateur de la machine que l’on souhaite utiliser
- Le nom de ce compte préfixé du nom de l’ordinateur distant séparés par un **\**.

 

    NET USE \\<NOM DE L'ORDINATEUR>\IPC$ <mot de passe de l'utilisater> /USER:<NOM DE L'ORDINATEUR>\<Identifiant de l'utilisateur> shutdown -r -f -m \\<NOM DE L'ORDINATEUR> -t 0

 

Et voilà, vous pouvez maintenant vous passer de connecter un clavier et une souris pour redémarrer des ordinateurs fonctionnant sous Windows !

 
