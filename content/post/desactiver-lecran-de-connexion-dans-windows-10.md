+++
draft = false
title = "Désactiver l'écran de connexion dans Windows 10"
author = "MrRaph_"
categories = ["désactiver écran de connexion","désactiver l écran de connexion dans windows 10","Trucs et Astuces","windows 10"]
description = ""
slug = "desactiver-lecran-de-connexion-dans-windows-10"
date = 2015-08-03T09:13:26Z
tags = ["désactiver écran de connexion","désactiver l écran de connexion dans windows 10","Trucs et Astuces","windows 10"]
image = "https://techan.fr/wp-content/uploads/2015/06/windows_10_logo.png"

+++


Si vous avez réussi à faire la mise à jour de votre ordinateur vers Windows 10, il y a surement des points qui vous ennuient un peu. Pour ma part le premier d’entre eux est l’écran de connexion. Je n’accède à ma machine qu’à distance – avec TeamViewer ou via le streaming de Steam et l’écran de connexion a la fâcheuse tendance à s’afficher régulièrement. Ce comportement n’est pas gênant en soi mais empêche le steaming de Steam…

 

En effet, le streaming ne démarre pas si l’écran est verrouillé … J’ai donc cherché une solution afin de désactiver cela.

 


## La marche à suivre

Il va vous falloir utiliser l’éditeur du registre pour cela, pour le lancer pressez les touches **Windows **et **R** simultanément, une pop-up va s’ouvrir. Dans cette pop-up tapez **regedit** puis cliquez sur **Ok**.

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.679.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.679.jpg)

Si le système vous demande une confirmation, cliquez sur **Oui**.

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.680.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.680.jpg)

Vous voici maintenant dans l’éditeur du registre. Nous allons y ajouter un valeur, pour cela, il faut naviguer dans les clefs – comme dans l’explorateur Windows. Suivez ce chemin dans l’arborescence :

**HKEY_LOCAL_MACHINE** -> **SOFTWARE** -> **Policies** -> **Microsoft** -> **Personalization**

Si vous n’avez pas la clef **Personalization**, il va falloir l’ajouter. Faites un clic droit sur la clef du niveau supérieur – **Windows** – dépliez le menu **Nouveau** puis cliquez sur **Clé**.

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.682.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.682.jpg)

Nommez cette nouvelle clef **Personalization**.

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.683.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.683.jpg)

 

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.681.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.681.jpg)

 

 

Maintenant, nous allons ajouter une nouvelle valeur dans la clef **Personalization**. Faites un clic droit sur la clef **Personalization**, développez le menu **Nouveau** et choisissez l’option **Valeur DWORD 32 bits**. Nommez cette nouvelle valeur **NoLockScreen**.

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.684.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.684.jpg)

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.685.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.685.jpg)

Double cliquez sur cette nouvelle valeur et mettez sa valeur à **1 **puis cliquez sur **Ok**.

 

[![Désactiver l'écran de connexion dans Windows 10](https://techan.fr/wp-content/uploads/2015/08/screenshot.686.jpg)](https://techan.fr/wp-content/uploads/2015/08/screenshot.686.jpg)

Tout est prêt, vous n’avez plus qu’a redémarrer votre ordinateur, vous n’aurez plus l’écran de connexion à tout bout de champ !


