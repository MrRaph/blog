+++
tags = ["Dovecot","Indexation full text","Mails","Solr"]
slug = "indexation-full-text-des-mails"
draft = false
title = "Indexation full text des mails"
date = 2015-01-26T10:32:40Z
author = "MrRaph_"
categories = ["Dovecot","Indexation full text","Mails","Solr"]
image = "https://techan.fr/wp-content/uploads/2015/01/solr_logo.png"
description = ""

+++


Heureux possesseur d’un serveur de mail complet composé d’un postfix, de dovecot et d’un webmail, Horde pour ne pas le citer, je n’arrêtais cependant pas de pester contre la lenteur de la recherche dans les mails. Il faut dire que ma boite personnelle pèse maintenant plus de 4 Go … Et que mes plus anciens mails ont été reçus en 2010.

Par défaut lorsque Dovecot reçoit une requête IMAP lui demandant de rechercher des termes dans une boite mail, il scanne tous les mails de la boite ou du compte en fonction de ce que l’on a demandé. On imagine donc parfaitement que cela peut prendre du temps lorsqu’on a une boite mail bien garnie …  
  
 J’ai donc trouvé une solution : Solr. Il s’agit d’un moteur d’indexation écrit en Java développé par « The Apache Software Fundation ». Il nécessite un serveur Tomcat, ce qui, de prime abord m’a plutôt refroidi, mais ça vaut le coup, je vous le garanti ! Une fois configuré, Solr va fournir une indexation full text des mails que Dovecot va pouvoir interroger directement. Si par malheur, Solr n’était pas disponible, Dovecot ne s’acharne pas, il prendra son courage à deux mains et reprendra ses propres recherches laborieuses.


## Installation de Solr sur Ubuntu

Je pars du principe que vous avez déjà installé votre Tomcat, qu’il est fonctionnel et que vous connaissez le port sur lequel il répond.

#### Le plugin pour dovecot

Il va falloir un plugin à Dovecot pour pouvoir tirer profit de Solr. Il existe un package sur Ubuntu qui propose directement le plugin nécessaire à Dovecot pour interroger Solr.

aptitude install dovecot-solr

#### Installation de Solr

Comme je suis un gros flemmard, j’ai utilisé la version de Solr packagée avec Ubuntu, pour l’installer, il suffit de passer la commande suivante :

aptitude install libsolr-java solr-common solr-tomcat

###  Et maintenant, la configuration !

#### Du côté de Tomcat et Solr

Éditez le fichier : /etc/solr/conf/schema.xml afin qu’il ressemble à ceci :

<?xml version="1.0" encoding="UTF-8" ?> <!-- For fts-solr: This is the Solr schema file, place it into solr/conf/schema.xml. You may want to modify the tokenizers and filters. --> <schema name="dovecot" version="1.4"> <types> <!-- IMAP has 32bit unsigned ints but java ints are signed, so use longs --> <fieldType name="string" class="solr.StrField" omitNorms="true"/> <fieldType name="long" class="solr.LongField" omitNorms="true"/> <fieldType name="slong" class="solr.SortableLongField" omitNorms="true"/> <fieldType name="float" class="solr.FloatField" omitNorms="true"/> <fieldType name="boolean" class="solr.BoolField" omitNorms="true"/> <fieldType name="text" class="solr.TextField" positionIncrementGap="100"> <analyzer type="index"> <tokenizer class="solr.WhitespaceTokenizerFactory"/> <filter class="solr.StopFilterFactory" ignoreCase="true" words="stopwords.txt"/> <filter class="solr.WordDelimiterFilterFactory" generateWordParts="1" generateNumberParts="1" catenateWords="1" catenateNumbers="1" catenateAll="0"/> <filter class="solr.LowerCaseFilterFactory"/> <filter class="solr.EnglishPorterFilterFactory" protected="protwords.txt"/> <filter class="solr.RemoveDuplicatesTokenFilterFactory"/> </analyzer> <analyzer type="query"> <tokenizer class="solr.WhitespaceTokenizerFactory"/> <filter class="solr.SynonymFilterFactory" synonyms="synonyms.txt" ignoreCase="true" expand="true"/> <filter class="solr.StopFilterFactory" ignoreCase="true" words="stopwords.txt"/> <filter class="solr.WordDelimiterFilterFactory" generateWordParts="1" generateNumberParts="1" catenateWords="0" catenateNumbers="0" catenateAll="0"/> <filter class="solr.LowerCaseFilterFactory"/> <filter class="solr.EnglishPorterFilterFactory" protected="protwords.txt"/> <filter class="solr.RemoveDuplicatesTokenFilterFactory"/> </analyzer> </fieldType> </types> <fields> <field name="id" type="string" indexed="true" stored="true" required="true" /> <field name="uid" type="slong" indexed="true" stored="true" required="true" /> <field name="box" type="string" indexed="true" stored="true" required="true" /> <field name="user" type="string" indexed="true" stored="true" required="true" /> <field name="hdr" type="text" indexed="true" stored="false" /> <field name="body" type="text" indexed="true" stored="false" /> <field name="from" type="text" indexed="true" stored="false" /> <field name="to" type="text" indexed="true" stored="false" /> <field name="cc" type="text" indexed="true" stored="false" /> <field name="bcc" type="text" indexed="true" stored="false" /> <field name="subject" type="text" indexed="true" stored="false" /> </fields> <uniqueKey>id</uniqueKey> <defaultSearchField>body</defaultSearchField> <solrQueryParser defaultOperator="AND" /> </schema>

Ceci explique à Solr comment indexer les mail.

Il faut ensuite ajouter les deux lignes suivantes dans votre contrab, car par défaut, Dovecot de ne fait que des « soft commits » dans Solr. Il faut forcer régulièrement un « hard commit » sinon Solr n’arrête pas de faire grossir ses logs de transactions …

* * * * * curl http://localhost:7777/solr/update?commit=true >> /dev/null 0 0 * * * curl http://localhost:7777/solr/update?optimize=true >> /dev/null

 

Et pour finir :

service tomcat6 restart

####  Du côté de Dovecot

Editez le fichier de configuration suivant /etc/dovecot/conf.d/90-plugin.conf et ajouter les lignes nécessaires pour qu’il ressemble à ceci :

## ## Plugin settings ## # All wanted plugins must be listed in mail_plugins setting before any of the # settings take effect. See <doc/wiki/Plugins.txt> for list of plugins and # their configuration. Note that %variable expansion is done for all values. plugin { #setting_name = value fts = solr fts_solr = break-imap-search url=http://localhost:7777/solr/ }

N’oubliez pas de changer le port de d’écoute de Tomcat 