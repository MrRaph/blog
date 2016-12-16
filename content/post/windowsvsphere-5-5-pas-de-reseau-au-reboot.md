+++
description = ""
slug = "windowsvsphere-5-5-pas-de-reseau-au-reboot"
draft = false
title = "[Windows/vSphere 5.5] Pas de réseau au reboot"
author = "MrRaph_"
categories = ["réseau","TroubleShooting","VMware","vsphere windows 2008","vSphere55","Windows"]
tags = ["réseau","TroubleShooting","VMware","vsphere windows 2008","vSphere55","Windows"]
image = "https://techan.fr/wp-content/uploads/2014/11/server2008r2_vmware.png"
date = 2014-11-20T10:21:22Z

+++


Voici un souci que j’ai rencontré, parfois lorsqu’un Windows 2008 hébergé sur vSphere 5.5 redémarre, il perd son réseau, la VM est donc inaccessible, sauf via la console VMware.

 

La carte réseau a un petite triangle jaune délicieux comme ceci : [![carte_reseau_triangle_jaune](https://techan.fr/wp-content/uploads/2014/11/carte_reseau_triangle_jaune.png)](https://techan.fr/wp-content/uploads/2014/11/carte_reseau_triangle_jaune.png).

Une solution pour résoudre cela rapidement est de désactiver puis réactiver la carte réseau, tout rentre alors dans l’ordre, mais cela ne corrige pas le fond du problème.  
  
  

Une KB de VMware existe à ce sujet : « [False duplicate IP address detected on Microsoft Windows Vista and later virtual machines on ESX/ESXi when using Cisco devices on the environment (1028373)](http://kb.vmware.com/selfservice/microsites/search.do?language=en_US&cmd=displayKC&externalId=1028373)« . D’après les informations qu’elle fournies, ça viendrait d’une option de gestion ARP activée sur les switches CISCO ou d’une mauvaise réponse ARP.

 

Bref, toujours est-il que la manipulation proposée dans cette KB corrige bien ce souci.

 

> #### Resolution
> 
> <div class="doccontent cc_Resolution"><div>**Note**: The information provided in this article is a workaround. Investigate the network configuration at the physical layer for the root cause.To work around this issue, turn off gratuitous ARP in the guest operating system.**Note**: This procedure modifies the Windows registry. Before making any registry modifications, ensure that you have a current and valid backup of the registry and the virtual machine. For more information on backing up and restoring the registry, see the Microsoft article [136393](http://support.microsoft.com/kb/136393).</div><div>*The preceding link was correct as of June 25, 2014. If you find the link is broken, provide feedback and a VMware employee will update the link.*</div><div>To turn off gratuitous ARP in the guest operating system:</div>1. Open the Registry editor. - In Windows XP to Windows Server 2003 – Click **Start **> **Run**, type regedit, and click **OK**.
> - In Windows 7 and Current – Click **Start**, type regedit, and click **OK**.
> 2. Locate this registry key:`HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Services\Tcpip\Parameters`
> 3. Click **Edit** > **New**, and click DWORD Value.
> 4. Type `ArpRetryCount`.
> 5. Right-click the `ArpRetryCount` registry entry and click **Modify**.
> 6. In the Value box, type `0` and click **OK**.
> 7. Exit the Registry Editor.
> 8. Shut down the guest operating system and power off the virtual machine.
> 9. Change the virtual machine back to a network vSwitch with the uplink.
> 10. Power on the virtual machine.
> 
> Alternatively, you can disable gratuitous ARP on the physical switch.
> 
> <div>For example, to disable gratuitous ARP in Cisco IOS, run this command:</div><div>```
> <br></br>
> # no ip gratuitous-arps<br></br>```
> </div>For more information, see the [ArpRetryCount](http://technet.microsoft.com/en-us/library/cc957526.aspx) Microsoft TechNet Article.
> 
> </div>

 


