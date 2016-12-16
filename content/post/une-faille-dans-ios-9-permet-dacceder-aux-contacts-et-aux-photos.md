+++
slug = "une-faille-dans-ios-9-permet-dacceder-aux-contacts-et-aux-photos"
draft = false
title = "Une faille dans iOS 9 permet d'accéder aux contacts et aux photos"
author = "MrRaph_"
categories = ["contacts","faille","iOS","iOS 9","Photos","Vu sur le Web"]
image = "https://techan.fr/wp-content/uploads/2015/08/ios9_icon_large.png"
tags = ["contacts","faille","iOS","iOS 9","Photos","Vu sur le Web"]
description = ""
date = 2015-09-21T10:15:15Z

+++


Le site [Mac4Ever](http://www.mac4ever.com) révèle ce matin une faille d’iOS 9 qui permet à une personne ayant un accès physique à votre iPhone ou à votre iPad d’accéder à vos contacts et à vos photos – les vidéos ne peuvent être lues. Cet accès est possible même si votre iBidule est protégé par un code ou par TouchID. Une manipulation simple – mais un peu longue et fastidieuse permet au malandrin de voir vos précieuses informations

 

> iOS 9 : une faille donne accès aux contacts et aux photos malgré le verrouillage [http://t.co/ioCzFDWCTS](http://t.co/ioCzFDWCTS) [pic.twitter.com/PesCVKpLtC](http://t.co/PesCVKpLtC)
> 
> — Mac4Ever.com (@Mac4ever) [September 21, 2015](https://twitter.com/Mac4ever/status/645849692941717504)

<script async="" charset="utf-8" src="//platform.twitter.com/widgets.js"></script>

 

La manipulation est la suivante :

- Saisissez 4 codes incorrects pour le déverrouillage
- Saisissez 3 chiffres au hasard à la cinquième tentative, puis maintenez appuyé le bouton « Home » pour activer Siri et entrez sans attendre le 4ème chiffre
- L’iPhone sera bloqué pendant une minute suite aux multiples codes faux, mais Siri restera accessible
- Demandez à Siri quelle heure il est
- Touchez l’icone de l’horloge pour ouvrir l’application idoine
- Touchez le bouton « + » en haut à droite de la fenêtre, puis saisissez un nom de ville qui n’existe pas dans le champ de sélection
- Sélectionnez le nom tout juste saisi et choisissez l’option « Partager »
- Touchez l’icone de l’app Message dans les options de partage
- Saisissez un nom absent de votre répertoire dans le champ du destinataire du message, puis appuyez sur « Retour »
- Touchez deux fois le nom juste saisi pour ouvrir la page d’infos
- Touchez l’option « Créer un nouveau contact »
- Touchez l’option « Ajouter une photo », puis « Choisir une photo »
- Vous avez ainsi accès à la pellicule du smartphone, sans avoir eu besoin de saisir le code d’accès et alors que l’appareil est encore verrouillé

 

**Il est toute fois possible d’empêcher ce comportement non souhaité – et non souhaitable – et désactivant l’utilisation de Siri lorsque le téléphone est verrouillé, via le menu « Touch ID et code » des Paramètres.**

 

[![Une faille dans iOS 9 permet d'accéder aux contacts et aux photos](https://techan.fr/wp-content/uploads/2015/09/ios9_faille_photos_contacts.png)](https://techan.fr/wp-content/uploads/2015/09/ios9_faille_photos_contacts.png)

 


