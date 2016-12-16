+++
description = ""
slug = "securiser-haproxy-avec-lets-encrypt-dans-docker"
draft = false
title = "Sécuriser HAProxy avec Let's Encrypt dans Docker"
date = 2016-08-03T10:23:37Z
author = "MrRaph_"
categories = ["Docker","HAProxy","Trucs et Astuces","Linux","Sécurité","HTTPS"]
tags = ["Docker","HAProxy","Trucs et Astuces","Linux","Sécurité","HTTPS"]

+++

Depuis quelques temps je n'utilise plus que des certificats fournis gracieusement par [Let's Encrypt](https://letsencrypt.org/). Le seul problème était de demander de nouveaux certificats ou d'en renouveler des anciens sans arrêter le HAProxy qui fait la tête de pont de mon infrastructure Docker.

# La solution

La solution que j'ai trouvée en fouillant le net est de passer par un serveur web - NGinx - qui va servir les fameux fichier .well-known et permettre à Let's Encrypt de valider le domaine.

Pour mettre ceci en place, il m'a donc fallut créer un nouveau container NGinx qui va servir le contenu d'un dossier. J'ai du reconfigurer HAProxy pour qu'il redirige toutes les connexions HTTP entrantes qui demandent une URL qui commence par `/.well-know/acme-challenge` vers ce nouveau container. Enfin, il faut demander à Let's Encrypt de passer par cette validation par fichiers sans qu'il démarre son propre serveur web.

# La mise en place

Nous allons voir étape par étape comment mettre en place cette solution.

## Le containter NGinx

Tout d'abord, nous allons créer les dossiers nécessaires à ce fameux container NGinx, voici la commande à utiliser.

    mkdir /data/letsencrypt/www /data/letsencrypt/nginx

Le dossier `www` sera utilisé par Let's Encrypt de le dossier `nginx` stockera la configuration de ce NGinx.

Voici justement la configuration de ce NGinx :

    # cat /data/letsencrypt/nginx/default.conf 
    server {
        listen       8000;
        server_name  letsencrypt.requests;
        root /usr/share/nginx/html;
    }

Enregistrez ce fichier dans le dossier `/data/letsencrypt/` sous le nom `default.conf`.

Maintenant, nous avons tout ce qu'il faut pour créer un nouveau Service avec ce container.

    docker service create --name haproxy_letsecnrypt \
    --restart-condition any \
    --network frontend \
    --replicas 2 \
    --mount type=bind,source=/data/letsencrypt/www,target=/usr/share/nginx/html \
    --mount type=bind,source=/data/letsencrypt/nginx/default.conf,target=/etc/nginx/conf.d/default.conf \
    nginx



## La configuration HAProxy

Il nous faut maintenant modifier la configuration d'HAProxy pour qu'il route les connexions de Let's Encrypt vers ce nouveau Service. Modifiez vos `frontends` pour qu'ils ressemblent ça :

    frontend http
        bind *:80
        mode http
        
    
        acl app_letsencrypt  path_beg   /.well-known/acme-challenge/
        use_backend bk-letsencrypt if app_letsencrypt

        redirect scheme https code 301 if !{ ssl_fc } !app_letsencrypt

    frontend ft_ssl_vip
        bind *:443 ssl crt /haproxy-override/certs/ npn spdy/2 ciphers ECDHE-RSA-AES256-SHA:RC4-SHA:RC4:HIGH:!MD5:!aNULL:!EDH:!AESGCM
    
        rspadd Strict-Transport-Security:\ max-age=15768000

Ajoutez le `backend` suivant à la fin du fichier :

    backend bk-letsencrypt
        http-request set-header Host letsencrypt.requests
        dispatch haproxy_letsecnrypt.frontend:8000

Ce tout bon pour HAProxy, il n'y a plus qu'à le redémarrer !

# Utiliser Let's Encrypt avec ce système

Voici la commande à utiliser pour que Let's Encrypt utilise notre nouveau mécanisme :

    /opt/letsencrypt/letsencrypt-auto certonly --email user@domain.net --webroot -w /data/letsencrypt/www/ -d domain.net

Il ne reste qu'à "mouliner" les certificats pour qu'HAProxy puisse les utiliser - dans ma configuration, les certificats utilisés par HAProxy sont stockés dans le dossier `/data/haproxy/certs` qui est monté dans les containers sous `/haproxy-override/certs/`.

Voici le script que j'utilise pour "mouliner" mes certificats :

    #!/bin/bash
    for domain in $(ls /etc/letsencrypt/live); do 
        cat /etc/letsencrypt/live/$domain/privkey.pem /etc/letsencrypt/live/$domain/fullchain.pem > /data/haproxy/certs/$domain.pem
    done

# Sources
* [gauthierc.github.io](http://gauthierc.github.io/post/letsencrypt-haproxy/)