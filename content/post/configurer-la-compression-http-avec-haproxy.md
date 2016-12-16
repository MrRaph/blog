+++
slug = "configurer-la-compression-http-avec-haproxy"
draft = false
title = "Configurer la compression HTTP avec HAProxy"
date = 2016-05-27T13:51:30Z
categories = ["Trucs et Astuces","HAProxy"]
description = ""
author = "MrRaph_"
tags = ["Trucs et Astuces","HAProxy"]
image = "/images/2016/05/image-1.png"

+++



[HAProxy])http://www.haproxy.org/#desc) est un outil open source gratuit et très performant qui offre des fonctionnalités de proxy mais surtout de Haute Disponibilité et d'Équilibrage de Charge. Il supporte les applications utilisant le protocole HTTP - sites web - mais également toute application utilisant le protocole TCP.

Je l'utilise personnellement pour faut de la terminaison SSL sur mes sites. [HAProxy])http://www.haproxy.org/#desc) me permet également d'équilibrer la charge entre chacun des containers Docker composant mes sites.

[HAProxy])http://www.haproxy.org/#desc) permet également de décharger les serveurs web de vos applications de certaines des tâches qui leur sont habituellement dévolues. Nous allons voir ici comment configurer [HAProxy])http://www.haproxy.org/#desc) pour qu'il prenne en charge la compression de flux HTTP.


# Compression

La compression permet de réduire la quantité de données qui transitent sur internet entre le serveur et le navigateur du visiteur. Le navigateur du visiteur devra décompresser les différents éléments après réception. C'est une méthode très pratique pour réduire le temps de chargement d'une page web, d'autant plus qu'une grande majorité des éléments constitutifs d'un site internet se compressent très bien comme les feuille de style - CSS -,  les fichiers JavaScript ou encore le code HTML.

HAProxy permet la mise en place de la compression très simplement, au moyen des deux lignes ci-dessous.


    compression algo gzip
    compression type text/html text/plain text/css text/javascript

La première ligne indique quel algorithme de compression HAProxy doit utiliser et la seconde quand à elle lui spécifié quels type de contenus il va devoir compresser.

On active la compression dans HAProxy en ajoutant ces deux lignes soit dans la partie `defaults` du fichier de configuration - dans ce cas, la compression sera activée pour tous les `backend` définis. On peut également l'activer `backend` par `backend` en ajoutant ces lignes dans leur bloc spécifique.



##Exemple de configuration générale


    defaults
      log global
      mode http
      option forwardfor
      option http-server-close
      option httplog
      option log-health-checks
      option dontlognull
      maxconn  2000
      timeout connect 180000
      timeout client 180000
      timeout server 180000
      compression algo gzip
      compression type text/html text/plain text/css text/javascript


##Exemple de configuration d'un backend spécifique



    backend sondage_backends
      mode http
      option forwardfor
      balance source
      cookie SRV insert indirect nocache
      server sondage_app_1 framadate_app_1.frontend:80 check
      option httpchk GET /
      http-check expect status 200
      compression algo gzip
      compression type text/html text/plain text/css text/javascript


Testons maintenant l'efficacité de cette compression sur un fichier JavaScript.

![Téléchargement sans compression](/content/images/2016/05/telechargement_sans_compression.png)

Sans compression, le client télécharge 111 Ko.

![Téléchargement sans compression](/content/images/2016/05/telechargement_avec_compression.png)

Avec la compression, le client ne télécharge plus que 43 Ko !


## Source
* [Doc. HAProxy](http://blog.haproxy.com/2012/10/26/haproxy-and-gzip-compression/)
