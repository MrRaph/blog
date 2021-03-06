+++
title = "Publier automatiquement sur FaceBook les nouveaux posts dans Hugo"
date = 2016-05-19T09:38:02Z
author = "MrRaph_"
description = ""
slug = "publier-automatiquement-sur-facebook-les-nouveaux-posts-dans-hugo"
draft = false
image = "/images/2017/01/hugo-logo.png"
categories = ["Blog", "Trucs et Astuces", "automatisation"]
tags = ["Blog", "Trucs et Astuces", "automatisation"]
+++

__*Note : Ceci fonctionne également pour [Ghost](https://ghost.org/fr/), en remplaçant l'URL du flux RSS par : http://monsite.net/rss/*__

Dans un premier, il faudra que vous vous créiez un compte sur le site d'[IFTTT](https://ifttt.com).
Une fois votre en main, vous allez créer une nouvelle recette ! ;-)

Une recette se compose de deux éléments, une condition et une action déclenchée lorsque cette condition est validée.


![](https://techan.fr/images/2016/04/Sélection_010.png)


Comme condition, nous allons utiliser "_Feed_" qui vérifie un flux RSS.

![](https://techan.fr/images/2016/04/Sélection_011.png)

Dans la configuration de cette condition, nous allons utiliser "_New feed item_".

![](https://techan.fr/images/2016/04/Sélection_012.png)

Renseignez l'URL du flux RSS de votre blog Hugo.

![](https://techan.fr/images/2016/04/Sélection_013.png)

Comme action, nous allons utiliser "_Faceboo Pages_", pour cela, cliquez sur l'icône appropriée.

![](https://techan.fr/images/2016/04/Sélection_014.png)

[IFTTT](https://ifttt.com) vous demandera alors de connecter votre compte Facebook à votre compte sur le site. Suivez les étapes ;-)

![](https://techan.fr/images/2016/04/Sélection_015.png)

Personnalisez la façon dont les posts seront ajoutés sur votre page Facebook.

![](https://techan.fr/images/2016/04/Sélection_016.png)

Et enfin, créez votre recette ! :-)

##Sources

* [www.mljenkins.com](http://www.mljenkins.com/2016/01/24/blueproximity-on-ubuntu-14-04-lts/)
* [ubuntuforums.org](http://ubuntuforums.org/showthread.php?t=702372)
