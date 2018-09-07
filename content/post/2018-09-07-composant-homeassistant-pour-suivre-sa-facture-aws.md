+++
slug = "composant-homeassistant-pour-suivre-sa-facture-aws"
draft = false
featured = ""
date = "2018-09-06T19:18:39"
featuredalt = ""
image = "/images/2018/09/logo_homeassistant.png"
type = "post"
description = ""
title = "Un composant HomeAssistant pour suivre sa facture AWS"
author = "MrRaph_"
featuredpath = ""
linktitle = ""
categories = ["Trucs et Astuces","Domotique","HomeAssistant"]
tags = ["Trucs et Astuces","Domotique","HomeAssistant"]
+++

HomeAssistant est un hub domotique logiciel Open Source. Il permet d'interfacer une très grande quantité d'appareils domotiques entre eux. Il peut également être interfacé avec un Google Home ou une enceinte Echo.

Un des avantages de cette plateforme est son ouverture, il suffit de savoir coder en Python et l'ajout de fonctionnalités supplémentaires devient un jeu d'enfant.

J’ai créé un composant tout bête qui permet de récupérer le montant de se facture AWS. La valeur est la somme depuis le premier jour du mois.

![Facture AWS](/images/2018/09/aws_bill.png)

Le code de ce composant se trouve [ici](https://raw.githubusercontent.com/MrRaph/homeassistant/master/custom_components/sensor/awsbill.py).

Le script Python doit être placé dans l’arborescence `custom_components/sensor` situé au même niveau que le fichier `configuration.yaml`.

Une fois le script en place, il vous faudra ajouter les lignes suivantes dans votre configuration HomeAssistant.

```
sensor:
  - platform: awsbill
    username: !secret accesskey
    password: !secret secretkey
```

Ou `username` est votre ACCESS_KEY AWS et `password` est votre SECRET KEY AWS.
