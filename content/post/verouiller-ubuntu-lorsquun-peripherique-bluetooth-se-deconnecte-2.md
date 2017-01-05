+++
description = ""
slug = "verouiller-ubuntu-lorsquun-peripherique-bluetooth-se-deconnecte-2"
draft = false
title = "Vérouiller Ubuntu lorsqu'un périphérique Bluetooth se déconnecte"
date = 2016-05-18T10:03:44Z
author = "MrRaph_"

+++

### Installation des pré-requis

Afin de pouvoir utiliser la fonctionnalité fournie par Blueproximity, il faut installer le paquet _blueproximity_.

<pre><code class="hljs bash">sudo apt-get install blueproximity</code></pre>

### Création des scripts de verouillage et de déverrouillage.

Nous allons devoir créer les deux scripts suivants.

<pre><code class="hljs bash">sudo vi /usr/share/blueproximity/unlockScreen.sh</code></pre>

<pre><code class="hljs bash">#!/bin/bash
session=$(loginctl show-user $SUDO_USER | sed -n '/Display/ s/Display=//p')
loginctl unlock-session $session</code></pre>


<pre><code class="hljs bash">sudo vi /usr/share/blueproximity/lockScreen.sh</code></pre>

<pre><code class="hljs bash">#!/bin/bash
session=$(loginctl show-user $SUDO_USER | sed -n '/Display/ s/Display=//p')
loginctl lock-session $session</code></pre>

Il nous faut maintenant positionner les droits sur ces nouveaux scripts.

<pre><code class="hljs bash">sudo chown root: /usr/share/blueproximity/*lockScreen.sh
sudo chmod 0755 /usr/share/blueproximity/*lockScreen.sh</code></pre>

Enfin, nous configurons _sudo_ pour que les scripts puissent être utilisés.

<pre><code class="hljs bash">$ sudo su -
# cat <<EOF >> /etc/sudoers.d/blueproximity
# Allow users to lock and unlock their screens by running these scripts as sudo
ALL ALL=NOPASSWD: /usr/share/blueproximity/lockScreen.sh
ALL ALL=NOPASSWD: /usr/share/blueproximity/unlockScreen.sh
EOF</code></pre>


### Configuration de Blueproximity

Pour configurer l'outil, il faut tout d'abord le lancer.

<pre><code class="hljs bash">blueproximity</code></pre>


![Cliquez sur 'Scan for devices'](https://techan.fr/images/2016/04/BlueProximity_Preferences_005.png)


![Sélectionnez le périphérique et cliquez sur 'Use selected device'](https://techan.fr/images/2016/04/BlueProximity_Preferences_006.png)

![Cliquez sur 'Scan channels on devices'](https://techan.fr/images/2016/04/BlueProximity_Preferences_007.png)

![Sélectionnez un channel marqué comme 'usable' et cliquez sur 'Fermer'](https://techan.fr/images/2016/04/BlueProximity_Preferences_008.png)

Nous allons maintenant ajouter BlueProximity au démarrage de la session, pour cela ouvrez les "Applications au démarrage".

![Applications au démarrage](https://techan.fr/images/2016/04/Sélection_009.png)

Ajoutez BlueProximity au démarrage.

![Ajoutez BlueProximity au démarrage](https://techan.fr/images/2016/04/BlueProximity_startup_005.png)


Modifier le fichier de configuration de Blueproximity.

<pre><code class="hljs bash">vi ~/.blueproximity/standard.conf</code></pre>

<pre><code class="hljs bash">lock_command = sudo /usr/share/blueproximity/lockScreen.sh
unlock_command = sudo /usr/share/blueproximity/unlockScreen.sh
proximity_command = sudo /usr/share/blueproximity/unlockScreen.sh</code></pre>

Et voilà, fermez et ré-ouvrez votre session !

## Sources

* [www.mljenkins.com](http://www.mljenkins.com/2016/01/24/blueproximity-on-ubuntu-14-04-lts/)
* [ubuntuforums.org](http://ubuntuforums.org/showthread.php?t=702372)