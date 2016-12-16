+++
categories = ["baisser la version de hardware d une vm vmware","Bidouilles","Trucs et Astuces","VMware"]
description = ""
draft = false
date = 2014-12-15T09:53:08Z
author = "MrRaph_"
tags = ["baisser la version de hardware d une vm vmware","Bidouilles","Trucs et Astuces","VMware"]
image = "https://techan.fr/wp-content/uploads/2014/12/vsphere_logo_miniature.png"
slug = "baisser-la-version-de-hardware-dune-vm-vmware"
title = "Baisser la version de hardware d'une VM VMware"

+++


### Le problème

Dans le but de monter une maquette, il m’a fallu déployer un template de VM créé en version 5.5 de vSphere sur un vieil ESX en version 4.0 rallumé pour l’occasion. Cette opération peut paraître banale, mais dans ce cas le template avec une version de virtaul hardware trop élevé pour le vieil ESX. Le template utilise un hardware en version 8 alors que l’ESX 4.0 ne supporte que jusqu’à la version 7. Il a donc fallu ruser pour pouvoir baisser la version de hardware d’une VM VMware.  
  
  

### La solution

 

Après quelques recherches sur l’internet multimédia, j’ai trouvé une KB de VMware qui donne des pistes pour baisser la version de hardware d’une VM VMware. Vous trouverez le lien vers cette KB en bas de l’article.

La première propose de revenir à un snapshot de la VM avant la monter de version du virtual hardware, ce qui n’était pas possible dans mon cas puisque le template a été créé directement en version 8.

La seconde, conseille d’utiliser vCenter Converter Standalone afin de convertir la VM dans une version de hardware plus bas, mais cela fait installer un outil que nous n’avions pas.

La troisième finalement, propose une bidouille qui m’a plu. Il s’agit de de créer une nouvelle VM dans la version de virtual hardware souhaitée et d’y attacher les disques de la VM trop haute en hardware. Je confirme, cela fonctionne !

 

### La marche à suivre

Dans un premier temps, j’ai cloné le template dont je voulais baisser la version de hardware d’une VM VMware.

Pendant le clone, on crée une nouvelle machine virtuelle en mode « Custom » et non « Typical » afin d’avoir accès à toutes les options de configuration. Précisez bien l’OS comme d’habitude, et faites attention à bien choisir la bonne version de virtual hardware que vous visez. Dans la configuration des disques, choisissez l’option ne pas créer de disques virtuels.

Une fois le clone achevé, convertissez le en machine virtuelle, puis dans les paramètres, supprimer les disques de la VM, **sans toute fois les supprimer du datastore**.

Vous pouvez « Borwser » le datastore pour déplacer les disque de la VM d’origine si vous le souhaitez puis éditer les paramètres de la nouvelle VM vide et ajoutez les disques de l’ancienne VM.

On clique sur la flèche verte, et la VM démarre dans un version plus ancienne de virtual hardware comme par magie, ou presque !

 

#### Source

[kb.vmware.com](http://kb.vmware.com/selfservice/microsites/search.do?language=en_US&cmd=displayKC&externalId=1028019)


