+++
title = "Activer l'access.log sur Varnish"
date = 2014-12-22T17:06:14Z
author = "MrRaph_"
categories = ["activer l access log sur varnish","Linux","Trucs et Astuces","Varnish","web"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
description = ""
draft = false
tags = ["activer l access log sur varnish","Linux","Trucs et Astuces","Varnish","web"]
slug = "activer-laccess-log-sur-varnish"

+++


Voici un petit article sur rapide pour expliquer comment activer l’access.log au niveau du moteur de cache Varnish.  
  
 Cela est utile pour avoir des traces de connexion au(x) site(s) que varnish a dans son cache, car comme il les garde en cache justement, les accès son faussés !

La commande a passer pour activer l’access.log sur Varnish:

varnishncsa -a -w /var/log/varnish/access.log -D -P /var/run/varnishncsa.pid

Il ne vous reste plus qu’a monitorer le fichier /var/log/varnish/access.log.


