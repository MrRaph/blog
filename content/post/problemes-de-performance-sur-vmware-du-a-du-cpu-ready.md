+++
date = 2015-11-17T12:23:02Z
categories = ["CPU Ready","Performances","problemes de performance sur vmware du a du cpu ready","TroubleShooting","VMware","vSphere"]
tags = ["CPU Ready","Performances","problemes de performance sur vmware du a du cpu ready","TroubleShooting","VMware","vSphere"]
draft = false
title = "Problèmes de performance sur VMWare du à du CPU Ready"
author = "MrRaph_"
image = "https://techan.fr/images/2015/01/vmware_vsphere_client_high_def_icon_by_flakshack-d4o96dy.png"
description = ""
slug = "problemes-de-performance-sur-vmware-du-a-du-cpu-ready"

+++


Voici une constatation que j’ai faite sur un parc VMware. Depuis plusieurs semaines, les utilisateurs se plaignaient de performances – très – dégradées. Des investigations ont été réalisées au niveau applicatif et il n’en ai pas ressorti pas grand chose … Pas de nouvelles applications, pas de grand chamboulement … Rien qui pourrait impliquer une telle surcharge …

Je me suis penché sur les graphes VMware, et ce que j’ai vu n’était pas glop. Voici le graphe d’activité CPU de la VM qui héberge l’Apache qui gère l’authentification des utilisateurs sur les applications et l’accès de ces utilisateurs aux-dites application. On voit tout de suite l’heure à laquelle les gens ont ressenti des problèmes de performances, plus ou moins à partir de 15h lorsque le « Ready » est monté en flèche.  
 On constatait ce même phénomène sur plusieurs autres VMs centrales dans l’architecture applicative.

 


## Manifestations du problème de performances

Dans l’image ci-dessous, on voit tout à fait que la VM passe son temps a attendre que l’hyperviseur lui donne accès au CPU de l’hôte physique. Son utilisation de CPU est bridée par cette attente.

