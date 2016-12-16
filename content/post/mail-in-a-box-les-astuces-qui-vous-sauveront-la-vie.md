+++
author = "MrRaph_"
categories = ["Dovecot","Linux","mail","mail in a box les astuces qui vous sauveront la vie","Mail-in-a-Box","Postfix","Ubuntu"]
image = "https://techan.fr/wp-content/uploads/2015/09/Mailinabox.jpg"
slug = "mail-in-a-box-les-astuces-qui-vous-sauveront-la-vie"
draft = false
title = "Mail-in-a-Box les astuces qui vous sauveront la vie"
date = 2015-09-29T11:32:59Z
tags = ["Dovecot","Linux","mail","mail in a box les astuces qui vous sauveront la vie","Mail-in-a-Box","Postfix","Ubuntu"]
description = ""

+++


[Mail-in-a-Box](https://mailinabox.email/) est un ensemble de scripts qui permettent de transformer une Ubuntu 14.04 en un serveur de mail complet. Cet outil installe et configure Postfix et Dovecot pour l’envoi et la réception d’emails, mais aussi le webmail RoundCube, OwnCloud pour la gestion des contacts et des calendriers – mais également la partie stockage de fichiers. [Mail-in-a-Box](https://mailinabox.email/) propose également de servir de serveur DNS pour votre domaine. Notons également la présence de Z-Push dans cette installation qui fournit le support du « Push » pour la réception des emails.

 

Son installation est très simple sur une machine classique, [ce processus](https://mailinabox.email/guide.html#checklist) est décrit sur le site de [Mail-in-a-Box](https://mailinabox.email/). Cependant, malgré la simplicité d’installation de cet excellent outil, il y a quelques petits bugs/manques qui risquent de très vite vous ennuyer … Je vais décrire ici comment solutionner une grande majorité d’entre eux !

 


## Installation sur une machine ARM

Si vous souhaitez installer [Mail-in-a-Box](https://mailinabox.email/) sur une machine basée sur une infrastructure ARM – comme une RaspBerry Pi ou un serveur chez [Scaleway](https://www.scaleway.com/) – il va vous falloir suivre quelques étapes préparatoires !

 

#### Empêcher l’installation du FireWall

 

Chez [Scaleway](https://www.scaleway.com/), vous devrez empêcher [Mail-in-a-Box](https://mailinabox.email/) d’installer et surtout de configurer UFW car la configuration mise en place bloquerait les accès du serveur à ses disques. En effet les serveurs ARM de chez Scaleway sont connectés à leurs disques par le réseau via le protocole NBD. J’ai testé une installation sans désactiver UFW et j’ai du supprimer la machine. ;-)

La désactivation se fait simplement en assignant une valeur à la variable DISABLE_FIREWALL.

    
    export DISABLE_FIREWALL=PASDEFIREWALLSTP





#### Préparation de l'installation




Une fois que ceci est fait, on va récupérer les sources d'installation et ajouter un utilisateur "nsd". Cet utilisateur est normalement créé à l'installation du serveur DNS, mais un bug dans le paquet fourni par Ubuntu ne le fait pas et bloque ainsi l'installation de Mail-in-a-Box.



    
    apt-get install git
    git clone https://github.com/mail-in-a-box/mailinabox
    cd mailinabox
    curl -s https://keybase.io/joshdata/key.asc | gpg --import
    git verify-tag v0.13b
    useradd nsd




On édite le script de Mail-in-a-Box qui configure Dovecot afin de ne pas installer le plugin pour Solr, le paquet n'existe pas sur ARM.

    
    vim setup/mail-dovecot.sh




Rechercher les lignes suivantes dans le fichier et commentez **dovecot-lucene**, comme suit.

    
    echo "Installing Dovecot (IMAP server)..."
    apt_install \
            dovecot-core dovecot-imapd dovecot-pop3d dovecot-lmtpd dovecot-sqlite sqlite3 \
            dovecot-sieve dovecot-managesieved # dovecot-lucene




Rechercher les lignes suivantes dans le fichier et remplacez la ligne** mail_plugins**, comme suit.

    
    # Full Text Search - Enable full text search of mail using dovecot's lucene plugin,
    # which *we* package and distribute (dovecot-lucene package).
    tools/editconf.py /etc/dovecot/conf.d/10-mail.conf \
            mail_plugins="\$mail_plugins fts"
            #mail_plugins="\$mail_plugins fts fts_lucene"
    cat > /etc/dovecot/conf.d/90-plugin-fts.conf << EOF;




On peut maintenant lancer l'installation de Mail-in-a-Box via la commande suivante.

    
    sudo setup/start.sh




L'installation se déroullera alors comme documenté [ici](https://mailinabox.email/guide.html#setup).

https://www.youtube.com/watch?v=HQOj-Mm1fYs&start;=625&end;=753




## Configuration d'IPTables chez Scaleway




Comme on l'a vu plus haut, chez Scaleway on doit désactiver l'installation d'UFW, ce qui laisse le système un peu vulnérable. Pour pallier à l'abscence d'UFW, j'ai pris le parti de configurer IPTables via un script.

    
    mkdir /root/bin
    vi /root/bin/iptables.sh




Voici le contenu du script **iptables.sh**b, libre à vous d'ajouter les lignes de votre choix. Les lignes cruciales sont celles surlignées, elles permettent de laisser paser le traffic réseau entre le serveur et ses disques.

    
    #!/bin/bash
    
    nbdip=$(curl -s 169.254.42.42/conf | grep VOLUMES_0_EXPORT_URI=nbd:// | sed "s/VOLUMES_0_EXPORT_URI=nbd:\/\///" | awk -F ":" '{ print $1 }' | grep -E -o "10\.1\.([0-2]?[0-9][0-9]?)\.([0-2]?[0-9][0-9]?)")
    if [ $? -eq 1 ]; then
            nbdip="10.1.18.0/23"
    fi
    
    iptables -P INPUT ACCEPT
    iptables -F INPUT
    iptables -F OUTPUT
    iptables -F FORWARD
    
    iptables -P OUTPUT ACCEPT
    iptables -P FORWARD ACCEPT
    
    iptables -A INPUT -i lo -j ACCEPT
    iptables -A INPUT -i eth0 -s $nbdip -j ACCEPT
    iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
    
    #--- règles perso ici ----
    iptables -A INPUT -p tcp --dport 22 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 25 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 53 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 80 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 443 -m state --state NEW,ESTABLISHED -j ACCEPT
    
    iptables -A INPUT -p tcp --dport 110 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 143 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 993 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 465 -m state --state NEW,ESTABLISHED -j ACCEPT
    iptables -A INPUT -p tcp --dport 587 -m state --state NEW,ESTABLISHED -j ACCEPT
    #-------------------------------
    
    iptables -P INPUT DROP
    
    exit 0
    







## Erreur lors du System Status Check




Il se peut que vous rencontriez une erreur sur la page d'accueil de Mail-in-a-Box - System Status Check. Cette page peut être lingue a charger car l'outil fait des vérification sur la bonne santé des différents composants mais également sur la configuration des différents domaines DNS dont elle s'occupe.

Il se peut donc que vous aillez une erreur de ce type :

[![MailInABox les astuces qui vous sauveront la vie](https://techan.fr/wp-content/uploads/2015/09/screenshot.876.jpg)](https://techan.fr/wp-content/uploads/2015/09/screenshot.876.jpg)

Rien de grave, cette erreur apparaît lorsque les vérifications sont trop longues et que le serveur Web - NGinx - en a marre d'attendre ... Il suffit d’allonger ce temps d'attente pour ne plus avoir cette erreur.



Pour cela, éditez le fichier de configuration de NGinx.

    
    vi /etc/nginx/conf.d/local.conf




Repérez le bloc suivant :

    
            # Control Panel
            # Proxy /admin to our Python based control panel daemon. It is
            # listening on IPv4 only so use an IP address and not 'localhost'.
            rewrite ^/admin$ /admin/;
            rewrite ^/admin/munin$ /admin/munin/ redirect;
            location /admin/ {
                    proxy_pass http://127.0.0.1:10222/;
                    proxy_set_header X-Forwarded-For $remote_addr;
            }
    




Et modifiez le comme suit :

    
            # Control Panel
            # Proxy /admin to our Python based control panel daemon. It is
            # listening on IPv4 only so use an IP address and not 'localhost'.
            rewrite ^/admin$ /admin/;
            rewrite ^/admin/munin$ /admin/munin/ redirect;
            location /admin/ {
                    proxy_connect_timeout   90;
                    proxy_send_timeout      90;
                    proxy_read_timeout      90;
                    proxy_pass http://127.0.0.1:10222/;
                    proxy_set_header X-Forwarded-For $remote_addr;
            }
    




Il ne vous reste plus maintenant qu'a redémarrer NGinx !

    
    # service nginx restart
     * Restarting nginx nginx







## Ajouter du swap




Cette étape n'est pas nécessaire si Mail-in-a-box est hébergé sur une machine "classique", en revanche sur une petite machine, cela peut lui donner un petit plus de pèche. C'est mon cas chez Scaleway, mon hôte n'a que 2 Go de RAM, j'ai donc ajouté 1 Go de swap !



On commence par générer un fichier d'un 1 Go, j'ai décidé de le placer directement dans / et de le nommer **swap**.

    
    root@boxr:~# dd if=/dev/zero of=/swap count=2097152
    2097152+0 records in
    2097152+0 records out
    1073741824 bytes (1.1 GB) copied, 27.25 s, 39.4 MB/s
    root@boxr:~# mkswap /swap
    Setting up swapspace version 1, size = 1048572 KiB
    no label, UUID=9a41b8c0-b106-4f4b-b864-d03140e80c73
    root@boxr:~# chmod 600 /swap




On modifie ensuite le fichier **/etc/fstab**.

    
    root@box:~# vi /etc/fstab
    




Pour y ajouter la ligne renseignant notre fichier de swap.

    
    /swap none    swap    defaults,_netdev,nobootwait     0 0




On peut maintenant activer ce swap.

    
    root@box:~# swapon -a




[caption id="attachment_1819" align="aligncenter" width="500"][![Mail-in-a-Box les astuces qui vous sauveront la vie](https://techan.fr/wp-content/uploads/2015/09/screenshot.874.jpg)](https://techan.fr/wp-content/uploads/2015/09/screenshot.874.jpg) Le swap est désormais actif ![/caption]

Nous allons créer un fichier dans le dossier **/etc/init.d** ceci afin d'activer automatiquement le swap au démarrage de la machine.

    
    vi /etc/init.d/swap




Voici le contenu de ce script.

    
    #!/bin/bash
    ### BEGIN INIT INFO
    # Provides: mountswap
    # Required-Start: $network $local_fs
    # Required-Stop: $local_fs
    # Default-Start: 2 3 4 5
    # Default-Stop: 0 1 6
    # X-Start-After: nbd-client
    # Short-Description: Workaround to mount an NBD device as swap OS device. IMPORTANT: add '_netdev' mount option to the swap device in /etc/fstab
    ### END INIT INFO
    
    . /lib/lsb/init-functions
    
    case "${1:-''}" in
      'start')
            log_daemon_msg "Activating swap devices"
            /sbin/swapon -a
            [ $? -eq 0 ] && log_end_msg 0 || log_end_msg 1
      ;;
    esac




On le rend exécutable et le tour est joué !

    
    chmod +x /etc/init.d/swap







## Z-Push




Il existe un problème de synchronisation lors de l'utilisation de plusieurs comptes sur le même terminal. Par exemple dans le cas ou vous créé deux compte email sur votre Mail-in-a-Box et que vous tentez de les ajouter tous les deux sur votre iPhone. Le premier s'ajoutera sans aucun problème mais vous ne pourrez pas consulter les mails du second lorsque vous l'aurez ajouté ...



C'est pénible, mais il s'agit d'un bug dans Z-Push ... Heureusement il y a un moyen de résoudre ce problème, our cela, éditez le fichier suivant.

    
    vi /usr/local/lib/z-push/config.php




Et ajouter les lignes suivantes à la fin du fichier, juste avant la ligne **?>**.

    
    if (isset($_GET['DeviceId']) && isset($_GET['User']) && $_GET['DeviceId'] != "")
        $_GET['DeviceId'] = sha1($_GET['DeviceId'].":".$_GET['User']);




Et voilà !




#### Administration de Z-Push




L'administration de Z-Push peut se faire en ligne de commande, cela permet par exemple de réinitialiser la synchronisation d'un device et cela peut être très utile !



Cependant, pour pouvoir l'utiliser, il faut bidouiller un tout petit peu, commencez par éditer le fichier suivant.

    
    vi /etc/php5/cli/php.ini




Recherchez le bloc **Paths and Directories** et modifiez la ligne **include_path** comme suit.

    
    ;;;;;;;;;;;;;;;;;;;;;;;;
    ; Paths and Directories ;
    ;;;;;;;;;;;;;;;;;;;;;;;;;
    
    ; UNIX: "/path1:/path2"
    ;include_path = ".:/usr/share/php"
    include_path = ".:/usr/share/php:/usr/share/pear:/usr/local/lib/z-push/:/usr/share/awl/inc/"
    




La commande **z-push-admin** fonctionnera alors en ligne de commande et vous permettra d'administrer Z-Push.

    
    root@box-aldanet-fr:/usr/local/lib/z-push# z-push-admin
    Usage:
            z-push-admin.php -a ACTION [options]
    
    Parameters:
            -a list/wipe/remove/resync/clearloop
            [-u] username
            [-d] deviceid
    
    Actions:
            list                             Lists all devices and synchronized users
            list -u USER                     Lists all devices of user USER
            list -d DEVICE                   Lists all users of device DEVICE
            lastsync                         Lists all devices and synchronized users and the last synchronization time
            wipe -u USER                     Remote wipes all devices of user USER
            wipe -d DEVICE                   Remote wipes device DEVICE
            wipe -u USER -d DEVICE           Remote wipes device DEVICE of user USER
            remove -u USER                   Removes all state data of all devices of user USER
            remove -d DEVICE                 Removes all state data of all users synchronized on device DEVICE
            remove -u USER -d DEVICE         Removes all related state data of device DEVICE of user USER
            resync -u USER -d DEVICE         Resynchronizes all data of device DEVICE of user USER
            resync -t TYPE                   Resynchronizes all folders of type 'email', 'calendar', 'contact', 'task' or 'note' for all devices and users.
            resync -t TYPE -u USER           Resynchronizes all folders of type 'email', 'calendar', 'contact', 'task' or 'note' for the user USER.
            resync -t TYPE -u USER -d DEVICE Resynchronizes all folders of type 'email', 'calendar', 'contact', 'task' or 'note' for a specified device and user.
            resync -t FOLDERID -u USER       Resynchronize the specified folder id only. The USER should be specified.
            clearloop                        Clears system wide loop detection data
            clearloop -d DEVICE -u USER      Clears all loop detection data of a device DEVICE and an optional user USER
            fixstates                        Checks the states for integrity and fixes potential issues
    





## Compiler le paquet dovecot-lucene


Le paquet dovect-lucene n'est pas compilé pour armhf par la personne qui maintient Mail-in-a-Box, pour bénéficier de l'indexation full text des mail via ce plugin, il va falloir créer le paquet. Voici la marche à suivre.



Tout d'abord, il faut ajouter le dépot PPA, on va récupérer les sources d'ici.

    
    apt-add-repository ppa:mail-in-a-box/ppa


Il faut éditer le fichier de ce dépôt pour activer les sources.

    
    vi /etc/apt/sources.list.d/mail-in-a-box-ppa-trusty.list


On dé-commente la ligne :

    
    deb-src http://ppa.launchpad.net/mail-in-a-box/ppa/ubuntu trusty main


On rafraichit apt-get ... Et on installe les outils et dépendances nécessaires.

    
    apt-get update
    apt-get install debhelper cdbs lintian build-essential fakeroot devscripts pbuilder dh-make debootstrap
    apt-get install libclucene-dev libpam0g-dev libpq-dev libmysqlclient-dev libsqlite3-dev libsasl2-dev drac-dev libbz2-dev libdb-dev libcurl4-gnutls-dev libwrap0-dev dh-systemd  libclucene-dev liblzma-dev libexttextcat-dev libstemmer-dev hardening-wrapper dh-autoreconf


On télécharge les sources.

    
    cd /tmp
    apt-get source dovecot-lucene
    cd dovecot-2.2.9/


Et on construit le paquet ! Cette étape est un peu longue, comptez 30 bonnes minutes !

    
    debuild -us -uc -b


Il ne reste plus qu'a installer le paquet et à configurer Dovecot !

    
    cd /tmp
    dpkg -i dovecot-lucene_2.2.9-1ubuntu2.1+miab1_armhf.deb




    
    vi /etc/dovecot/conf.d/10-mail.conf


Chercher le bloc suivant :

    
    # Space separated list of plugins to load for all services. Plugins specific to
    # IMAP, LDA, etc. are added to this list in their own .conf files.
    #mail_plugins =




Et modifiez le comme suit :

    
    # Space separated list of plugins to load for all services. Plugins specific to
    # IMAP, LDA, etc. are added to this list in their own .conf files.
    #mail_plugins =
    mail_plugins=$mail_plugins fts fts_lucene


Assurez vous que le fichier : **/etc/dovecot/conf.d/90-plugin-fts.conf**

Contient bien les lignes :

    
    plugin {
      fts = lucene
      fts_lucene = whitespace_chars=@.
    }
    


Il n'y a plus qu'a redémarrer Dovect !

    
    service dovecot restart









## Sources


	
  * [GitHub - Correction Z-Push (Anglais)](https://github.com/fmbiete/Z-Push-contrib/issues/97)

	
  * [discourse.mailinabox.email (dovecot-luncene sur armhf) - Anglais](https://discourse.mailinabox.email/t/armhf-builds-of-dovecot-lucene-and-postgrey/837/5)