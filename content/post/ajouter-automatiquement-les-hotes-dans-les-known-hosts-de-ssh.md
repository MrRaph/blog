+++
title = "Ajouter automatiquement les hôtes dans les known hosts de SSH"
date = 2015-01-29T17:13:04Z
author = "MrRaph_"
categories = ["ajouter automatiquement les h tes dans les known hosts de ssh","Known Hosts","SSH","Trucs et Astuces"]
tags = ["ajouter automatiquement les h tes dans les known hosts de ssh","Known Hosts","SSH","Trucs et Astuces"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
slug = "ajouter-automatiquement-les-hotes-dans-les-known-hosts-de-ssh"
draft = false
description = ""

+++


Lorsque que l’on se connecte pour la première fois à une machine en SSH, le client demande si l’on souhaite ajouter l’hôte aux « known hosts ». En gros, il écrit la « RSA FingerPrint » dans un fichier local, ainsi SSH est sûr que l’hôte est bien celui qu’il dit être. Cependant, ça m’ennuie de devoir taper ‘yes’ à chaque fois … J’ai donc trouvé une astuce pour ajouter automatiquement les hôtes dans les known hosts de SSH.


## L’astuce

Éditez le fichier ‘~/.ssh/config’, s’il n’existe pas créez le. Ajoutez autant de blocs comme ci-dessous que nécessaire.

Host 192.* StrictHostKeyChecking no

Dans ce cas, tous les hosts dont le nom commence par ‘sl-‘ sont acceptés automatiquement.

[nagios@xxxxxx .ssh]$ ssh 192.168.0.1 Warning: Permanently added '192.168.0.1' (RSA) to the list of known hosts. [nagios@192.168.0.1 ~]$ logout Connection to 192.168.0.1 closed.

 

 


