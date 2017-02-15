+++
draft = false
title = "Installer un serveur OpenVPN sur Ubuntu 15.04"
date = 2015-05-17T09:35:24Z
tags = ["installer un serveur openvpn sur ubuntu 15 04","OpenVPn","Trucs et Astuces","Ubuntu"]
description = ""
slug = "installer-un-serveur-openvpn-sur-ubuntu-15-04"
author = "MrRaph_"
categories = ["installer un serveur openvpn sur ubuntu 15 04","OpenVPn","Trucs et Astuces","Ubuntu"]
image = "https://techan.fr/images/2015/05/openvpntech_logo1.png"

+++


Parmi les solutions de VPN que l’on peut mettre en place sur Linux, OpenVPN est ma préférée, c’est de plus – selon moi – la plus sécurisante. Le bon vieux PPTP est certes très facile à mettre en place, mais je sais pas, je me sens mieux protégé derrière une connexion sécurisée par OpenVPN, c’est peut être une vue de l’esprit, et vous qu’en pensez-vous ?

Vous trouverez en tout cas ci-dessous une procédure pour installer un serveur OpenVPN sur Ubuntu 15.04 – la procédure serait quasiment similaire sur les autres Linux.

 


## Création des certificats

OpenVPN utilise des certificats pour sécuriser le tunnel qu’il met en place, il faut donc créer un certificat pour le serveur mais également, un certificat par utilisateur qui va se connecter au VPN. On peut augmenter le niveau de sécurité en demandant aux utilisateur un mot de passe en plus du certificat qui leur a été attribué – je n’ai pas documenté cette partie dans là dans cet article.

#### Le certificat serveur

Première étape, créer le certificat pour le serveur OpenVPN, pour cela, on va tout d’abord installer les paquets nécessaires à OpenVPN et à sa configuration.

root@xxxx:~# apt-get install openvpn easy-rsa Reading package lists... Done Building dependency tree Reading state information... Done openvpn is already the newest version. The following packages were automatically installed and are no longer required: linux-headers-3.16.0-33 linux-headers-3.16.0-33-generic linux-image-3.16.0-33-generic linux-image-extra-3.16.0-33-generic Use 'apt-get autoremove' to remove them. The following extra packages will be installed: libccid libpcsclite1 opensc pcscd Suggested packages: pcmciautils The following NEW packages will be installed: easy-rsa libccid libpcsclite1 opensc pcscd 0 upgraded, 5 newly installed, 0 to remove and 0 not upgraded. Need to get 970 kB of archives. After this operation, 3,402 kB of additional disk space will be used. Do you want to continue? [Y/n]

Maintenant que l’on dispose de tous les outils, nous allons créer le fameux certificat serveur, pour cela préparons « easy-rsa ».

    root@xxxx:~# mkdir /etc/openvpn/easy-rsa/
    root@xxxx:~# cp -r /usr/share/easy-rsa/* /etc/openvpn/easy-rsa/

On édite le fichier contenant les variables utilisées par « easy-rsa », cela va nous faire gagner un temps précieux.

    root@xxxx:~# vi /etc/openvpn/easy-rsa/vars

Remplacer les valeurs suivantes dans le fichier par les informations qui correspondent à votre serveur.

    export KEY_COUNTRY="FRANCE"
    export KEY_PROVINCE="FR"
    export KEY_CITY="Lyon"
    export KEY_ORG="Example Company"
    export KEY_EMAIL="email@example.com"
    export KEY_CN=MyVPN
    export KEY_NAME=MyVPN
    export KEY_OU=MyVPN

