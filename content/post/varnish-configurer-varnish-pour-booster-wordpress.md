+++
draft = false
author = "MrRaph_"
tags = ["Cache","Linux","Varnish","WordPress"]
description = ""
date = 2014-10-27T09:46:13Z
categories = ["Cache","Linux","Varnish","WordPress"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
slug = "varnish-configurer-varnish-pour-booster-wordpress"
title = "[Varnish] Configurer Varnish pour booster Wordpress"

+++


Varnish est un accélérateur HTTP qui gère du cache, il booste scandaleusement les performances de site Web, mieux que ne le font les traditionnels plugins de cache proposés pour WordPress.

Nous allons voir comment paramètrer la chose pour booster un site tournant sur WordPress.  
  
 Pour cela, il faut déjà installer Varnish :

aptitude install varnish

 

Quelques changements dans l’architecture du serveur Web sont a prévoir, c’est Varnish qui répondra sur le port 80 et Apache lui se contentera du port 8080.

 

Dans Apache, voici le changements a apporter :

1. Changer le **Listen 80 **en **Listen8080**
2. Changer les **VirtualHost *:80 **ou **VirtualHost _default_:80** en **VirtualHost *:8080 ou VirtualHost _default_:8080**.

 

Venons en maintenant à la configuration de Varnish, il y a deux fichier a éditer :

- /etc/varnish/default.vcl
- /etc/default/varnish

 

Dans le fichier « /etc/default/varnish », nous allons dire a Varnish d’écouter sur le port 80, il faut éditer le fichier de sorte à ce que le bloc « DAEMON_OPTS » ressemble à ceci :

DAEMON_OPTS="-a :80 \ -T localhost:6082 \ -f /etc/varnish/default.vcl \ -S /etc/varnish/secret \ -s malloc,256m"

 

Maintenant, dans le fichier « /etc/varnish/default.vcl », nous allons spécifier un « backend », une source à Varnish et des règles pour le cache.

Voici le contenu de ce fichier :

backend default { .host = "127.0.0.1"; .port = "8080"; } acl purge { "localhost"; "192.168.0.0"/24; } sub vcl_recv { if (req.url ~ "preview=true") { return(pass); } # Drop any cookies sent to WordPress. if (!(req.url ~ "wp-(login|admin)")) { unset req.http.cookie; } # allow PURGE from localhost and 192.168.55... if (req.request == "PURGE") { if (!client.ip ~ purge) { error 405 "Not allowed."; } return (lookup); } } sub vcl_fetch { if (req.url ~ "preview=true") { return(hit_for_pass); } # Drop any cookies WordPress tries to send back to the client. if (!(req.url ~ "wp-(login|admin)")) { unset beresp.http.set-cookie; } } sub vcl_hit { if (req.request == "PURGE") { purge; error 200 "Purged."; } } sub vcl_miss { if (req.request == "PURGE") { purge; error 200 "Purged."; } }

On précise ici que Varnish  va écouter sur le port 8080 du localhost, et nous précisons les règles nécessaires à la gestion des cookies de WordPress. Nous permettons également de ne pas « cacher » les articles que nous prévisualisons; ce qui peut être pratique.

 

Une fois que tout ceci est en place, il ne reste qu’a redémarrer Apache puis Varnish et le tour est joué !


