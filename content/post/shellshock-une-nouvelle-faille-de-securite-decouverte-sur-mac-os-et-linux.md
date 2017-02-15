+++
slug = "shellshock-une-nouvelle-faille-de-securite-decouverte-sur-mac-os-et-linux"
draft = false
title = "[Shellshock] Une nouvelle faille de sécurité découverte sur Mac OS et Linux"
date = 2014-09-25T14:56:57Z
author = "MrRaph_"
categories = ["Faille de sécurité","Linux","Mac"]
tags = ["Faille de sécurité","Linux","Mac"]
description = ""

+++


La nouvelle est tombée un peu plus tôt cet après-midi, [une nouvelle faille de sécurité a été découverte par les gens de chez RedHat](http://community.redhat.com/blog/2014/09/critical-bash-security-vulnerability-update-your-systems-today/?utm_source=twitterfeed&utm_medium=twitter) !  

 Cette faille s’appuie sur l’interpréteur de commandes Bash, un énorme classique sur tous les Unix/Linux, si bien que peux de pingouins sont à l’abris … Mac OS est également touché car Bash est son shell de base.

Elle permet a des utilisateurs malveillants d’exécuter du code à distance sur votre machine. Celà vient du fait qu’il est possible de créer des variables d’environnement avec des valeurs spéciales avant d’appeler Bash, comme des commandes pouvant être exécutées.

 

Des mises à jours ont déjà été publiées pour les systèmes suivants :

- RedHat (pour les version de 4 à 7)
- Ubuntu (pour les versions 10.04 LTS, 12.04 LTS et 14.04 LTS)
- Fedora/CentOS ( pour les versions de 5 à 7)
- Debian

Espérons qu’Apple publiera rapidement une mise à jour pour les pommes !

> Sécurité: la mégafaille «Shellshock» secoue le monde Linux et Mac OS. [http://t.co/I8emJBvbQ0](http://t.co/I8emJBvbQ0) [pic.twitter.com/KVhrrR04F3](http://t.co/KVhrrR04F3)
>
> — 01net (@01net) [September 25, 2014](https://twitter.com/01net/status/515096456240574464)

<script async="" charset="utf-8" src="//platform.twitter.com/widgets.js"></script>

Pour tester si votre système est vulnérable, c’est simple, il vous suffit d’exécuter la commande suivante dans votre terminal :

    env x='() { :;}; echo vulnerable' bash -c "echo this is a test"

Si votre système est vulnérable l’affichage sera le suivant :

vulnerable this is a test

S’il ne l’est pas, le résultat sera :

    bash: avertissement : x: ignoring function definition attempt bash: erreur lors de l'import de la définition de fonction pour « x » this is a test

 

**<span style="text-decoration: underline;">Si votre système est vulnérable, n’attendez pas avant de patcher votre Bash !!!</span>**

Pour cela, utiliser votre gestionnaire de paquets habituels.
