+++
author = "MrRaph_"
description = ""
slug = "utiliser-skype-for-business-sur-linux"
draft = false
title = "Utiliser Skype for Business sur Linux"
date = 2016-05-19T09:47:31Z
categories = ["Linux","Trucs et Astuces","Ubuntu"]

+++

### Installation des pré-requis

Afin de pouvoir se connecter à Skype for Business avec Pidgin, il nous faut installer un dépôt supplémentaire et installer le paquet _pidgin-sipe_.

<pre><code class="hljs bash">sudo add-apt-repository ppa:sipe-collab
sudo apt-get update
sudo apt-get upgrade
sudo apt-get install pidgin-sipe</code></pre>

Il faut également ajouter une ligne dans le fichier _~/.bashrc_.

<pre><code class="hljs bash">echo "export NSS_SSL_CBC_RANDOM_IV=0" >> ~/.bashrc
source ~/.bashrc</code></pre>

### Configuration de Pidgin

Démarrez Pidgin et ajoutez un nouveau compte, choissiez le protocole _Office Communicator_ et reseignez votre compte - dans le champ _Utilisateur_ - ainsi que le mot de passe de ce compte.

![](https://techan.fr/images/2016/03/skype_configuration_compte_1.png)


Passons maintennant à la configuration avancée, ceci se passe dans l'onglet _Avancé_.

* Laissez le _Type de connection_ sur _Auto_
* Renseignez l'_Agent utilisateur_ avec la valeur : ``UCCAPI/15.0.4753.1000 OC/15.0.4753.1003``
*  Changez le _Schéma d'authentification_ et choissez _TLS-DSK_

![](https://techan.fr/images/2016/03/skype_configuration_compte_2.png)


Et voilà, il ne vous reste plus qu'à vous connecter à votre compte !
