+++
author = "MrRaph_"
description = ""
slug = "administration-de-postfix"
draft = true
title = "Administration de Postfix"
date = 2015-12-17T14:56:33Z

+++


 

postqueue -p

 

postsuper -d ALL

 

mailq | tail +2 | grep -v ‘^ *(‘ | awk  ‘BEGIN { RS = «  » } { if ($8 == « root@localhost.localdomain » && $9 == «  ») print $1 } ‘ | tr -d ‘*!’

 

 


## Sources

[www.tech-g.com (Anglais)](http://www.tech-g.com/2012/07/15/inspecting-postfixs-email-queue/)

 

 


