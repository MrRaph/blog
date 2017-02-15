+++
description = ""
draft = false
date = 2014-12-24T12:55:14Z
author = "MrRaph_"
image = "https://techan.fr/images/2014/11/Linux.png"
slug = "telecharger-les-pieces-jointes-aux-mails-dans-un-dossier"
title = "Télécharger les pièces jointes aux mails dans un dossier"
categories = ["Attachments","Bidouilles","Download","Imap","Linux","télécharger les pièces jointes aux mails dans un dossier"]
tags = ["Attachments","Bidouilles","Download","Imap","Linux","télécharger les pièces jointes aux mails dans un dossier"]

+++


Voici un petit script en PHP, permettant de télécharger les pièces jointes aux mails dans un dossier. Ce script se base sur les classes écrites par « hakre » sur lesquelles vous trouverez plus d’informations [sur GitHub](http://stackoverflow.com/questions/9974334/how-to-download-mails-attachment-to-a-specific-folder-using-imap-and-php). J’utilise cela pour télécharger notamment les factures que je reçoit par mail et les copier dans un répertoire de mon [OwnCloud](http://owncloud.org/).

### Le code

    <?php
    require('./imap-attachment.php');
    $savedir = '/chemin/vers/le/dossier/de/sauvegarde/des/pieces/jointes';
    $hostname='{imap.exemple.fr:143/novalidate-cert}INBOX';
    $username='user@exemple.fr';
    $password='password';
    $inbox = new IMAPMailbox($hostname, $username, $password);
    $emails = $inbox->search('ALL');
    if ($emails) {
      rsort($emails);
      foreach ($emails as $email) {
        foreach ($email->getAttachments() as $attachment) {
          $savepath = $savedir str_replace('!','',str_replace('/','-',str_replace(' ','_', strtolower($attachment->getFilename())))); file_put_contents($savepath, $attachment);
        }
       }
     }

 

### Le fonctionnement

Ce petit morceau de code se connecte à votre compte email, sélectionne le dossier que vous souhaitez et boucle sur les mails présents. Si un mail a une pièce jointe, il va la télécharger et la sauver dans le dossier que vous avez configuré.

Et si on veut télécharger les pièces jointes aux mails d’un autre dossier de ce compte, il suffit de dupliquer ce bloc en changeant les paramètres ! Simple non ? :-)

Et vous pouvez même « crontabiser » ce script pour que tout se fasse tout seul !

###  [EDIT 5 Janvier 2015]

Nouvelle version du code plus intelligente, maintenant, on marque les messages dont les pièces jointes ont été téléchargées et on ne cherche dans les dossiers IMAP que les messages non marqués cela permet de gagner du temps. De plus, un id unique est ajouté avant chaque nom de fichier pour être sûr de ne pas avoir de soucis en cas de fichier portant le même nom.

 

    <?php
    require('./imap-attachment.php');
    $savedir = '/chemin/vers/le/dossier/de/sauvegarde/des/pieces/jointes';
    $hostname='{imap.exemple.fr:143/novalidate-cert}INBOX';
    $username='user@exemple.fr';
    $password='password';
    $inbox = new IMAPMailbox($hostname, $username, $password);
    try {
       $emails = $inbox->search('UNKEYWORD "$pjcopiee"');
       if ($emails) {
          rsort($emails);
          foreach ($emails as $email) {
             foreach ($email->getAttachments() as $attachment) {
                $savepath = $savedir . uniqid() . str_replace('=','', str_replace('?', '', str_replace('!','',str_replace('/','-',str_replace(' ','_', strtolower($attachment->getFilename())))))); file_put_contents($savepath, $attachment); $status = imap_setflag_full($inbox->getStream(), $email->getNumber(), "\$pjcopiee");
              }
           }
       }
    } catch (Exception $e) { echo ' Pas de messages a traiter'; }
    imap_close($inbox->getStream()); ?>

 

 

### Sources

[Télécharger les classes IMAP (Clic droit -> Enrgistrer la cible sous)](https://techan.fr/downloads/imap-attachment.php.download)