[![Problèmes de performance sur VMWare du à du CPU Ready](https://techan.fr/images/2015/11/http_graphe_CPU.png)](https://techan.fr/images/2015/11/http_graphe_CPU.png)

Maintenant, voici comment est composé le parc VMware en Production :

- 2 ESXi Dell R720 (2 Xeon à 8 cœurs soit 16 cœurs sur chaque)
- 2 ESXi Dell R710 (2 Xeon à 6 cœurs soit 12 cœurs sur chaque)

La cible finale est un cluster de 3 R720.

[![Problèmes de performance sur VMWare du à du CPU Ready](https://techan.fr/images/2015/11/cluster_CPU.png)](https://techan.fr/images/2015/11/cluster_CPU.png)

On constate que les hôtes ne sont pas surchargés au niveau CPU, d’autre part, DRS ne donne aucun conseil pour améliorer les performances.

 


## Le CPU Ready dans VMware

 

Je crois qu’il est temps maintenant d’expliciter un tantinet ce qu’est le CPU Ready dans VMware. Lorsque qu’une, dotée par exemple de 4 vCPU, fait un appel CPU à l’hyperviseur, ce dernier lui réserve 4 coeurs sur l’hôte et ce même si l’appel de la VM de demandait qu’un seul coeur. Les machines physiques présentent dans le cluster cité en exemple ont au mieux 16 – au pire 12 – coeurs physiques. Donc notre VM avec 4 vCPU doit attendre qu’un quart des coerus de la machine soient libres pour pouvoir exécuter ses instructions. Imaginez maintenant une VM qui aurait 8 vCPU, car il y en avait également dans cette infrastructure …

<span style="text-decoration: underline;">**Note :**</span> Il est conseillé de ne mettre qu’un ou deux vCPU par VM pour éviter ce phénomène, sauf cas très spécifique.

Voici ce que disent les Best Practices de VMware – voire le lien dans les sources page 19-20.

> Configuring a virtual machine with more virtual CPUs (vCPUs) than its workload can use might cause slightly increased resource usage, potentially impacting performance on very heavily loaded systems. Common examples of this include a single-threaded workload running in a multiple-vCPU virtual machine or a multi-threaded workload in a virtual machine with more vCPUs than the workload can effectively use.
> 
> Even if the guest operating system doesn’t use some of its vCPUs, configuring virtual machines with those vCPUs still imposes some small resource requirements on ESXi that translate to real CPU consumption on the host. For example:
> 
> Unused vCPUs still consume timer interrupts in some guest operating systems. (Though this is not true with “tickless timer” kernels, described in “Guest Operating System CPU Considerations” on page 39.)
> 
> Maintaining a consistent memory view among multiple vCPUs can consume additional resources, both in the guest operating system and in ESXi. (Though hardware-assisted MMU virtualization significantly reduces this cost.)
> 
> Most guest operating systems execute an idle loop during periods of inactivity. Within this loop, most of these guest operating systems halt by executing the HLT or MWAIT instructions. Some older guest operating systems (including Windows 2000 (with certain HALs), Solaris 8 and 9, and MS-DOS), however, use busy-waiting within their idle loops. This results in the consumption of resources that might otherwise be available for other uses (other virtual machines, the VMkernel, and so on).
> 
> ESXi automatically detects these loops and de-schedules the idle vCPU. Though this reduces the CPU > overhead, it can also reduce the performance of some I/O-heavy workloads. For additional information see VMware KB articles 1077 and 2231.
> 
> The guest operating system’s scheduler might migrate a single-threaded workload amongst multiple vCPUs, thereby losing cache locality.
> 
> These resource requirements translate to real CPU consumption on the host.

J’ai trouvé un script PowerSHELL utilisant PowerCLI – vous trouverez un lien dans les Sources – qui calcule l’OverCommitment en terme de CPU, voici le résultats lors de mes constatations.

[![Problèmes de performance sur VMWare du à du CPU Ready](https://techan.fr/images/2015/11/cpu_overcommit.png)](https://techan.fr/images/2015/11/cpu_overcommit.png)

La majorité des VMs « à problèmes » qui se trouvent être les plus critiques évidement se trouvaient sur l’hôte 1. La majorité des VMs dans le cluster PROD ont 4 vCPU, certaines en avaient même 8.

Fort de ces constations, j’ai donc testé de déplacer l’une des VMs qui rencontrait des problème de performance sur l’hôte 5 qui est bien moins chargé. Le résultat a été sans appel, et les utilisateurs se sont moins plaints …

[![Problèmes de performance sur VMWare du à du CPU Ready](https://techan.fr/images/2015/11/dcts_graphe_CPU.png)](https://techan.fr/images/2015/11/dcts_graphe_CPU.png)

On a donc entrepris de réduire le nombre de vCPU alloués en baissant le nombre de vCPU sur les VMs, on a ainsi gagné 35 vCPU en passant des VMs de 4 à 2 ou de 8 à 2.

[![Problèmes de performance sur VMWare du à du CPU Ready](https://techan.fr/images/2015/11/cpu_overcommit_2.png)](https://techan.fr/images/2015/11/cpu_overcommit_2.png)

J’ai également déplacé la VM http – dont on a vu le graphe tout au début – sur un hôte moins chargé, l’ESXi 5. J’ai fait le déplacement aux alentours de 11h ce jour là, voici le résultat :

[![Problèmes de performance sur VMWare du à du CPU Ready](https://techan.fr/images/2015/11/http_graphe_CPU_2.png)](https://techan.fr/images/2015/11/http_graphe_CPU_2.png)

Après cette action, l’équipe du support informatique n’a reçu aucun appel d’utilisateur rencontrant des problèmes de performances, alors qu’habituellement la pire période de la journée commence vers 15h.

 


## Sources

- [Dépot GitHub contenant les script PowerCLI](https://github.com/MathieuBuisson/Powershell-VMware.git)
- [Performance Best Practices for VMware vSphere™ 5.0](http://www.vmware.com/pdf/Perf_Best_Practices_vSphere5.0.pdf)


