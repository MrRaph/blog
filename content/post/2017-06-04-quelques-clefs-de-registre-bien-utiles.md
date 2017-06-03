+++
slug = "quelques-clefs-de-registre-bien-utiles"
draft = false
date = "2017-06-04T11:46:12+01:00"
image = "/images/2017/06/rescue_windows.png"
type = "post"
description = ""
title = "Quelques clefs de registres bien utiles ..."
author = "MrRaph_"
categories = ["Trucs et Astuces","Windows","SOS", "AWS"]
tags = ["Trucs et Astuces","Windows","SOS", "AWS"]
+++


Dans le [précédent article](https://techan.fr/secourir-un-windows-sans-acces-a-sa-console), j'expliquait comme secourir un Windows pour lequel aucun accès classique n'est disponible. Dans cet article, je vais décrire quelques clefs de registre qui pourraient vous être bien utiles pour dépanner un serveur Windows via sa base de registre.

# Désactiver le "Shutdown Event Tracker"

Le "Shutdown Event Tracker", c'est cette délicieuse pop-up qui vous empêche d'arrêter ou de redémarrer votre serveur Windows en vous posant des questions sur la raison de cet arrêt. Cette fonctionalité peut devenir gênante si vous envoyez une de vos VMs telle qu'elle chez AWS par exemple. Vous ne pourrez pas alors éteindre votre Windows "proprement" car cette chose bloquera l'arrêt du système.


![La pop-up diabolique ...](/images/2017/06/Windows_Shutdown_Event_Tracker.png)


Pour désactiver ceci, il faut ajouter la clef `HKEY_LOCAL_MACHINE\SOFTWARE\Policies\Microsoft\Windows NT\Reliability` si elle n'existe pas déjà sur votre système. Ensuite, il faut créer un DWORD nommé `ShutdownReasonOn` et lui mettre la valeur `0`.


# Paramètrer une interface réseau pour utiliser le DHCP

De la même façon, si vous n'arrivez pas à vous connecter à votre VM, c'est peut être que l'adresse IP qu'elle tente d'utiliser n'est pas - plus - correcte. Vous voudrez alors sans doute la mettre en DHCP pour qu'elle récupère une adresse IP correcte dans votre réseau. Il est également possible de faire cela via le registre, en positionnant les clefs suivantes.

Vous devrez faire cela pour chaque interface que vous voudrez mettre en DHCP, notez qu'il est assez aisé de les identifier car les IP fixes sont configurées dans des clefs voisines de celles que l'on va éditer.

Dans `regedit`, rendez-vous dans la clef `HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Services\{Adapter}\Parameters\Tcpip`, cherchez la clef qui s'appelle `EnableDHCP`, ou créez la si elle n'existe pas, il s'agit d'un `DWORD`. La valeur `0` signifie que le DHCP est désactivé pour cette interface, la valeur `1` signifie au contraire qu'il est activé.


# Activer l'AutoLogon sur Windows

L'AutoLogon représente une faille de sécurité, mais ceci peut être nécessaire de manière temporaire pour réparer une machine. Je m'en suis servi pour installer un programme en utilisant le dossier "Start Up" de l'administrateur pour lequel j'avais configuré l'AutoLogon.

Une nouvelle fois, ouvrez `regedit`. Rendez-vous dans cette clef `HKLM\Software\Microsoft\Windows NT\CurrentVersion\winlogon` et cherchez la clef `AutoAdminLogon`. Si elle n'existe pas, créez la. Si la valeur de cette clef est `1`, la connexion automatique est activé, sinon si la valeur est `0`, elle est désactivée.

Il va falloir également positionner deux autres clefs pour que ceci fonctionne. Dans un premier temps, il faut ajouter la clef `DefaultUserName`, toujours sous `HKLM\Software\Microsoft\Windows NT\CurrentVersion\winlogon`, il s'agit d'une clef de type `String`, ça valeur sera le nom du compte qui va se connecter automatiquement. Ensuite, il faut ajouter une autre `String` nommé `DefaultPassword` qui elle aura pour valeur le mot de passe du compte sépcifié dans la clef `DefaultUserName`.

Si le compte qui doit se connecter automatiquement est un compte AD, alors il faudra ajouter une troisième clef de type `String`, nommée `DefaultDomainName` dont la valeur sera le nom du domaine auquel appartient le compte `DefaultUserName`.

# Sources

* [4sysops - How to disable the Shutdown Event Tracker in Windows Server 2008 R2 (Anglais)](https://4sysops.com/archives/how-to-disable-the-shutdown-event-tracker-in-windows-server-2008-r2/)
* [pctools - Set DHCP (Anglais)](http://www.pctools.com/guides/registry/detail/270/)
* [tomsitpro - AutoLogon sur Windows](http://www.tomsitpro.com/articles/windows_server_2008-administration,2-105-3.html)
