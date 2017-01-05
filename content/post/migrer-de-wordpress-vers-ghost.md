+++
categories = ["ghost","WordPress","Trucs et Astuces"]
tags = ["ghost","WordPress","Trucs et Astuces"]
image = "/images/2016/05/image-2.jpeg"
draft = false
title = "Migrer de WordPress vers Ghost"
author = "MrRaph_"
description = "Je vais expliquer ici la marche suivre pour migrer un blog utilisant WordPress dans Ghost."
slug = "migrer-de-wordpress-vers-ghost"
date = 2016-05-28T15:06:03Z

+++

[Ghost](https://ghost.org/fr/) est un CMS Open Source relativement nouveau sur le marché - comparé aux poids lourds comme WordPress ou Joomla! - la première release de [Ghost](https://ghost.org/fr/) a été rendue disponible sur GitHub le 27 Septembre 2013.

Je vais expliquer ici la marche suivre pour migrer un blog utilisant WordPress dans [Ghost](https://ghost.org/fr/).


# A propos de Ghost


Sous le capot, [Ghost](https://ghost.org/fr/) utilise [Node.js](https://nodejs.org/en/). Par défaut ce CMS utilise une base de donnés SQLite mais il est possible d'utiliser un autre moteur comme MySQL. [Ghost](https://ghost.org/fr/) embarque de base tous les outils dont vous aurez besoin pour gérer votre SEO.

Vous êtes convaincus et vous voulez utiliser [Ghost](https://ghost.org/fr/) ? Deux options s'offrent à vous. Vous pouvez héberger votre propre instance de [Ghost](https://ghost.org/fr/) ou prendre le parti du vous faire héberger par [Ghost](https://ghost.org/fr/) eux même - à partir de 19$ par mois tout de même.

# La configuration cible

Une fois la migration effectuée, voici ce que nous aurons : 
- Ghost
- Serveur Nginx

Le serveur Nginx servira les images importées de WordPress.


# La migration en elle même

Pour exporter les articles contenus dans WordPress, il faut installer et activer le plugin [Ghost](https://wordpress.org/plugins/ghost/) dans WordPress.


## 1. Exporter le contenu de WordPress

Dans la page d'administration des plugins pour désactiver tous les autres plugins actifs, ils pourraient ajouter du code dans l'export ce qui pourrait perturber Ghost par la suite.

Rendez vous ensuite dans le menu "Outils" et cliquez sur l'entrée "Export to Ghost". Descendez en bas de la page et téléchargez l'archive.

![Export to Ghost](/content/images/2016/05/image.jpeg)


## 2. Importer dans Ghost

Rendez vous maintenant dans la page d'administration de Ghost - http://votre.ghost/ghost/. Choisissez le menu "Labs", et uploadez l'export réalisé précédemment.

![Menu Labs de l'administration de Ghost](/content/images/2016/05/image-1.jpeg)

L'import peut durer un certain temps, soyez patient ! Il est également probable que vous soyez déconnecté de Ghost pendant le processus.


## 3. Les à-côté fastidieux

Il reste maintenant à migrer les images existantes dans WordPress. Ces dernières sont stockées dans le dossier `/dossier/de/wordpress/images`. Copiez ce dossier à côté de votre installation de Ghost - dans cet exemple, je vais utiliser le dossier `/data/ghost/images_wordpress`.

Maintenant que nous avons tout ce qu'il faut dans Ghost et que les images sont disponibles, il ne reste plus qu'à configurer Nginx pour qu'il serve les images et qu'il proxyfie Ghost.

Voici le fichier de configuration à ajouter dans Nginx pour proxyfier Ghost.

    server {
        listen 0.0.0.0:80;
        server_name *your-domain-name*;
        access_log /var/log/nginx/*your-domain-name*.log;
    
        location / {
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header HOST $http_host;
            proxy_set_header X-NginX-Proxy true;
    
            proxy_pass http://127.0.0.1:2368;
            proxy_redirect off;
        }
        
        location /wp-content {
            alias /data/ghost/images_wordpress ;
        }
    }

Ce ficher devra être créé dans le dossier /etc/nginx/sites-available, dans cet exemple, je l'appellerai ˋghost.conf`.

Il ne reste qu'à activer cette configuration et à redémarrer Nginx.

`ln -s /etc/nginx/sites-available/ghost.conf /etc/nginx/sites-enabled/ghost.conf`

ˋservice nginx restart`
 

# Sources

- [Nginx et Ghost (digitalocean)(Anglais)](https://www.digitalocean.com/community/tutorials/how-to-host-ghost-with-nginx-on-digitalocean)