+++
author = "MrRaph_"
categories = ["calDAV","carDAV","iOS","OwnCloud","SSL"]
slug = "synchronisation-ssl-impossible-entre-ios-et-owncloud-8"
title = "Synchronisation SSL impossible entre iOS et OwnCloud 8"
date = 2015-02-19T10:01:59Z
tags = ["calDAV","carDAV","iOS","OwnCloud","SSL"]
image = "https://techan.fr/images/2014/09/iOS_icone_reglages.png"
description = ""
draft = false

+++


Après avoir entrepris la migration d’OwnCloud 7 vers la version 8, j’ai eu, entre autre surprise, la déception de constater que la synchronisation des contacts et des calendriers venant d’OwnCloud sur mon iPhone ne fonctionnait plus … Après pas mal d’investigation hier dans la soirée, j’ai trouvé mon erreur et vous la partage à présent. En fait, il suffisait de suivre la documentation d’OwnCloud mais je ne trouve pas ça très clair …

 

La documentation en question est [accessible ici](http://doc.owncloud.org/server/8.0/user_manual/pim/sync_ios.html), voici le passage qui a solutionné mon souci et que je ne trouve pas hyper clair.

 

[![Synchronisation SSL impossible entre iOS et OwnCloud 8](https://techan.fr/images/2015/02/ios_cardav_caldav_5.png)](https://techan.fr/images/2015/02/ios_cardav_caldav_5.png)

Lorsque vous configurez votre/vos compte(s), il faut indiquer l’adresse du serveur en utilisant l’URL complète, comme indiqué, <span style="text-decoration: underline;">mais ne surtout pas mettre le « https:// » au début</span>, sinon la sanction est immédiate, cela ne fonctionne pas !

 

Je vais décrire la procédure ci-dessous, attention, les captures d’écran ont été faites <span style="text-decoration: underline;">après</span> la configuration, les valeurs ont été modifiées par iOS. Je vous indiquerai à chaque fois ce qu’il faut mettre dans les champs.

 

<div class="wp-caption aligncenter" id="attachment_1043" style="width: 760px">[![Synchronisation SSL impossible entre iOS et OwnCloud 8](https://techan.fr/images/2015/02/ios_cardav_caldav_1.png)](https://techan.fr/images/2015/02/ios_cardav_caldav_1.png)Serveur : ADDRESS/remote.php/caldav/principals/username  
 Renseigner l’URL complète en changeant « ADDRESS » et « username » mais enlever le « https:// » au début !

</div> 

 

 

<div class="wp-caption aligncenter" id="attachment_1044" style="width: 760px">[![Synchronisation SSL impossible entre iOS et OwnCloud 8](https://techan.fr/images/2015/02/ios_cardav_caldav_2.png)](https://techan.fr/images/2015/02/ios_cardav_caldav_2.png)Effacer le contenu du champs « URL du compte ».

</div> 

 

<div class="wp-caption aligncenter" id="attachment_1045" style="width: 760px">[![Synchronisation SSL impossible entre iOS et OwnCloud 8](https://techan.fr/images/2015/02/ios_cardav_caldav_3.png)](https://techan.fr/images/2015/02/ios_cardav_caldav_3.png)Serveur : ADDRESS/remote.php/carddav/principals/username  
 Renseigner l’URL complète en changeant « ADDRESS » et « username » mais enlever le « https:// » au début !

</div> 

 

<div class="wp-caption aligncenter" id="attachment_1046" style="width: 760px">[![Synchronisation SSL impossible entre iOS et OwnCloud 8](https://techan.fr/images/2015/02/ios_cardav_caldav_4.png)](https://techan.fr/images/2015/02/ios_cardav_caldav_4.png)Effacer le contenu du champs « URL du compte ».

</div> 

Et voila, tout devrait fonctionner et les valeurs affichées après la vérification des comptes devraient ressembler à celles des captures d’écran.

 


