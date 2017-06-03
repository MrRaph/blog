+++
slug = "secourir-un-windows-sans-acces-a-sa-console"
draft = false
date = "2017-06-03T11:46:12+01:00"
image = "/images/2017/06/rescue_windows.png"
type = "post"
description = ""
title = "Secourir un Windows sans accès à sa console"
author = "MrRaph_"
categories = ["Trucs et Astuces","Windows","SOS", "AWS"]
tags = ["Trucs et Astuces","Windows","SOS", "AWS"]
+++

# TL;DR

Vous n'avez pas le temps de lire ma prose ? Qu'à cela ne tienne ! Voici les étapes à suivre pour opérer votre Windows malade à coeur ouvert.

* Retirer le disque C: malade de sa VM
* Connecter le disque C: malade sur un autre Windows
* Charger le `hive` que vous souhaitez éditer avec la commande : `reg load HKLM\<Nom à votre convenance> d:\Windows\System32\config\SYSTEM`
* Editer le registre avec `regedit`
* Décharger le `hive` malade avec la commande : `reg unload HKLM\<Nom à votre convenance>`
* Déconnecter proprement le disque malade de l'instance de secours et le reconnecter à l'instance malade
* Essayer de démarrer le Windows malade


# Ah ... Windows !

Dans le petit des SysOps, il y a des opérations de secours que l'on aime bien et d'autres qui nous rebutent ... Dans celles qui me plaisent, je citerais par exemple "les premiers secours à Linux en danger" ou encore "faire repartir un serveur Linux à grands coups de défibrilateur". Par contre, celles qui me rebutent incluent presque tout le temps un serveur Windows ... En effet, dès que l'on parle de Windows rien n'est vraiment simple. Dès que l'on doit faire des choses un petit peu pointues, il faut sortir l'éditeur de registre et là, les ennuis commencent ...

Ceci est d'autant plus compliqué si l'on n'a pas un accès direct à la machine à sauver. Par exemple, vous avez envoyé votre super serveur "kifaitou" chez AWS, il démarre et tout, vous voyez la belle page vous invitant à vous connecter, mais impossible de l'attaquer à distance par RDP.


![Oh, un écran de connexion inaccessible ...](/images/2017/06/Windows_ecran_connexion_inaccessible.png)

Ah oui, car chez AWS, vous pouvez voir des copie d'écran de la console de votre instance, mais vous ne pouvez pas en prendre le contrôle.


![Afficher une copie d'écran de la console d'une instance AWS](/images/2017/06/AWS_afficher_console_instance.png)


Alors, elle en est ou la frustration là !?! :)


# Chirurgie à coeur ouvert

*Note :* _Avant de réaliser les opérations ci-dessous, assurez vous d'avoir une sauvegarde récente du disque malade, ou mieux, faites en une tout de suite !_

Aller, on se détend, il existe une astuce pour opérer notre Windows défaillant ! J'ai pris l'exemple d'AWS mais cette astuce fonctionnera avec n'importe quel serveur Windows, pour peu que vous puissiez présenter son disque C: à un autre serveur Windows.

Tout d'abord, éteignez l'instance malade, si vous avez d'autre Windows fonctionnel, créez une autre instance Windows. Lorsque le grand malade est arrêté, détachez son disque C: et branchez le sur le Windows valide. Bien évidement, il faudra le monter sur un disque autre que C: sur l'instance valide, sinon on tourne en rond ! Dans mon cas, je l'ai présenté sur le disque D: de mon Windows de secours.

Nous allons maintenant pouvoir charger le registre de notre Windows malade dans celui du Windows de secours. Ainsi nous pourrons éditer le registre malade comme si nous éditions le registre valide. Cette opération de chargement de registre se fait dans un `cmd.exe` lancé en administrateur, avec la commande suivante.

    C:> reg load HKLM\<Nom à votre convenance> d:\Windows\System32\config\SYSTEM

Cette commande va charger le registre `SYSTEM` de notre Windows malade à l'emplacement `HKEY_LOCAL_MACHINE\<Nom à votre convenance>`. Vous pouvez faire cela avec chacun des `hive` présent dans le dossier `d:\Windows\System32\config\`.


![Charger Hive malade](/images/2017/06/Windows_load_hive.png)


Maintenant, nous pouvons éditer cette partie de registre malade dans `regedit` ! :)



![Edition du hive malade](/images/2017/06/Windows_edit_loaded_hive.png)


Lorsque vos modifications sont terminées, il faut décharger le `hive` malade du registre de notre Windows valide. Ceci se fait, toujours dans un `cmd.exe` administrateur, avec la commande suivante.

    C:> reg unload HKLM\<Nom à votre convenance>


![Décharger Hive malade](/images/2017/06/Windows_unload_hive.png)


Il ne vous reste plus qu'à débrancher proprement le disque malade, le remonter sur le Windows malade et voir si votre modification à porté ses fruits... Et recommencer si celà n'est pas le cas :p

Bonne chance et bon courage !!
