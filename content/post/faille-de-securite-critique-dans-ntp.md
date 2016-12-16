+++
author = "MrRaph_"
categories = ["Faille de sécurité","faille de sécurité critique dans ntp","Linux","NTP","OSX"]
slug = "faille-de-securite-critique-dans-ntp"
title = "Faille de sécurité critique dans NTP"
tags = ["Faille de sécurité","faille de sécurité critique dans ntp","Linux","NTP","OSX"]
image = "https://techan.fr/wp-content/uploads/2014/11/Linux.png"
description = ""
draft = false
date = 2014-12-23T09:42:29Z

+++


Vendredi soir le département américain de la sécurité nationale publiait une faillé critique touchant le protocole open source de synchronisation du temps (NTP: Newtork Time Protocol). Cette faille a été découverte par des ingénieur en sécurité de Google.

### Les systèmes touchés

Cette faille touche tous les systèmes utilisant la version 4 du protocole et ce avant la version 4.2.8  
  
 Cela impacte une grand nombre de systèmes comme Linux, OS X, …

Par exemple, sur un Oracle Linux relativement récent en version 6.5 :

[![Faille de sécurité critique dans NTP](https://techan.fr/wp-content/uploads/2014/12/ntp1.png)](https://techan.fr/wp-content/uploads/2014/12/ntp1.png)

Et sur un RedHat assez ancien en version 3 :

[![Faille de sécurité critique dans NTP](https://techan.fr/wp-content/uploads/2014/12/npt2.png)](https://techan.fr/wp-content/uploads/2014/12/npt2.png)

Cette faille est suffisamment inquiétante pour qu’Apple propose cette nuit une mise à jour de sécurité spécifique à cette faille alors qu’habituellement elle inclut ces corrections dans de plus gros patchs. Apple utilise également son canal d’installation automatique. Une grande première alors que ce moyen existe depuis plus de deux ans, mais n’avait encore jamais été utilisé par la firme de Cuppertino.

 

### Impacte de la faille de sécurité critique dans NTP

Cette faille permet de lancer du code sur le système à travers NTP, avec le privilèges de l’utilisateur qui fait tourner NTP. Elle est caractérisée comme facilement utilisable par le département de la sécurité nationale américain.

> #### DIFFICULTY
> 
> An attacker with a low skill would be able to exploit these vulnerabilities.

### Corriger la faille de sécurité critique dans NTP

Pour les systèmes Apple, il faut installer la mise à jour qui est dors et déjà disponible dans l’App Store.

Pour les systèmes Linux, une mise à jour est disponible dans les dépôts ce matin, un exemple avec Ubuntu :

[![Faille de sécurité critique dans NTP](https://techan.fr/wp-content/uploads/2014/12/ntp3.png)](https://techan.fr/wp-content/uploads/2014/12/ntp3.png)

Des mises à jour ont également été publiées pour les systèmes basés sur les RPM, comme RedHat, CentOS et Oracle Linux.

### Sources

[L’article sur le site de la sécurité nationale américaine](https://ics-cert.us-cert.gov/advisories/ICSA-14-353-01)

[Sur MacGénération](http://www.macg.co/os-x/2014/12/apple-envoie-sa-premiere-mise-jour-de-securite-automatique-86401)


