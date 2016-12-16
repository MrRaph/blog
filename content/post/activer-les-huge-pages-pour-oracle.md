+++
date = 2015-01-29T10:03:18Z
author = "MrRaph_"
categories = ["activer les huge pages pour oracle","Huge Pages","Oracle","Trucs et Astuces","Tuning"]
slug = "activer-les-huge-pages-pour-oracle"
title = "Activer les Huge Pages pour Oracle"
draft = false
tags = ["activer les huge pages pour oracle","Huge Pages","Oracle","Trucs et Astuces","Tuning"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
description = ""

+++


Par défaut sur Linux, le pages mémoires allouées par le système ont une taille de 4 Ko. Les huge pages elles ont une taille de 2 Mo, vous allez me dire que c’est cool mais à quoi ça nous sert ? Et bien sur les instances qui ont beaucoup de mémoire (on va dire plus de 10 Go), utiliser les huge pages a un réel intérêt car avec les petites pages, Oracle va faire beaucoup de CPU pour passer d’une page à l’autre alors qu’avec les huge pages bien plus grosses, ce comportement sera bien moins impactant !


## Les Huges Pages et les Transparent Huge Pages

Les Huges Pages existent depuis assez longtemps sur RedHat (depuis les débuts du noyau 2.6) mais les Transparent Huge Pages elles ont été ajoutées dans RedHat 7. La différence entre ces deux là est que les Huge Pages doivent être configurées, on dit au système combien de Huge Pages il doit créer et il les crée lors de son démarrage. Si on veut en rajouter ou en enlever, il faut alors rebooter pour que cela soit effectif. Les Transparent Huge Pages sont elles allouées à la volée, dynamiquement par le système. Ces Transparent Huge Pages sont déconseillées car contrairement aux Huge Pages, elles sont swappables et Oracle déteste être swappé !

#### Détecter si les Huges Pages et/ou les Transparent Huges Pages sont activées

[root@xxxxxx ~]# cat /proc/meminfo | grep -i huge AnonHugePages: 1054720 kB HugePages_Total: 0 HugePages_Free: 0 HugePages_Rsvd: 0 HugePages_Surp: 0 Hugepagesize: 2048 kB

Le résultat de cette commande nous apprend que les Huge Pages ne sont pas activées sur ce système car le « HugePages_Total » est à zéro cependant, les Transparent Huge Pages sont activées car le « AnonHugePages » n’est pas égal à zéro. On peut également vérifier la présence des Transparent Huge Pages en regardant si le daemon « khugepaged » est présent sur le système.

[root@xxxxxx ~]# ps -ef |grep huge root 60 2 0 2013 ? 00:01:19 [khugepaged] root 18586 18556 0 09:02 pts/1 00:00:00 grep huge

####  Désactiver les Transparent Huge Pages

Pour désactiver les Transparent Huge Pages, il faut passer un paramètre supplémentaire au noyau du Linux. Cela se fait dans le fichier de configuration du lanceur (Grub de nos jours). Cette option est : « transparent_hugepage=never ».

[root@xxxxxx ~]# cat /boot/grub/grub.conf default=0 timeout=5 splashimage=(hd0,0)/grub/splash.xpm.gz hiddenmenu title Oracle Linux Server (3.8.13-26.2.1.el6uek.x86_64) root (hd0,0) kernel /vmlinuz-3.8.13-26.2.1.el6uek.x86_64 ro root=/dev/mapper/VolGroupSystem-LogVolRacine rd_NO_LUKS rd_LVM_LV=VolGroupSystem/LogVolSwap rd_LVM_LV=VolGroupSystem/LogVolRacine rd_NO_MD LANG=fr_FR.UTF-8 SYSFONT=latarcyrheb-sun16 KEYBOARDTYPE=pc KEYTABLE=fr-latin9 rd_NO_DM rhgb quiet numa=off transparent_hugepage=never initrd /initramfs-3.8.13-26.2.1.el6uek.x86_64.img

Les modifications seront effectives au prochain reboot sur ce noyau.

**<span style="text-decoration: underline;">Attention :</span>** En cas de mise à jour du système, il se peut qu’un nouveau noyau soit ajouté, il faudra penser a refaire cette manipulation.


## Activer les Huge Pages pour Oracle

#### Désactiver la gestion automatique de la mémoire

La gestion automatique de la mémoire est disponible depuis la version 11g d’Oracle, elle permet de ne plus avoir a gérer les différentes zones de la mémoire d’Oracle (SGA et PGA). On donne un total de mémoire a utiliser et Oracle coupe et redimensionne ses zones en fonction de ses besoins. Ce comportement n’est pas compatible avec les Huge Pages.

Pour désactiver l’AMM, il faut revenir au comportement qu’avait Oracle en 10g, c’est à dire :

- Mettre les paramètres « memory_target » et « memory_max_target » à 0 pour les désactiver
- Renseigner les paramètres liés à la SGA et à la PGA : - Pour la SGA : « sga_target » et « sga_max_size »
- Pour la PGA : « pga_target » et « pga_aggregate_target »

Ces paramètres ne sont appliqués qu’une fois que la base aura redémarrée.

#### Calculer le nombre de Huge Pages a créer

[root@xxxxxx ~]# cat /proc/meminfo MemTotal: 6125356 kB MemFree: 134556 kB

La machine dispose de 6 Go de mémoire totale, nous allons allouer 5 Go de mémoire aux HugePages.

Dans le fichier /etc/security/limits.conf, positionner les paramètres suivant :

* soft memlock 5242880 * hard memlock 5242880

Se reconnecter en temps qu’oracle pour vérifier la modification du paramètre via la commande :

ulimit –l

Calculons le nombre de de HugePages qui seront nécessaires à Oracle, le script utilisé est fourni par Oracle, vous le trouverez en vous connectant à au site [http://support.oracle.com](http://support.oracle.com), dans le Doc : « Doc ID 401749.1 ».

Recommended setting: vm.nr_hugepages = 1538

Vérifions que le paramètres des Huge Pages n’est pas déjà défini sur le système.

[root@CNSDAO11 ~]# grep "vm.nr_hugepages" /etc/sysctl.conf

Le paramètre « vm.nr_hugepages » n’est pas positionné sur ce système. Ajouter la ligne suivante dans le fichier « /etc/sysctl.conf ».

vm.nr_hugepages = 1538

Il ne reste plus qu’a redémarrer la machine et Oracle utilisera les Huge Pages 