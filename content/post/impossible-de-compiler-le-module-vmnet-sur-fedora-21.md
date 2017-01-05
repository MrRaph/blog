+++
categories = ["Fedora 11","impossible de compiler le module vmnet sur fedora 11","vmnet","VMware","Workstation"]
image = "https://techan.fr/images/2015/04/vmware_workstation_logo.jpg"
description = ""
draft = false
title = "Impossible de compiler le module vmnet sur Fedora 21"
author = "MrRaph_"
tags = ["Fedora 11","impossible de compiler le module vmnet sur fedora 11","vmnet","VMware","Workstation"]
slug = "impossible-de-compiler-le-module-vmnet-sur-fedora-21"
date = 2015-04-03T11:02:35Z

+++


Je tentais d’installer [VMware Workstation ](http://www.vmware.com/products/workstation/workstation-evaluation)11 sur mon PC personnel sous Fedora 21 et malheureusement, ce système n’étant pas supporté par VMware, il m’étais impossible de compiler les modules noyau de VMware.

Après quelques recherches sur le net, je suis tombé sur un fil sur le site [ask.fedoraproject.org ](https://ask.fedoraproject.org/en/question/65849/vmware-workstation-11-fails-to-build-vmnet-on-fedora-21/ "ask.fedoraproject.org")et en quelques commandes, tout s’est résolu !


##  Les commandes

[$](https://ask.fedoraproject.org/en/question/65849/vmware-workstation-11-fails-to-build-vmnet-on-fedora-21/ "ask.fedoraproject.org") curl http://pastie.org/pastes/9934018/download -o /tmp/vmnet-3.19.patch $ cd /usr/lib/vmware/modules/source # tar -xf vmnet.tar # patch -p0 -i /tmp/vmnet-3.19.patch # tar -cf vmnet.tar vmnet-only # rm -r *-only # vmware-modconfig --console --install-all

Si tout se passe bien, le daemon vmware va démarrer sans souci.

Starting vmware (via systemctl): [ OK ]

Et voilà ! VMware Workstation 11 est prêt !


