+++
description = ""
slug = "logstash-configuration-des-inputs-filter-et-output"
draft = false
title = "[logstash] Configuration des inputs, filter et output"
date = 2014-10-15T10:23:39Z
tags = ["Linux","Logs","Logs centralisés","Logstash"]
image = "https://techan.fr/images/2014/11/Linux.png"
author = "MrRaph_"
categories = ["Linux","Logs","Logs centralisés","Logstash"]

+++


Dans l’article [[Linux] Envoyer des logs sur un serveur central avec rsyslog](https://techan.fr/linux-envoyer-des-logs-sur-un-serveur-central-avec-rsyslog/), j’ai décrit comment envoyer des logs vers une machine distante en utiliser le rsyslog installé sur la machine.

Dans cet article, je vais décrire la configuration de l’outil[logstash](http://logstash.net/) que j’ai mis par dessus afin de recevoir, parser, et transférer les logs à [Graylog2](http://www.graylog2.org/).

Voici l’architecture telle que je l’ai mise en place.

<div class="wp-caption aligncenter" id="attachment_203" style="width: 347px">[![Schéma des différentes couches logicielles sur le serveur de log centralisé et de logstash](https://techan.fr/images/2014/10/shema_syslog_logstash.png)](https://techan.fr/images/2014/10/shema_syslog_logstash.png)Schéma des différentes couches logicielles sur le serveur de log centralisé

</div>Le serveur logstash écoute sur le port 5140, les machines clientes envoient leurs logs à logstash sur ce port. Cependant, pour certaines machines, j’ai eu des soucis de réception des logs … Pour celles-ci, je passe donc les logs à rsyslog qui les écrit dans un fichier de log puis logstash lit ces fichiers et les parse. Le serveur rsyslog écoute sur son port classique, le 514.

Une fois les logs ou les fichiers digérés, logstash envoie les informations à Graylog2 qui permet d’avoir une vue sympa des évènements, de l’historique, des graphes, …

 


## Les fichiers de configuration de logstash

Dans mon installation, les fichiers de configuration se trouvent dans le dossier /etc/logstash/conf.d.

Voici le contenu de ce dossier, je détaillerai chacun de ces fichiers dans les parties suivantes.

    [root@xxxxxxxxx conf.d]# ll
    total 28
    -rw-r--r-- 1 root root 194 13 oct. 14:34 01-input_files.conf
    -rw-r--r-- 1 root root 155 10 oct. 16:26 02-input_rsyslog.conf
    -rw-r--r-- 1 root root 160 9 oct. 17:23 10-filter_rsyslog.conf
    -rw-r--r-- 1 root root 1150 10 oct. 11:34 11-filter_apache.conf
    -rw-r--r-- 1 root root 816 13 oct. 14:45 12-filter_esxi.conf
    -rw-r--r-- 1 root root 1535 13 oct. 14:20 13-filter_mysql_slow_queries.conf
    -rw-r--r-- 1 root root 1801 13 oct. 14:27 31-to_graylog2.conf

###

J’ai coupé la configuration en plusieurs morceaux afin de pouvoir plus facilement tester chacun des éléments.

Les fichiers commençant par un 0 sont des fichiers qui décrivent les entrées de logstash.

Ceux commençant par un 1 sont les fichiers qui décrivent les filtres de logstash.

Et ceux qui commencent par un 3 sont les fichiers dans lesquels les sorties de logstash sont définies.

 

### Les entrées de logstash

Dans ma configuration j’utilise deux types d’entrées :

- des entrées de types fichiers, créés par le rsyslog serveur
- des entrées de type syslog qui agissent comme un serveur syslog qui écoute

##### Les entrées de types fichier

Elles sont documentées dans le fichier « 01-input_files.conf ».

    input {
       file {
          path => "/data/syslog/172.16.17.51/*.log" exclude => "*.gz"
          type => "esxi"
        }
        file {
           path => "/data/syslog/127.0.0.1/*.log" exclude => "*.gz"
           type => "localhost"
        }
    }

Ce fichier dit à logstash d’alelr lire tous les fichiers se terminant par « .log » dans les dossiers « /data/syslog/127.0.0.1 » et « /data/syslog/172.16.12.51 » en excluant les fichiers se terminant par « .gz ».

A chaque fois, je fixe un type « esxi » pour le premier dossier, « localhost » pour le second, ceci permettra de différencier les lignes de log dans les étapes suivantes.

 

##### L’entrée de type syslog

Elles sont documentées dans le fichier « 02-input_rsyslog.conf ».

 

    input {
       syslog {
          type => syslog
          port => 5140
       }
    }

 

Cette entrée permet à logstash d’écouter sur le port 5140.

Les lignes de log arrivées par cette entrée auront le type « syslog ».

 

### Les filtres de logstash

Elles sont documentées dans les fichiers « 10-filter_rsyslog.conf », « 11-filter_apache.conf », « 12-filter_esxi.conf » et « 13-filter_mysql_slow_queries.conf ».

 

##### Fichier 10-filter_rsyslog.conf

    filter {
       if [type] == "syslog" {
          syslog_pri { }
          date { locale => "en" match => [ "syslog_timestamp", "MMM d HH:mm:ss", "MMM dd HH:mm:ss" ] }
       }
    }

 

Dans ce fichier là, on ne va traiter que les entrées de type « syslog ». On va leur appliquer un traitement appelé « syslog_pri » qui décompose les logs en se basant sur les champs définis dans  les RFC de syslog.

 

Le paramètre « date » permet de fixer les date en anglais et de donner un format de data à l’outil.

<span style="text-decoration: underline;">Note :</span> J’ai eu pas mal de soucis avec les dates car mon système est installé en Français … J’ai du modifier le script de lancement de logstash pour le forcer en anglais.

Voici la méthode a utiliser pour le forcer en anglais : [[Linux] Forcer un programme a utiliser une locale anglaise](https://techan.fr/linux-forcer-un-programme-a-utiliser-une-locale-anglaise/ "[Linux] Forcer un programme a utiliser une locale anglaise").

 

##### Fichier 11-filter_apache.conf

    filter {
     if [program] == "apache-access" { grok { match => { "message" => "%{COMBINEDAPACHELOG}" } } }
     if [program] == "apache-error" {
      grok {
        match => { "message" => "\[%{HTTPERRORDATE:timestamp}\] \[%{WORD:class}\] \[%{WORD:originator} %{IP:clientip}\] %{GREEDYDATA:errmsg}" }
        patterns_dir => ["/etc/logstash/grok"]
      }
      date {
        locale => "en"
        match => [ "syslog_timestamp", "MMM d HH:mm:ss", "MMM dd HH:mm:ss" ]
      }
     }
    }

Dans ce filtre, on ne s’occupe que des logs des serveurs apache. Le filtre est fait sur le champ « program » des logs reçus, ce champ est positionné par le rsyslog qui envoie ces logs.

 

Ces deux filtres utilisent un outil qui se nomme « grok », ce dernier permet de parser les logs avec des expressions régulières spéciales. C’est une des grandes force de logstash.

 

Pour les access logs d’apache, une expression est déjà incluse dans celles fournies par grok, elle s’appelle « COMBINEDAPACHELOG ». Pour ces logs là, on a donc pas grand chose a faire.

Par contre, pour les logs d’erreur, c’est une autre histoire, il faut construire le pattern. Cela se fait dans le champ « match », match compare le contenu du champ « message » avec notre pattern. Si cela match, les champs définis dans le pattern sont remplis.

<span style="text-decoration: underline;">Note :</span> Pour ces erreur logs d’apache, j’ai inclus un fichier de pattern externe présent dans le dossier /etc/logstash/grok. Ce fichier contient des expressions toutes faite, très pratique. J’y ai juste ajouté la définition du champ « HTTPERRORDATE » qui n’est pas standard.

Le contenu de ce fichier est présent dans les annexes en bas de cet article.

 

Voici comment est paramétré le rsyslog sur le serveur qui héberge l’apache :

## >> Apache access files # $InputFileName /var/log/httpd/access_log $InputFileTag apache-access: $InputFileStateFile apache-access_log $InputRunFileMonitor ### >> Apache error files $InputFileName /var/log/httpd/error_log $InputFileTag apache-error: $InputFileStateFile apache-error_log $InputRunFileMonitor

Notez qu’on retrouve les valeurs du champ « program » dans la variable « InputFileTag » que je teste dans mon filtre.

Les valeurs des « InputFileStateFile » doivent être uniques dans la configuration de rsyslog, sinon les logs ne sont pas parsés.

 

##### Fichier 12-filter_esxi.conf

    filter {
       if [type] == "esxi" and [path] != "/data/syslog/172.16.17.51/for.log" {
          grok {
            pattern => ['(?:%{SYSLOGTIMESTAMP:timestamp}|%{TIMESTAMP_ISO8601:timestamp8601}) (?:%{SYSLOGHOST:logsource}) (?:%{SYSLOGPROG}): (?<messagebody>(?:\[(?<esxi_thread_id>[0-9A-Z]{8,8}) %{DATA:esxi_loglevel} \'%{DATA:esxi_service}\'\] %{GREEDYDATA:esxi_message}|%{GREEDYDATA}))']
          type => "esxi" }
       } else if [type] == "esxi" and [path] == "/data/syslog/172.16.17.51/for.log" {
          grok {
             pattern => ['(?:%{SYSLOGTIMESTAMP:timestamp}|%{TIMESTAMP_ISO8601:timestamp8601}) (?:%{DATA:vmware_bullshit}?,) (?:%{SYSLOGHOST:logsource}) (?:%{SYSLOGPROG}): (?<messagebody>(?:\[(?<esxi_thread_id>[0-9A-Z]{8,8}) %{DATA:esxi_loglevel} \'%{DATA:esxi_service}\'\] %{GREEDYDATA:esxi_message}|%{GREEDYDATA}))']
             type => "esxi"
          }
       }
    }

 

Dans ce filtre, je gère les logs qui me parviennent de serveurs ESXi dans des fichiers plats. Visiblement, les ESXi préfèrent envoyer leurs logs à un rsyslog plutôt qu’à logstash …

 

Pour traiter ces lgos là, je filtre sur le type qui doit être égal à « esxi » mais aussi sur le chemin du fichier car le fichier « for.log » a une structure différente qui nécessite un pattern un peu différent.

 

##### Fichier 13-filter_mysql_slow_queries.conf

    filter {
       if [program] == "mysql-slow-queries" and [type] == "syslog" {
          mutate {
            replace => [ "type", "lumberjack_multiline" ]
          }
          multiline {
            pattern => "^# User@Host:" negate => true what => previous
          }
      }
      if [program] == "mysql-slow-queries" and [type] == "lumberjack_multiline" {
        # Capture user, optional host and optional ip fields
        # sample log file lines:
        # User@Host: logstash[logstash] @ localhost [127.0.0.1]
        # User@Host: logstash[logstash] @ [127.0.0.1]
        grok {
          match => [ "message", "^# User@Host: %{USER:user}(?:\[[^\]]+\])?\s+@\s+%{HOST:host}?\s+\[%{IP:ip}?\]" ]
        }
        # Capture query time, lock time, rows returned and rows examined
        # sample log file lines:
        # Query_time: 102.413328 Lock_time: 0.000167 Rows_sent: 0 Rows_examined: 1970
        # Query_time: 1.113464 Lock_time: 0.000128 Rows_sent: 1 Rows_examined: 0
        grok {
          match => [ "message", "^
          # Query_time:
          %{NUMBER:duration:float}\s+Lock_time: %{NUMBER:lock_wait:float} Rows_sent: %{NUMBER:results:int} \s*Rows_examined: %{NUMBER:scanned:int}"]
        }
        # Capture the time the query happened
        grok {
          match => [ "message", "^SET timestamp=%{NUMBER:timestamp};" ] }
           # Extract the time based on the time of the query and
          # not the time the item got logged
          date {
            match => [ "timestamp", "UNIX" ] }
            # Drop the captured timestamp field since it has been moved to the # time of the event
            mutate { remove_field => "timestamp" }
          }
        }

 

Dans ce filtre, je traite les fichier de logs spéciaux dans lequel MySQL va écrire les informations sur les requêtes longues qu’il reçoit. Ces information peuvent être très intéressantes à des fins de débogages ou de monitoring d’application.

 

Cependant, ce fichier m’a posé pas mal de soucis car les entrées ce font sur plusieurs lignes …

J’applique donc deux filtres de suite sur ces entrées de log. Une première qui filtre sur le program et le type dont les actions sont de changer le type de ces entrées de log. On remplace le type « syslog » par un type « lumberjack_multiline ». La deuxième action de ce filtre est de transformer les entrées reçues en entrées multi-lignes.

Dans l’outil « multiline » on précise un pattern qui permettra à l’outil de détecter le début de nos blocs de logs et des options qui lui disent dans quel sens regarder.

 

Maintenant que les bloc est multi-lignes, on peut le traitement comme une entrée classique. pour cela on filtre les entrées dans le type est celui qu’on a positionné juste avant pour être sûr. On utilise ici plusieurs pattern dans des champs match afin d’extraire les informations des différentes lignes reçues.

 

### Les sorties de logstash

Elles sont documentées dans le fichier « 31-to_graylog2.conf ».

 

    output { if [program] == "apache-access" { gelf { level => ["%{syslog_severity}"] host => "127.0.0.1" port => "12211" sender => "%{logsource}" short_message => "%{message}" full_message => "%{syslog_full}" ship_metadata => true ship_tags => true ignore_metadata => [ "type", "syslog_pri", "syslog_timestamp", "syslog_hostname", "syslog_message", "syslog_severity", "syslog_severity_code", "syslog_facility_code", "syslog_full" ] } } else if [program] == "apache-error" { gelf { level => ["%{class}","ERROR"] host => "127.0.0.1" port => "12211" sender => "%{logsource}" short_message => "%{message}" full_message => "%{errmsg}" ship_metadata => true ship_tags => true ignore_metadata => [ "type", "syslog_pri", "syslog_timestamp", "syslog_hostname", "syslog_message", "syslog_severity", "syslog_severity_code", "syslog_facility_code", "syslog_full" ] } } else { gelf { level => ["%{syslog_severity}","%{esxi_loglevel}","UNKNOWN"] host => "127.0.0.1" port => "12211" sender => "%{logsource}" short_message => "%{message}" full_message => "%{syslog_full}" ship_metadata => true ship_tags => true } } }

Toutes ces sorties envoient les logs vers le serveur Graylog2. En fonction des différentes sources, les variables sources des champs envoyés varient car en fonction des pattern, les noms ne sont pas forcément les mêmes, surtout pour les « level » et « sender ».

 

### Outils :

[Débugger vos patterns !](http://grokdebug.herokuapp.com/)

 

##### Fichier de patterns

    [root@sl-0-syslogint1 ~]# cat /etc/logstash/grok/grok.conf HTTPERRORDATE %{DAY} %{MONTH} %{MONTHDAY} %{TIME} %{YEAR} APACHEERRORLOG %{SYSLOGTIMESTAMP:mytimestamp} %{SYSLOGHOST:syslog_hostname} %{DATA:syslog_program} \[%{HTTPERRORDATE:timestamp}\] \[%{WORD:severity}\] \[client %{IPORHOST:clientip}\] %{GREEDYDATA:message_remainder} USERNAME [a-zA-Z0-9._-]+ USER %{USERNAME} INT (?:[+-]?(?:[0-9]+)) BASE10NUM (?<![0-9.+-])(?>[+-]?(?:(?:[0-9]+(?:\.[0-9]+)?)|(?:\.[0-9]+))) NUMBER (?:%{BASE10NUM}) BASE16NUM (?<![0-9A-Fa-f])(?:[+-]?(?:0x)?(?:[0-9A-Fa-f]+)) BASE16FLOAT \b(?<![0-9A-Fa-f.])(?:[+-]?(?:0x)?(?:(?:[0-9A-Fa-f]+(?:\.[0-9A-Fa-f]*)?)|(?:\.[0-9A-Fa-f]+)))\b POSINT \b(?:[1-9][0-9]*)\b NONNEGINT \b(?:[0-9]+)\b WORD \b\w+\b NOTSPACE \S+ SPACE \s* DATA .*? GREEDYDATA .* QUOTEDSTRING (?>(?<!\\)(?>"(?>\\.|[^\\"]+)+"|""|(?>'(?>\\.|[^\\']+)+')|''|(?>`(?>\\.|[^\\`]+)+`)|``)) UUID [A-Fa-f0-9]{8}-(?:[A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12} # Networking MAC (?:%{CISCOMAC}|%{WINDOWSMAC}|%{COMMONMAC}) CISCOMAC (?:(?:[A-Fa-f0-9]{4}\.){2}[A-Fa-f0-9]{4}) WINDOWSMAC (?:(?:[A-Fa-f0-9]{2}-){5}[A-Fa-f0-9]{2}) COMMONMAC (?:(?:[A-Fa-f0-9]{2}:){5}[A-Fa-f0-9]{2}) IPV6 ((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)? IPV4 (?<![0-9])(?:(?:25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})[.](?:25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})[.](?:25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2})[.](?:25[0-5]|2[0-4][0-9]|[0-1]?[0-9]{1,2}))(?![0-9]) IP (?:%{IPV6}|%{IPV4}) HOSTNAME \b(?:[0-9A-Za-z][0-9A-Za-z-]{0,62})(?:\.(?:[0-9A-Za-z][0-9A-Za-z-]{0,62}))*(\.?|\b) HOST %{HOSTNAME} IPORHOST (?:%{HOSTNAME}|%{IP}) HOSTPORT %{IPORHOST}:%{POSINT} # paths PATH (?:%{UNIXPATH}|%{WINPATH}) UNIXPATH (?>/(?>[\w_%!$@:.,~-]+|\\.)*)+ TTY (?:/dev/(pts|tty([pq])?)(\w+)?/?(?:[0-9]+)) WINPATH (?>[A-Za-z]+:|\\)(?:\\[^\\?*]*)+ URIPROTO [A-Za-z]+(\+[A-Za-z+]+)? URIHOST %{IPORHOST}(?::%{POSINT:port})? # uripath comes loosely from RFC1738, but mostly from what Firefox # doesn't turn into %XX URIPATH (?:/[A-Za-z0-9$.+!*'(){},~:;=@#%_\-]*)+ #URIPARAM \?(?:[A-Za-z0-9]+(?:=(?:[^&]*))?(?:&(?:[A-Za-z0-9]+(?:=(?:[^&]*))?)?)*)? URIPARAM \?[A-Za-z0-9$.+!*'|(){},~@#%&/=:;_?\-\[\]]* URIPATHPARAM %{URIPATH}(?:%{URIPARAM})? URI %{URIPROTO}://(?:%{USER}(?::[^@]*)?@)?(?:%{URIHOST})?(?:%{URIPATHPARAM})? # Months: January, Feb, 3, 03, 12, December MONTH \b(?:Jan(?:uary)?|Feb(?:ruary)?|Mar(?:ch)?|Apr(?:il)?|May|Jun(?:e)?|Jul(?:y)?|Aug(?:ust)?|Sep(?:tember)?|Oct(?:ober)?|Nov(?:ember)?|Dec(?:ember)?)\b MONTHNUM (?:0?[1-9]|1[0-2]) MONTHNUM2 (?:0[1-9]|1[0-2]) MONTHDAY (?:(?:0[1-9])|(?:[12][0-9])|(?:3[01])|[1-9]) # Days: Monday, Tue, Thu, etc... DAY (?:Mon(?:day)?|Tue(?:sday)?|Wed(?:nesday)?|Thu(?:rsday)?|Fri(?:day)?|Sat(?:urday)?|Sun(?:day)?) # Years? YEAR (?>\d\d){1,2} HOUR (?:2[0123]|[01]?[0-9]) MINUTE (?:[0-5][0-9]) # '60' is a leap second in most time standards and thus is valid. SECOND (?:(?:[0-5]?[0-9]|60)(?:[:.,][0-9]+)?) TIME (?!<[0-9])%{HOUR}:%{MINUTE}(?::%{SECOND})(?![0-9]) # datestamp is YYYY/MM/DD-HH:MM:SS.UUUU (or something like it) DATE_US %{MONTHNUM}[/-]%{MONTHDAY}[/-]%{YEAR} DATE_EU %{MONTHDAY}[./-]%{MONTHNUM}[./-]%{YEAR} ISO8601_TIMEZONE (?:Z|[+-]%{HOUR}(?::?%{MINUTE})) ISO8601_SECOND (?:%{SECOND}|60) TIMESTAMP_ISO8601 %{YEAR}-%{MONTHNUM}-%{MONTHDAY}[T ]%{HOUR}:?%{MINUTE}(?::?%{SECOND})?%{ISO8601_TIMEZONE}? DATE %{DATE_US}|%{DATE_EU} DATESTAMP %{DATE}[- ]%{TIME} TZ (?:[PMCE][SD]T|UTC) DATESTAMP_RFC822 %{DAY} %{MONTH} %{MONTHDAY} %{YEAR} %{TIME} %{TZ} DATESTAMP_RFC2822 %{DAY}, %{MONTHDAY} %{MONTH} %{YEAR} %{TIME} %{ISO8601_TIMEZONE} DATESTAMP_OTHER %{DAY} %{MONTH} %{MONTHDAY} %{TIME} %{TZ} %{YEAR} DATESTAMP_EVENTLOG %{YEAR}%{MONTHNUM2}%{MONTHDAY}%{HOUR}%{MINUTE}%{SECOND} # Syslog Dates: Month Day HH:MM:SS SYSLOGTIMESTAMP %{MONTH} +%{MONTHDAY} %{TIME} PROG (?:[\w._/%-]+) SYSLOGPROG %{PROG:program}(?:\[%{POSINT:pid}\])? SYSLOGHOST %{IPORHOST} SYSLOGFACILITY <%{NONNEGINT:facility}.%{NONNEGINT:priority}> HTTPERRORDATE %{DAY} %{MONTH} %{MONTHDAY} %{TIME} %{YEAR} HTTPDATE %{MONTHDAY}/%{MONTH}/%{YEAR}:%{TIME} %{INT} # Shortcuts QS %{QUOTEDSTRING} # Log formats SYSLOGBASE %{SYSLOGTIMESTAMP:timestamp} (?:%{SYSLOGFACILITY} )?%{SYSLOGHOST:logsource} %{SYSLOGPROG}: COMMONAPACHELOG %{IPORHOST:clientip} %{USER:ident} %{NOTSPACE:auth} \[%{HTTPDATE:timestamp}\] "(?:%{WORD:verb} %{NOTSPACE:request}(?: HTTP/%{NUMBER:httpversion})?|%{DATA:rawrequest})" %{NUMBER:response} (?:%{NUMBER:bytes}|-) COMBINEDAPACHELOG %{COMMONAPACHELOG} %{QS:referrer} %{QS:agent} # Log Levels LOGLEVEL ([Aa]lert|ALERT|[Tt]race|TRACE|[Dd]ebug|DEBUG|[Nn]otice|NOTICE|[Ii]nfo|INFO|[Ww]arn?(?:ing)?|WARN?(?:ING)?|[Ee]rr?(?:or)?|ERR?(?:OR)?|[Cc]rit?(?:ical)?|CRIT?(?:ICAL)?|[Ff]atal|FATAL|[Ss]evere|SEVERE|EMERG(?:ENCY)?|[Ee]merg(?:ency)?)

 
