+++
categories = ["Apple","AppleScript","envoyer les identifiants teamviewer par mail avec un applescript","envoyer les identifiants teamviewer par mail avec un applscript","OS X","TeamViewer"]
description = ""
slug = "envoyer-les-identifiants-teamviewer-par-mail-avec-un-applescript"
draft = false
title = "Envoyer les identifiants TeamViewer par mail avec un AppleScript"
author = "MrRaph_"
tags = ["Apple","AppleScript","envoyer les identifiants teamviewer par mail avec un applescript","envoyer les identifiants teamviewer par mail avec un applscript","OS X","TeamViewer"]
image = "https://techan.fr/images/2015/04/screenshot.423.jpg"
date = 2015-04-30T15:04:47Z

+++


Comme je suis très tête en l’air j’oublie souvent de lancer – ou de relancer – TeamViewer en partant de chez moi. Et quand j’oublie de le faire et bien je suis triste … J’ai donc mis en place une solution pour envoyer les identifiants TeamViewer par mail avec un AppleScript, cela date déjà de quelques années en arrière mais cela fonctionne toujours comme un charme.

Pour la culture, AppleScript est un langage de programmation très pratique pour customiser son Mac. Il est par ailleurs très simple à adopter !

Je vais donc vous partager mes très chères sources et inaugurer par la même la catégorie « AppleScript ». Qui sera prochainement enrichie d’autre scripts qui me simplifient la vie !

 


## Le script

Voilà la bête ! Remplacez juste votre nom, votre adresse email et un autre chemin pour stocker temporairement la capture d’écran et vous serez prêt !

do shell script ("open /Applications/TeamViewer.app") delay 1.5 set tmpPath to "/Users/raphael/Downloads/tw.png" do shell script "screencapture " & quoted form of tmpPath tell application "Mail" set theMessage to make new outgoing message with properties {visible:true, subject:"[TeamViewer] :: " & (current date) as string, content:""} tell content of theMessage to make new attachment with properties {file name:tmpPath} at after last paragraph tell theMessage to make new to recipient at end of to recipients with properties {name:"Votre Nom", address:"yourmail@domain.com"} send theMessage end tell set myFile to POSIX file tmpPath as alias tell application "Finder" if exists file myFile then delete file myFile end if end tell

 


## Le résultat

On lance le script, et quelques secondes après, ô bonheur, vous recevez la capture d’écran de TeamViewer avec le précieux sésame pour s’y connecter !

 

<div class="wp-caption aligncenter" id="attachment_1303" style="width: 366px">[![Envoyer les identifiants TeamViewer par mail avec un ApplScript](https://techan.fr/images/2015/04/screenshot.4201.jpg)](https://techan.fr/images/2015/04/screenshot.4201.jpg)Et voilà le travail !

</div> 


