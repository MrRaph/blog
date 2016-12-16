+++
image = "https://techan.fr/wp-content/uploads/2015/06/powershell-logo.jpg"
description = ""
draft = false
categories = ["monter un vpn automatiquement lorsqu une application est lancee sur windows","PowerShell","Trucs et Astuces","VPN","Windows"]
tags = ["monter un vpn automatiquement lorsqu une application est lancee sur windows","PowerShell","Trucs et Astuces","VPN","Windows"]
slug = "monter-un-vpn-automatiquement-lorsquune-application-est-lancee-sur-windows"
title = "Monter un VPN automatiquement lorsqu'une application est lancée sur Windows"
date = 2015-12-24T10:55:18Z
author = "MrRaph_"

+++


Voici une petite astuce qui permet de faire en sorte que Windows monte une tunnel VPN lorsqu’une application est démarrée. Dans mon cas, pour que je puisse consulter mes emails professionnels, il faut d’abord que je monte le VPN de la société puis que je lance Outlook. PowerShell permet de « masquer » l’étape de connexion au VPN. J’ai donc cherché – et trouvé – comment monter un VPN automatiquement lorsqu’une application est lancée sur Windows, maintenant, lorsque je clique sur l’icône d’Outlook, le VPN se connecte s’il ne l’était pas déjà.

Il suffit d’une seule commande PowerShell pour faire cela !

Tout d’abord, fermez Outlook et déconnectez votre connexion VPN puis ouvrez un terminal PowerShell et identifiez le nom de votre connexion VPN avec la commande suivante.

    PS C:\Users\Raphael> Get-VpnConnection
    Name : MaConnexionVPN
    ServerAddress : vpn.example.com
    AllUserConnection : False
    Guid : {F91D7D95-C168-459D-ABE6-6EA2C856A2E6}
    TunnelType : Automatic
    AuthenticationMethod : {Chap, MsChapv2, Pap}
    EncryptionLevel : Optional
    L2tpIPsecAuth : Certificate
    UseWinlogonCredential : False
    EapConfigXmlStream :
    ConnectionStatus : Connected
    RememberCredential : True
    SplitTunneling : True
    DnsSuffix :
    IdleDisconnectSeconds : 0

 

Dans cet exemple, ma connexion VPN s’appelle « MaConnexionVPN ».

Et voilà, vous n’avez plus qu’a ajouter le trigger à votre Windows avec la commande qui suit.

    PS C:\Users\Raphael> Add-VPNConnectionTriggerApplication -Name "MaConnexionVPN" -ApplicationID "C:\Program Files\Microsoft Office 15\root\office15\OUTLOOK.EXE" -Passthru ConnectionName : MaConnexionVPN ApplicationID : {C:\Program Files\Microsoft Office 15\root\office15\OUTLOOK.EXE}

 

Évidement, il vous faudra peut être ajuster le chemin vers le binaire d’Outlook.

Maintenant, place à la magie, démarrez Outlook et admirez !

 


## Source

- [technet.microsoft.com](ttps://technet.microsoft.com/fr-fr/library/dn296460%28v=wps.630%29.aspx)