On source ensuite ce fichier, puis on construit le certificat « root » et sa clef.

    root@xxxx:/etc/openvpn/easy-rsa# . vars
    root@xxxx:/etc/openvpn/easy-rsa# ./build-ca
    error on line 198 of [/etc/openvpn/easy-rsa/openssl-1.0.0.cnf](http://etc/openvpn/easy-rsa/openssl-1.0.0.cnf) 139708269794976:error:0E065068:configuration file routines:STR_COPY:variable has no value:conf_def.c:618:line 198

Si vous rencontrez cette erreur lors de la génération du certificat, éditez de nouveau le fichier « vars ».

    root@xxxx:/etc/openvpn/easy-rsa# vi vars

Ajoutez la ligne suivante à la fin du fichier et relancer la génération du certificat, cela devrait fonctionner.

    export KEY_ALTNAMES=$KEY_EMAIL

On peut désormais générer le certificat.

    root@xxxx:/etc/openvpn/easy-rsa# cd /etc/openvpn/easy-rsa/
    root@xxxx:/etc/openvpn/easy-rsa# mkdir -p keys
    root@xxxx:/etc/openvpn/easy-rsa# ./clean-all
    root@xxxx:/etc/openvpn/easy-rsa# source ./vars
    NOTE: If you run ./clean-all, I will be doing a rm -rf on /etc/openvpn/easy-rsa/keys root@xxxx:/etc/openvpn/easy-rsa# ./clean-all root@xxxx:/etc/openvpn/easy-rsa# ./build-ca Generating a 2048 bit RSA private key …………+++ ……………+++ writing new private key to ‘ca.key’ —— You are about to be asked to enter information that will be incorporated into your certificate request. What you are about to enter is what is called a Distinguished Name or a DN. There are quite a few fields but you can leave some blank For some fields there will be a default value, If you enter ‘.’, the field will be left blank. ——
    Country Name (2 letter code) [FRANCE]:FR
    State or Province Name (full name) [FR]:France
    Locality Name (eg, city) [Lyon]:Lyon
    Organization Name (eg, company) [Example Company]:
    Organizational Unit Name (eg, section) [MyVPN]:
    Common Name (eg, your name or your server’s hostname) [MyVPN]:serveur.fr
    Name [EasyRSA]:MyVPN
    Email Address [email@example.com]:

Maintenant que le serveur « root » est créé, on génère le certificat propre au serveur.

root@xxxx:/etc/openvpn/easy-rsa# ./build-key-server serveur.fr Generating a 2048 bit RSA private key ……………………+++ ……………………+++ writing new private key to ‘serveur.fr.key’ —— You are about to be asked to enter information that will be incorporated into your certificate request. What you are about to enter is what is called a Distinguished Name or a DN. There are quite a few fields but you can leave some blank For some fields there will be a default value, If you enter ‘.’, the field will be left blank. —— Country Name (2 letter code) [FRANCE]:FR State or Province Name (full name) [FR]:France Locality Name (eg, city) [Lyon]: Organization Name (eg, company) [Example Company]: Organizational Unit Name (eg, section) [MyVPN]: Common Name (eg, your name or your server’s hostname) [serveur.fr]: Name [EasyRSA]:MyVPN Email Address [email@exmaple.com]: Please enter the following ‘extra’ attributes to be sent with your certificate request A challenge password []: An optional company name []: Using configuration from /etc/openvpn/easy-rsa/openssl-1.0.0.cnf Check that the request matches the signature Signature ok The Subject’s Distinguished Name is as follows countryName :PRINTABLE:’FR’ stateOrProvinceName :PRINTABLE:’France’ localityName :PRINTABLE:’Lyon’ organizationName :PRINTABLE:’Example Company’ organizationalUnitName:PRINTABLE:’MyVPN’ commonName :PRINTABLE:’serveur.fr’ name :PRINTABLE:’MyVPN’ emailAddress :IA5STRING:’email@exmaple.com’ Certificate is to be certified until May 2 09:39:31 2025 GMT (3650 days) Sign the certificate? [y/n]:y 1 out of 1 certificate requests certified, commit? [y/n]y Write out database with 1 new entries Data Base Updated

On génère la clef Diffie-Hellman, c’est un peu long car nous demandons une clef d’une longueur de 2048 bits.

root@xxxx:/etc/openvpn/easy-rsa# ./build-dh Generating DH parameters, 2048 bit long safe prime, generator 2 This is going to take a long time ...+...........................................+............+...........................................................................................................................................................................................................+.+.......................................................................................................................................................................................................................................................................................................................................................................................................................................................+.....................................+...........................+...............................................................................................................................................................................................................................................................................................................................................................................................................................................................+.........+...........+...................................................................+.......................+.......+...............+..........................................................................................................................................................................................................................................................+............................................................................................................................+.+............+.................+....................................................................................................................................................+....................................+........................................................................................................................................................................+......................................................................................................................+........................................................................................................

Copions les clefs générées dans le dossier de configuration d’OpenVPN.

root@xxxx:/etc/openvpn/easy-rsa# cd keys root@xxxx:/etc/openvpn/easy-rsa/keys# cp serveur.fr.crt serveur.fr.key ca.crt dh2048.pem /etc/openvpn/

 

#### Le certificat client

Créons le dernier certificat, celui du client. Dans cet exemple, je vais en créer un pour ma Freebox – qui dispose d’un client OpenVPN intégré.

root@xxxx:/etc/openvpn/easy-rsa/keys# cd /etc/openvpn/easy-rsa/ root@xxxx:/etc/openvpn/easy-rsa# source vars NOTE: If you run ./clean-all, I will be doing a rm -rf on /etc/openvpn/easy-rsa/keys root@xxxx:/etc/openvpn/easy-rsa# ./build-key freebox Generating a 2048 bit RSA private key …………………………………..+++ ………………………………………..+++ writing new private key to ‘freebox.key’ —— You are about to be asked to enter information that will be incorporated into your certificate request. What you are about to enter is what is called a Distinguished Name or a DN. There are quite a few fields but you can leave some blank For some fields there will be a default value, If you enter ‘.’, the field will be left blank. —— Country Name (2 letter code) [FRANCE]:FR State or Province Name (full name) [FR]:France Locality Name (eg, city) [Lyon]: Organization Name (eg, company) [Example Company]: Organizational Unit Name (eg, section) [MyVPN]: Common Name (eg, your name or your server’s hostname) [freebox]: Name [EasyRSA]:MyVPN Email Address [email@exmaple.com]: Please enter the following ‘extra’ attributes to be sent with your certificate request A challenge password []: An optional company name []: Using configuration from /etc/openvpn/easy-rsa/openssl-1.0.0.cnf Check that the request matches the signature Signature ok The Subject’s Distinguished Name is as follows countryName :PRINTABLE:’FR’ stateOrProvinceName :PRINTABLE:’France’ localityName :PRINTABLE:’Lyon’ organizationName :PRINTABLE:’Example Company’ organizationalUnitName:PRINTABLE:’MyVPN’ commonName :PRINTABLE:’freebox’ name :PRINTABLE:’MyVPN’ emailAddress :IA5STRING:’email@exmaple.com’ Certificate is to be certified until May 2 09:59:24 2025 GMT (3650 days) Sign the certificate? [y/n]:y 1 out of 1 certificate requests certified, commit? [y/n]y Write out database with 1 new entries Data Base Updated

 

On crée une petite archive avec tous les fichiers nécessaires au client pour établir la connexion avec notre tout nouveau serveur OpenVPN.

 

root@xxxx:/etc/openvpn/easy-rsa# zip freebox.zip /etc/openvpn/ca.crt /etc/openvpn/easy-rsa/keys/freebox.crt /etc/openvpn/easy-rsa/keys/freebox.key /usr/share/doc/openvpn/examples/sample-config-files/client.conf adding: etc/openvpn/ca.crt (deflated 37%) adding: etc/openvpn/easy-rsa/keys/freebox.crt (deflated 47%) adding: etc/openvpn/easy-rsa/keys/freebox.key (deflated 23%) adding: usr/share/doc/openvpn/examples/sample-config-files/client.conf (deflated 54%)

 


## La configuration d’OpenVPN

Passons au dernier point, la configuration !

#### Configurons le serveur

On copie le fichier e configuration par défaut dans le dossier openvpn.

root@xxxx:/etc/openvpn/easy-rsa# sudo cp /usr/share/doc/openvpn/examples/sample-config-files/server.conf.gz /etc/openvpn/ root@nefarian:/etc/openvpn/easy-rsa# sudo gzip -d /etc/openvpn/server.conf.gz

On édite ce fichier afin de régler quelques options.

root@xxxx:/etc/openvpn/easy-rsa# vi /etc/openvpn/server.conf

Modifier le nom du fichier de clef Difiie-Hellman pour qu’il corresponde à celui qu’on a généré plus haut.

# Diffie hellman parameters. # Generate your own with: # openssl dhparam -out dh1024.pem 1024 # Substitute 2048 for 1024 if you are using # 2048 bit keys. ;dh dh1024.pem dh dh2048.pem

De même pour les fichiers de certificats, vérifiez en fonction des noms qu’ont vos fichiers.

# Any X509 key management system can be used. # OpenVPN can also use a PKCS #12 formatted key file # (see "pkcs12" directive in man page). ca ca.crt ;cert server.crt ;key server.key # This file should be kept secret cert serveur.fr.crt key serveur.fr.key # This file should be kept secret

C’est l’heure de vérité, on redémarre le dament OpenVPN afin qu’il intègre notre nouvelle configuration.

root@xxxx:/etc/openvpn/easy-rsa# service openvpn restart * Stopping virtual private network daemon(s)... * No VPN is running. * Starting virtual private network daemon(s)... * Autostarting VPN 'server'

On peut également vérifier que l’interface « tune » est bien apparue sur le système.

root@xxxx:/etc/openvpn/easy-rsa# ifconfig [...] tun0 Link encap:UNSPEC HWaddr 00-00-00-00-00-00-00-00-00-00-00-00-00-00-00-00 inet addr:10.8.0.1 P-t-P:10.8.0.2 Mask:255.255.255.255 UP POINTOPOINT RUNNING NOARP MULTICAST MTU:1500 Metric:1 RX packets:0 errors:0 dropped:0 overruns:0 frame:0 TX packets:0 errors:0 dropped:0 overruns:0 carrier:0 collisions:0 txqueuelen:100 RX bytes:0 (0.0 B) TX bytes:0 (0.0 B)

 
