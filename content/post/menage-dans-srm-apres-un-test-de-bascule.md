+++
image = "https://techan.fr/images/2015/01/vmware_vsphere_client_high_def_icon_by_flakshack-d4o96dy.png"
description = ""
title = "Ménage dans SRM après un test de bascule"
date = 2015-02-03T10:17:58Z
author = "MrRaph_"
categories = ["Ménage","ménage dans srm après un test de bascule","SRM","Test Bascule","VMware"]
tags = ["Ménage","ménage dans srm après un test de bascule","SRM","Test Bascule","VMware"]
slug = "menage-dans-srm-apres-un-test-de-bascule"
draft = false

+++


Dans le cadre d’un exercice de Plan de Reprise d’Activité (PCA), nous avons coupé le lien réseau qui liait le site principal et le site secondaire. Les deux site se sont alors retrouvés isolés, la production continue de tourner sur le site principal et le PCA peut être déclenché sur le site secondaire car il ne voit plus son grand frère.  
  
 Nous partons du principe que le stockage a bien été répliqué, que la bascule avec Site Recovery Manager (SRM) a bien fonctionné, que les tests sont terminés et que vous souhaitez revenir à la configuration initiale. Une fois la configuration du retour arrière mise en place, les deux sites se revoient mais pour SRM, la production est toujours sur le site de secours car le FailBack (retour arrière) n’a pas été fait. On ne souhaite pas le faire car il demande l’inversion des flux de synchronisation stockage et NAS comme si la production était réellement passée sur le site de secours.

Voici la marche à suivre pour faire le ménage dans SRM après un test de bascule.

Tout d’abord, retirez tous les Protection Groups de vos Recovery Plans.

[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/02/screenshot.1422870859.png)](https://techan.fr/images/2015/02/screenshot.1422870859.png)

<div style="float: left; margin-right: 10px;"><div class="wp-caption aligncenter" id="attachment_951" style="width: 416px">[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/01/pg_post_bacule.png)](https://techan.fr/images/2015/01/pg_post_bacule.png)Voici à quoi devraient ressembler vos Protection Groups

</div></div><div style="float: left;"><div class="wp-caption aligncenter" id="attachment_953" style="width: 369px">[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/01/rp_post_bacule.png)](https://techan.fr/images/2015/01/rp_post_bacule.png)Et vos Recovery Plan, même s’ils peuvent ne pas être dans cet état car la capture a été prise après la suppression de quelques Protection Groups.

</div></div><div style="clear: both;"></div>Dans cet état là, vous allez devoir supprimer vos Protection Groups ce qui va retirer la protection de VMs qu’ils hébergent. Une fois ceci fait, vous devrez supprimer vos Recovery Plans. Vous devrez ensuite recréer vos Protections Groups comme ils étaient configurés puis protéger vos VMs.

Une fois cette reconfiguration faite, vous devriez avoir un résultat propre comme celui ci-dessous les warnings en moins. J’ai de warnings car les deux VMs ont des Raw Device Mapping qui ne sont pas répliqués.

<div style="float: left; margin-right: 10px;">[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/01/pg_post_menage.png)](https://techan.fr/images/2015/01/pg_post_menage.png)</div><div style="float: left;">[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/01/vm_erreur_post_menage.png)](https://techan.fr/images/2015/01/vm_erreur_post_menage.png)</div><div style="clear: both;">  Ils suffit ensuite de recréer les Recovery Plans et de remettre les priorités sur les VMs comme c’était avant.</div>[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/01/rp_post_menage.png)](https://techan.fr/images/2015/01/rp_post_menage.png)

Et voilà, SRM est reparti dans le bon sens !

Pour les curieux, voici la KB qui m’a donné la solution, vous trouverez son le lien vers la page web dans les annexes en bas de la page.

[![Ménage dans SRM après un test de bascule](https://techan.fr/images/2015/01/kb_srm_vmware.jpg)](https://techan.fr/images/2015/01/kb_srm_vmware.jpg)

Liens :

- [La KB VMware](https://www.vmware.com/support/srm/srm-releasenotes-5-8-0.html)


