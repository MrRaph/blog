+++
slug = "le-vpn-on-demand-ios-votre-préservatif-numérique"
draft = true
featured = ""
date = "2017-11-26T12:18:39"
featuredalt = ""
image = "/images/2017/01/drafts-ios.jpeg"
type = "post"
description = ""
title = "Le VPN On-Demand iOS, votre préservatif numérique"
author = "MrRaph_"
featuredpath = ""
linktitle = ""
categories = ["Trucs et Astuces","iOS"]
tags = ["Trucs et Astuces","iOS"]
+++


La vie numérique est un peu comme la vraie vie, mieux vaut sortir couvert.


## Pré-requis

Il y a quelques prérequis avant de se lancer dans le VPN à la demande. 

Dans un premier temps, il faut un serveur OpenVPN fonctionnel. Ceci ne sera pas couvert dans cet article, mais son installation est assez simple avec Docker (voir [Protégez votre vie privée avec OpenVPN sur Docker](https://techan.fr/protegez-votre-vie-privee-avec-openvpn-sur-docker.html))

Il vous faudra une configuration cliente pour vous connecter à ce serveur OpenVPN, dans la suite de cet article, cette configuration sera nommée `config-client.ovpn`. 

Il faudra que Ruby soit installé sur le poste que vous utiliserez pour la suite de ce guide et que la gem `ovpnmcgen.rb` soit installée. Pour installer cette gem, il suffit d'utiliser la commande suivante :

    gem install ovpnmcgen.rb


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

    openssl pkcs12 -export -out ./certificate.p12 \
    -inkey cert.key -in cert.crt \
    -passout pass:p12passphrase -name <name>-<device>@vpn.example.net


## Génération d'un profile On Demand

    ovpnmcgen.rb gen -c .ovpnmcgen.rb.yml --ovpnconfigfile config-client.ovpn --security-level paranoid --cafile ./ca.crt --tafile ./tls.key --host vpn.example.net --p12file ./certificate.p12 --p12pass p12passphrase <name> <device> -o config-ondemand.mobileconfig