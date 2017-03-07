+++
slug = "suse-manager-impossible-de-lancer-le-minion-salt"
draft = false
date = "2017-03-07T18:46:12+01:00"
image = "/images/2017/03/SUSE_Logo.png"
type = "post"
description = ""
title = "SuSE Manager : Impossible de démarrer un minion Salt"
author = "MrRaph_"
categories = ["SuSE","SuSE Manager","Trucs et Astuces"]
tags ["SuSE","SuSE Manager","Trucs et Astuces"]
+++

SuSE Manager est une solution de gestion de parc de machines SuSE et RedHat proposée par SuSE. Cette solution s'articule entre autres autour de Spacewalk - une solution open source également utilisée par RedHat - et de Salt. Salt est un outil de gestion de configuration, cet outil représente une alternative à Ansible, Puppet ou Chief. Salt permet de déployer des programmes et leur configuration sur une machine ou sur un groupe de machines. Cela permet de s'assurer que toutes les machines sont configurées de la même façon.

# Salt et le SuSE Manager

SuSE à choisi Salt pour son outil SuSE Manager. Salt permet au SuSE Manager de réaliser des actions de configuration internes, mais il est également accessible aux administrateurs de la solution. Cela permet d'ajouter encore plus de souplesse dans l'administration des systèmes.

Salt fonctionne en mode client/serveur, le serveur étant dans ce cas le SuSE Manager. Les clients sont toutes les machines rattachées au SuSE Manager. Les client s'appellent des "minions" dans le monde Salt.

## Ajout d'une machine dans le SuSE Manager 

L'ajout d'une machine dans le SuSE Manager requiert la création d'un dépôt "bootstrap" en avance de phase, cecin'eet ps documenté ici.

Sur la machine cliente que l'on souhaite ajouter au SuSE Manager, on ajoute ce fameux dépôt "bootstrap" à Zypper puis ont rafraîchi la liste des paquets.

     zypper ar -f http://smgr.susemgr.com/pub repositories/sle/12/0/bootstrap \
     bootstraprepo
     zypper ref
     
Lorsque ceci est fait, on peut installer le minion.
    
     zypper in salt-minion
     
Maintenant, il ne reste plus qu'à configurer le serveur maître dans la configuration du minion, 
ceci se fait dans le fichier ˋ/etc/salt/minionˋ. Ensuite, nous pouvons démarrer le minion avec la commande suivante.

     systemctl start salt-minion
     
## Erreur !!!
  
Dans mon cas, j'ai installé le SuSE Manager sur une SuSE SLES 12 SP1 et mon minion est une SuSE SLES 12. Je rencontre l'erreur suivante lorsque le minion essayé de démarrer.
     
    2017-03-01 16:26:08,333 [salt.scripts     ][ERROR   ][7628] No module named certifi 


Il manque visiblement le module Python ˋcertifiˋ dans le dépôt bootstrap et dans les dépôts de base. Ceci empêchera le minion de fonctionner. Pour cela, j'ai téléchargé le paquet ˋpython-certifi` pour openSuSE et j'ai reconstruit le dépôt bootstrap. 

## Correction !


Toutes les étapes pour ce faire sont les suivantes, elle sont à exécuter sur le SuSE Manager.

    cd /srv/www/htdocs/pub/repositories/sle/12/0/bootstrap 
    wget ftp://ftp.pbone.net/mirror/ftp5.gwdg.de/pub/opensuse/repositories/devel:/languages:/python/openSUSE_12.3/noarch/python-certifi-14.05.14-3.1.noarch.rpm
    mgr-create-bootstrap-repo -c SLE-12-x86_64
    
la dernière commande reconstruit le dépôt bootstrap.

Maintenant que le dépôt bootstrap contient la dépendance manquante, retournons sur la machine minion et recommençons.

Nous allons rafraichir la liste des paquets dans les dépôts et installer la librairie manquante.

    zypper ref
    zypper in python-certifi
    
Mainteant, il suffit de relancer le minion Salt !

     systemctl restart salt-minion 




