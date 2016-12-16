+++
categories = ["2015","Bonne année","bonne et heureuse année 2015"]
tags = ["2015","Bonne année","bonne et heureuse année 2015"]
image = "https://techan.fr/wp-content/uploads/2015/01/happy_new_year_by_clwoods.jpg"
description = ""
title = "Bonne et heureuse année 2015 !"
author = "MrRaph_"
slug = "bonne-et-heureuse-annee-2015"
draft = false
date = 2015-01-01T00:00:07Z

+++


Chers lecteurs, cela fait plus de 3 mois que le site a vu le jour et il est déjà temps de vous souhaiter une bonne et heureuse année 2015 !!

Je vous souhaite donc à tous, vous mes lecteurs connus ou anonymes, une année chargée en succès, bonheur, amour et prospérité !

Je vous souhaite également la meilleur santé possible, c’est quelque chose dont on s’aperçoit de la valeur inestimable que lorsqu’on la perd …

 

Pour que cette année soit encore plus geek que la précédente, je vous propose un petit code en Python pour envoyer vos e-cartes de vœux ! A vos claviers ! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

# -*- coding: utf-8 -*- import sys def happyNewYear(prenom): print "" print " . . ," print " o. .o/ |" print " .---. / /|" print " \~~~/'---+ " print " \ / \ " print " | PING! \-." print " | |/" print " /_\ " print "" print " ##### ### # #######" print " # # # # ## #" print " # # # # # # #" print " ##### # # # # #####" print " # # # # # #" print " # # # # # #" print " ####### ### ##### #####" print "==============================================================" print prenom,", je vous souhaite une très belle année 2015 !" print "Qu'elle soit bordée de réussites, parsemée de bonnes nouvelles et" print "délicatement saupoudrée de délicieux moments." print "" print "Laissez reposer 15 minutes et voilà une année à dévorer à pleines dents." print "==============================================================" print "" happyNewYear(sys.argv[1])

 

Et vous pourrez même envoyer vos e-cartes geeks par mail ! Dingue non !?! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

python happy_new_year.py 'Mes lecteurs' | mail -a "Content-Type: text/plain; charset=UTF-8" \ -s 'Bonne année 2015 !' destinataire@mail.fr

 

 


