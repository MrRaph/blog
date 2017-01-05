+++
author = "MrRaph_"
tags = ["réinitialiser le mot de passe root sur une appliance vcenter","reset password","root","vCenter","VMware"]
slug = "reinitialiser-le-mot-de-passe-root-sur-une-appliance-vcenter"
draft = false
title = "Réinitialiser le mot de passe root sur une appliance vCenter"
categories = ["réinitialiser le mot de passe root sur une appliance vcenter","reset password","root","vCenter","VMware"]
image = "https://techan.fr/images/2015/01/vmware_vsphere_client_high_def_icon_by_flakshack-d4o96dy.png"
description = ""
date = 2015-08-04T16:24:49Z

+++


Dans une infrastructure VMware le vCenter est bien souvent le cœur du dispositif et l’accès à son interface d’administration n’en ai que plus importante. Chez un client, le compte « root » du vCenter était verrouillé, j’ai cherché comment réinitialiser le mot de passe « root » du vCenter car ce mot de passe oublié/verrouillé empêchait de se connecter à la VAMI – Virtual Applicance Management Interface – à savoir, pour le vCenter l’URL de cette VAMI est https://<IP du vCenter>:5480/.

Cette interface permet de gérer les paramètres vitaux du vCenter – DB, SSO, Services, … – son accès est donc très important.

Voici la méthode que j’ai suivie pour récupérer l’accès à cette VAMI via le compte « root ».

 


## La marche à suivre

La première étape est de redémarrer le vCenter, au reboot, il faut éditer la configuration de GRUB.

Lorsque cet écran apparait, utilisez les flèches du clavier pour désactiver le boot automatique – quelques secondes par défaut.

 

[![Réinitialiser le mot de passe root sur une appliance vCenter](https://techan.fr/images/2015/08/1_menu_GRUB.png)](https://techan.fr/images/2015/08/1_menu_GRUB.png)

 

Une fois que vous êtes tranquille avec le boot automatique, appuyez sur la touche **p**, un mot de passe vous sera alors demandé.

 

[![Réinitialiser le mot de passe root sur une appliance vCenter](https://techan.fr/images/2015/08/2_menu_GRUB_password.png)](https://techan.fr/images/2015/08/2_menu_GRUB_password.png)  
 Ce mot de passe est **vmware** par défaut. Ce mot de passe peut être différent si vous avez réinitialisé le mot de passe du compte root en utilisant la VAMI.

Une fois le mot de passe accepté, surlignez la ligne **VMware vCenter Server Appliance** et appuyez sur **e**.

 

[![Réinitialiser le mot de passe root sur une appliance vCenter](https://techan.fr/images/2015/08/3_menu_GRUB_kernel.png)](https://techan.fr/images/2015/08/3_menu_GRUB_kernel.png)

 

Surlignez la ligne qui commence par **kernel** et appuyez sur la touche **e**.

Vous entrez en mode « édition », l’éditeur vous met directement en fin de ligne, ajoutez **init=/bin/bash** à la fin.

 

[![4_menu_GRUB_kernel_bash](https://techan.fr/images/2015/08/4_menu_GRUB_kernel_bash.png)](https://techan.fr/images/2015/08/4_menu_GRUB_kernel_bash.png)

 

Une fois l’ajout réalisé, appuyez sur **Entrée**. Le menu de GRUB réapparait alors, appuyez sur **b** pour lancer la séquence de boot de l’appliance.

Le système démarre et vous amène directement dans un Shell « root », utilisez la commande **passwd root** pour changer le mot de passe de « root ».

 

[![5_vcenter_boot_single](https://techan.fr/images/2015/08/5_vcenter_boot_single.png)](https://techan.fr/images/2015/08/5_vcenter_boot_single.png)

 

Tout est bon maintenant, il n’y a plus qu’à lancer un **reboot** de l’appliance et à attendre que le système démarre complètement.

Et voilà, vous pouvez vous connecter à la VAMI en utilisant le nouveau mot de passe du compte « root ».

 

[![6_vami_fonctionnelle](https://techan.fr/images/2015/08/6_vami_fonctionnelle.png)](https://techan.fr/images/2015/08/6_vami_fonctionnelle.png)

 


## Source

- [www.settlersoman.com (Anglais)](http://www.settlersoman.com/how-to-reset-root-password-on-vcenter-appliance/)


