+++
slug = "google-refuse-les-mails-venant-de-postfix"
title = "Google refuse les mails venant de Postfix"
author = "MrRaph_"
categories = ["Google","google refuse les mails venant de postfix","Linux","mail","Postfix","Trucs et Astuces"]
tags = ["Google","google refuse les mails venant de postfix","Linux","mail","Postfix","Trucs et Astuces"]
image = "https://techan.fr/images/2014/11/Linux.png"
description = ""
draft = false
date = 2014-12-10T11:57:16Z

+++


Voici comme résoudre le problème qui fait que Google refuse les mails venant de Postfix.

#### Résumé du problème

Régulièrement, GMail refusait les mails que j’envoyai depuis mon serveur personnel, qui héberge Postfix et Dovecot. La raison avancée par Google est que ce mail ressemblait fortement à du spam et qu’il préférait le bloquer. Le mail n’arrivait donc même pas dans la boite Spam du destinataire, il était bloqué purement et simplement.  
  
  

Un premier workaround que j’ai trouvé était de renvoyer le mail, il passait la seconde fois en règle générale, mais cette solution m’a vite fatiguée … J’ai donc fouillé et trouvé une solution, désactiver l’IPv6. Ne me demandez pas pourquoi, mais visiblement Google n’aime pas ça … En effet, dès que j’ai cela, tous les mails se sont mis a passer directement.

Voici le type de réponse que m’envoyait le mailer de Google :

Reporting-MTA: dns; mail X-Postfix-Queue-ID: 9BB04521B3 X-Postfix-Sender: rfc822; xxxxx.xxxxx@xxxxx.fr Arrival-Date: Sat, 27 Sep 2014 08:32:30 +0200 (CEST) Final-Recipient: rfc822; xxxxx@gmail.com Original-Recipient: rfc822;xxxxx@gmail.com Action: failed Status: 5.7.1 Remote-MTA: dns; gmail-smtp-in.l.google.com Diagnostic-Code: smtp; 550-5.7.1 [2001:41d0:8:1e3e::1 12] Our system has detected that this 550-5.7.1 message is likely unsolicited mail. To reduce the amount of spam sent 550-5.7.1 to Gmail, this message has been blocked. Please visit 550-5.7.1 http://support.google.com/mail/bin/answer.py?hl=en&answer=188131 for 550 5.7.1 more information. ph6si9172275wjb.176 - gsmtp

 

#### Résolution

Pour désactiver l’IPv6, voici les commandes a lancer :

sysctl -w net.ipv6.conf.default.disable_ipv6=1 sysctl -w net.ipv6.conf.all.disable_ipv6=1

 

Ces options sont prises à chaud, mais ne sont pas persistantes à un reboot du serveur. Pour les rendre persistantes, il faut ajouter les lignes suivantes dans le fichier « /etc/sysctl.conf ».

net.ipv6.conf.default.disable_ipv6=1 net.ipv6.conf.all.disable_ipv6=1

 


