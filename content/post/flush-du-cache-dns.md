+++
description = ""
slug = "flush-du-cache-dns"
draft = false
title = "Flush du cache DNS"
date = 2014-09-23T08:25:32Z
author = "MrRaph_"
categories = ["Cache","DNS","Linux","Mac","Windows"]
tags = ["Cache","DNS","Linux","Mac","Windows"]

+++



## Sur Linux

Il suffit de relancer le daemon nscd.

/etc/rc.d/init.d/nscd restart

 


## Sur Mac OS

Ouvrez Terminal.app, puis tapez la commande suivante en fonction de votre système.

dscacheutil -flushcache

lookupd -flushcache

 


## Sur Windows

Ouvrez une invite de commande en faisant : Windows + R, puis tapez « cmd » dans la pop-up qui s’ouvre ensuite, utilisez la commande suivante :

ipconfig /flushdns


