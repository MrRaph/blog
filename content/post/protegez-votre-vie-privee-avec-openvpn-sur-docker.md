+++
description = ""
draft = false
author = "MrRaph_"
categories = ["Linux","Trucs et Astuces","Docker","OpenvVPN","Vie privée"]
image = "https://techan.fr/images/2015/11/docker_plus_openvpn.png"
title = "Protégez votre vie privée avec OpenVPN sur Docker"
date = 2016-05-19T11:01:07Z
tags = ["Linux","Trucs et Astuces","Docker","OpenvVPN","Vie privée"]
slug = "protegez-votre-vie-privee-avec-openvpn-sur-docker"

+++


La lutte pour protéger sa vie privée sur Internet est de plus en plus compliquée car les entreprises intéressées par votre vie sont de plus en plus nombreuses et agressives pour tout savoir sur vous.

De plus le premier mouchard est votre téléphone portable, grâce à lui, énormément d’informations peuvent être collectées à votre insu. Lorsque vous naviguez sur Internet avec votre petit bijoux de technologie, votre opérateur est le premier à savoir les sites que vous visitez, la fréquence à laquelle vous les consultez, etc … Par ailleurs, votre opérateur mobile, comme votre fournisseur d’accès à Internet peut choisir de brider certains services – comme Youtube – afin de préserver la qualité de son réseau.

Sachez que ces deux mécanismes peuvent être évités en utilisant un VPN. Le VPN est un mécanisme qui permet de créer un tunnel entre deux points sur Internet. Dans notre cas, le tunnel serait ouvert entre votre téléphone et la machine qui héberge votre serveur OpenVPN. Toutes vos connexions à Internet passeront ensuite dans ce tunnel et seront, de ce fait, invisibles par votre opérateur.


## Préparation du serveur OpenVPN

Dans ce post, je part du principe que Docker et Docker-Compose sont déjà installés sur votre machine.

### La variable d'environnement

Nous positionnons la variable `OVPN_DATA` qui nous servira à intéragir avec notre container.

`echo 'OVPN_DATA="openvpn_data_1"' >> ~/.bashrc 
source ~/.bashrc`

## Configuration du server OpenVPN

Tout d'abord, nous allons créer un nouveau dossier et un fichier `docker-compose.yml` pour notre serveur OpenVPN.

`mkdir /data/openvpn
cd /data/openvpn
vi docker-compose.yml`

Voici le contenu du fichier `docker-compose.yml`.


<pre><code class="hljs bash">
version: '2'

services:
  vpn:
    image: kylemanna/openvpn
    ports:
      - "1194:1194"
    volumes_from:
      - data
    restart: always
    cap_add:
      - NET_ADMIN
  data:
    image: busybox
    volumes:
      - /etc/openvpn`
</code></pre>

Nous allons maintenant démarrer le container qui va stocker nos données - certificats, configuration d'OpenVPN, ...

`docker-composer start data`

Enfin, nous allons lancer la configuration du serveur OpenVPN.

`docker run --volumes-from $OVPN_DATA --rm kylemanna/openvpn ovpn_genconfig -u udp://vpn.domain.net
docker run --volumes-from $OVPN_DATA --rm -it kylemanna/openvpn ovpn_initpki`

Il ne reste plus qu'à démarrer le serveur !

`docker-compose up -d`


### Ajouter un utilisateur

Pour ajouter un utilisateur dans le serveur OpenVPN, il suffit de lancer la commande suivante.

`docker run --volumes-from $OVPN_DATA --rm -it kylemanna/openvpn easyrsa build-client-full CLIENTNAME nopass`

Et pour récupérer la configuration générée pour cet utilisateur, on lance la commande :

`docker run --volumes-from $OVPN_DATA --rm -it kylemanna/openvpn easyrsa build-client-full CLIENTNAME nopass`

L'utilisateur `raphael` peut maintenant se connecter en utilisant sa toute nouvelle configuration !
