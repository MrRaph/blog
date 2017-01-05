+++
tags = ["EMC","Linux","RecoverPoint","SSH"]
image = "https://techan.fr/images/2014/11/Linux.png"
slug = "ajouter-des-clefs-ssh-pour-se-connecter-sur-un-boitier-recoverpoint"
title = "Ajouter des clefs SSH pour se connecter sur un boîtier RecoverPoint"
author = "MrRaph_"
categories = ["EMC","Linux","RecoverPoint","SSH"]
description = ""
draft = false
date = 2014-09-23T09:52:04Z

+++


Voici la marche à suivre pour ajouter des clefs SSH (RSA) sur les RecoverPoint pour des connections SSH sans mot de passe.

Sur le Linux qui doit se connecter, on crée tout d’abord une clef RSA :

[oracle@xxxxx ~]()$ ssh-keygen -t rsa Generating public/private rsa key pair. Enter file in which to save the key (/home/oracle/.ssh/id_rsa): Enter passphrase (empty for no passphrase): Enter same passphrase again: Your identification has been saved in /home/oracle/.ssh/id_rsa. Your public key has been saved in /home/oracle/.ssh/id_rsa.pub. The key fingerprint is: xx:xx:xx:xx:xx:xx:xx:xx:xx:xx:xx:xx:xx:xx:xx:xx oracle@xxxxx.xxx.xx The key's randomart image is: +--[ RSA 2048]----+ | ..o. oB| | o E. .*o| | + ..o o| | = o o | | S o o | | + . | | . + | | . + | | . . | +-----------------+ [oracle@xxxxx ~]()$ cat /home/oracle/.ssh/id_rsa.pub ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAwrDIgjTvXieLj5aE3cM8WowD+/xegrd1345Dsew6UOoVTDOXBBIh2cYYKx0UU4w3K8TvI3dL5fpkYsmKR3ImqjL9udq4z0oo/nG/BAZVlsRnJW6IrYNnqKWT+BQwRogZ0keZ18wX4JpkPR5fCYhg6Xc2Zr14kfSfPFogbWl28kd0h3qqSGmzS3Ny04FZubHyjC6vJtAJKs890TvbkJpbQ2Rimir7HMvi8VPaGY16xfeAFYfjew+pSWQYlWCHt69RCClbAwGlstzaRCTYH76ebv9eCbZqh29DNu3kktce3D2C/xfW6Ik5aqhRQY0q1yvnyLXdrE/sVpbIDKJs5nlIVQ== oracle@xxxxx.xxx.xx [oracle@xxxxx ~]()$

Ensuite, on se connecte sur le RecoverPoint, attention il faut se connecter sur l’IP du cluster et non sur l’adresse IP des boîtiers !

xxxx-recoverp> add_ssh_key name="xxxxx.xxx.xx" key="ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAwrDIgjTvXieLj5aE3cM8WowD+/xegrd1345Dsew6UOoVTDOXBBIh2cYYKx0UU4w3K8TvI3dL5fpkYsmKR3ImqjL9udq4z0oo/nG/BAZVlsRnJW6IrYNnqKWT+BQwRogZ0keZ18wX4JpkPR5fCYhg6Xc2Zr14kfSfPFogbWl28kd0h3qqSGmzS3Ny04FZubHyjC6vJtAJKs890TvbkJpbQ2Rimir7HMvi8VPaGY16xfeAFYfjew+pSWQYlWCHt69RCClbAwGlstzaRCTYH76ebv9eCbZqh29DNu3kktce3D2C/xfW6Ik5aqhRQY0q1yvnyLXdrE/sVpbIDKJs5nlIVQ== oracle@xxxxx.xxx.xx" Are you sure the entire key has been entered correctly? (y/n)y Key added successfully.

On peut ensuite tester depuis le Linux si la connexion fonctionne.

[oracle@xxxxx ~]()$ ssh admin@xxxx-recoverp Last login: Mon Aug 18 12:29:30 2014 from 172.16.13.104 RecoverPoint/SE System: OK Clusters: xxxxa-recoverp: RPAs: 1 warnings Volumes: OK Splitters: OK xxxxb-recoverp: RPAs: 1 warnings Volumes: OK Splitters: 20 warnings WANs: OK Groups: OK Run 'get_system_status' for more info.

 

 

 


