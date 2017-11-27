+++
slug = "le-vpn-on-demand-ios-votre-preservatif-numerique"
draft = true
featured = ""
date = "2017-11-26T12:18:39"
featuredalt = ""
image = "/images/2017/11/ios.png"
type = "post"
description = ""
title = "Le VPN On-Demand iOS, votre préservatif numérique"
author = "MrRaph_"
featuredpath = ""
linktitle = ""
categories = ["Trucs et Astuces","iOS"]
tags = ["Trucs et Astuces","iOS"]
+++


La protection de la vie numérique se résument souvent pour beaucoup à mettre un code sur un appareil - ordinateur ou mobile - et ne va souvent pas bien plus loin.

On s’accroche à notre vie privée mais dans le même temps on se connecte aux réseaux wifi ouverts proposés dans les restaurants, les bars, les gares ... Sans se douter une seconde que ces réseaux ouverts laissent les mains libres aux gens mal intentionnés pouvant intercepter les données que l’on reçoit ou que l’on envoie.

Dans le même esprit mais plus insoupçonné, les réseaux mobiles 3G ou 4G sont également des réseaux ouverts. Certes les attaques sur ces réseaux ne sont pas aussi aisées que sur des Wifi ouverts mais le risque existe. D’autre part, les données que vous consommez sur les réseaux mobiles transitent par des serveurs de votre opérateur.

Bref, la vie numérique est un peu comme la vraie vie, mieux vaut sortir couvert. Un des préservatifs numérique s’appelle un VPN (Virtual Private Network). Le VPN est un programme auquel un appareil informatique peut se connecter. Une fois cette connexion effectuée, l’appareil et le serveur VPN sont reliés par une espèce de tunnel informatique par lequel les données transiteront. Les données sont chiffrées dans tout le tunnel, elles ressortent ensuite à la fin du tunnel et continuent leur route sur Internet. Un peu comme le tunnel sous la manche qui évite les turbulences de la Manche. Le VPN permet de sécuriser les échanges sur des réseaux non sûrs.

Il est possible d’utiliser un VPN sur les appareils mobiles. Mais c’est souvent fastidieux, en effet souvent il faut que l’utilisateur pense à initier la connexion au VPN, il arrive qu’il se déconnecte...

Depuis la version 8, iOS supporte le VPN on Demand, il s’agit d’un mécanisme qui permet de spécifier des réseaux Wifi sûrs. iOS se chargera ensuite automatiquement de mettre ne place le VPN lorsque l’on est pas sur un réseau sûr ou de l’enlever lorsque l’on se connecte à un Wifi sûr - maison, travail, ...

Il existe des applications qui font tout cela pour vous, et qui vous fournissent le serveur VPN nécessaire - comme l'excellent <a href="https://itunes.apple.com/fr/app/tunnelbear-vpn/id564842283?mt=8&at=1001lsQf">TunnelBear VPN - TunnelBear, Inc. (500 Mo de VPN gratuit par mois)</a>. Le revers de la médaille c'est qu'il faut passer à la caisse, souvent via un abonnement mensuel, pour bénificier de leurs services. 

## Pré-requis

Il y a quelques prérequis avant de se lancer dans le VPN à la demande. 

Dans un premier temps, il faut un serveur OpenVPN fonctionnel. Ceci ne sera pas couvert dans cet article, mais son installation est assez simple avec Docker (voir [Protégez votre vie privée avec OpenVPN sur Docker](https://techan.fr/protegez-votre-vie-privee-avec-openvpn-sur-docker.html))

Il vous faudra une configuration cliente pour vous connecter à ce serveur OpenVPN, dans la suite de cet article, cette configuration sera nommée `config-client.ovpn`. 

Il faudra que Ruby soit installé sur le poste que vous utiliserez pour la suite de ce guide et que la gem `ovpnmcgen.rb` soit installée. Pour installer cette gem, il suffit d'utiliser la commande suivante :

    gem install ovpnmcgen.rb


Il faudra également que l'application <a href="https://itunes.apple.com/fr/app/openvpn-connect/id590379981?mt=8&at=1001lsQf">OpenVPN Connect - OpenVPN Technologies (Gratuite)</a> soit installée sur votre appareil iOS afin qu'il puisse se connecter au serveur OpenVPN.

## Modification de la configuration OpenVPN

Ouvrez le fichier votre fichier de configuration OpenVPN dans votre éditeur de texte préféré et vérifiez les points suivants.

Si votre configuration embarque les certificats, il faudra les sortir. Ces certificats sont englobés dans les balises suivantes dans la configuration OpenVPN :

* <ca> : Sortez le contenu de cette balise dans un fichier nommé `ca.crt`
* <key> : Sortez le contenu de cette balise dans un fichier nommé `cert.key`
* <cert> : Sortez le contenu de cette balise dans un fichier nommé `cert.crt`
* <tls-auth> : Sortez le contenu de cette balise dans un fichier nommé `tls.key`

Supprimez ensuite les blocs ``

Il se peut également que les certificats soient stockés en dehors de votre configuration, dans ce cas, vous n'avez rien de plus à faire que de bien repérer les noms des différents fichiers.

    client
    nobind
    dev tun
    remote-cert-tls server
    
    remote <vpn.example.net> 1194 udp
    
    key-direction 1

    redirect-gateway def1


## Génération du certificat .p12

Afin de pouvoir utiliser les certificats dans une configuration à la demande, il faut les convertir dans le format .p12, c'est ce que nous allons faire avec la commande suivante.

Pensez bien à remplacer les `<name>` et `<device>` par vos informations, par exemple `<moi>` et `<iphone>`, ainsi que `vpn.example.net` par le nom d'hôte de votre serveur OpenVPN.

    openssl pkcs12 -export -out ./certificate.p12 \
    -inkey cert.key -in cert.crt \
    -passout pass:p12passphrase -name <name>-<device>@vpn.example.net


## Génération et installation  d'un profile On Demand

Pensez bien à remplacer les `<name>` et `<device>` par vos informations, par exemple `<moi>` et `<iphone>`, ainsi que `vpn.example.net` par le nom d'hôte de votre serveur OpenVPN.

    ovpnmcgen.rb gen -c .ovpnmcgen.rb.yml --ovpnconfigfile config-client.ovpn \
    --security-level paranoid --cafile ./ca.crt --tafile ./tls.key \ 
    --host vpn.example.net --p12file ./certificate.p12 --p12pass p12passphrase \
    <name> <device> -o config-ondemand.mobileconfig

L'installation profile généré est très simple, envoyé le fichier  `config-ondemand.mobileconfig` sur votre iPhone et ouvrez le. Suivez ensuite les instructions à l'écran en acceptant les avertissements et le tour sera joué.