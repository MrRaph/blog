+++
categories = ["empêcher windows de rebooter automatiquement après une mise à jour","Mise à jour","reboot","Windows"]
image = "https://techan.fr/wp-content/uploads/2014/12/windows_logo_mini.png"
description = ""
draft = false
date = 2015-08-07T11:37:43Z
author = "MrRaph_"
tags = ["empêcher windows de rebooter automatiquement après une mise à jour","Mise à jour","reboot","Windows"]
slug = "empecher-windows-de-rebooter-automatiquement-apres-une-mise-a-jour"
title = "Empêcher Windows de rebooter automatiquement après une mise à jour"

+++


Il n’y a rien de plus ennuyeux que de devoir arrêter ce qu’on fait car Windows nous force a redémarrer après une mise à jour … Vous savez le petite fenêtre en base qui vous demande si vous voulez reporter le redémarrage ou non ..? Et bien sachez qu’on peut désactiver ce fonctionnement, voici comme s’y prendre.

 


## La marche à suivre

Appuyez sur la touche **Windows**.

 

[![screenshot.662](https://techan.fr/wp-content/uploads/2015/07/screenshot.662.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.662.jpg)

Tapez **regedit** dans la zone de recherche.

 

[![screenshot.663](https://techan.fr/wp-content/uploads/2015/07/screenshot.663.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.663.jpg)

Faites un clic droit sur **regedit.exe** et cliquez sur **Exécuter en tant qu’administrateur**.

 

[![screenshot.664](https://techan.fr/wp-content/uploads/2015/07/screenshot.664.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.664.jpg)

Cliquez sur **Oui**.

 

[![Empêcher Windows de rebooter automatiquement après une mise à jour](https://techan.fr/wp-content/uploads/2015/07/screenshot.665.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.665.jpg)

 

Dépliez l’arborescence suivante : **HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows\WindowsUpdate\AU**. Si comme dans mon cas les clefs **WindowsUpdate **et **AU** n’existent dans votre registre, créez les comme suit.

 

[![Empêcher Windows de rebooter automatiquement après une mise à jour](https://techan.fr/wp-content/uploads/2015/07/screenshot.666.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.666.jpg)

Faites une clic droit sur le niveau supérieur – **Windows** -, dépliez **Nouveau** et cliquez sur **Clé**. Nommez la **WindowsUpdate**.

 

[![Empêcher Windows de rebooter automatiquement après une mise à jour](https://techan.fr/wp-content/uploads/2015/07/screenshot.667.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.667.jpg)

Faites une clic droit sur la clef **WindowsUpdate**, dépliez **Nouveau** et cliquez sur **Clé**. Nommez la **AU**.

 

[![Empêcher Windows de rebooter automatiquement après une mise à jour](https://techan.fr/wp-content/uploads/2015/07/screenshot.668.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.668.jpg)

 

Maintenant que vous avez toute l’arborescence, faites un clic droit sur la clef **AU**, dépliez **Nouveau** et cliquez sur **Valeur DWORD 32 bits**. Nommez la **NoAutoRebootWithLoggedOnusers**.

 

[![Empêcher Windows de rebooter automatiquement après une mise à jour](https://techan.fr/wp-content/uploads/2015/07/screenshot.669.jpg)](https://techan.fr/wp-content/uploads/2015/07/screenshot.669.jpg)

 

Double cliquez sur cette nouvelle valeur et renseignez **1 **dans le champ ** Données de la valeur**.

Un reboot de la machine et vous ne serez plus embêté par le redémarrage intempestifs !

 


##  Source

- [lifehacker.com (Anglais)](http://lifehacker.com/stop-windows-from-restarting-your-computer-after-update-509712123)

 


