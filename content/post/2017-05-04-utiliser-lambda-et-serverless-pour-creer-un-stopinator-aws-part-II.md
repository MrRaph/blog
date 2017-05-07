+++
slug = "utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-II"
draft = false
date = "2017-05-07T21:17:12+01:00"
image = "/images/2017/05/Logo_Lambda_Stopinator_2.png"
type = "post"
description = ""
title = "Utiliser Lambda et ServerLess pour creer un stopinator AWS - Partie 2"
author = "MrRaph_"
categories = ["AWS","Lambda","Trucs et Astuces", "Cloud"]
tags = ["AWS","Lambda","Trucs et Astuces", "Cloud"]
+++

# Résumé des épisodes précédents

Dans la [partie 1](/utiliser-lambda-et-serverless-pour-creer-un-stopinator-aws-part-I) nous avons vu les différents composants qui seront utilisés par notre _stopinator_. Nous allons maintenant nous pencher sur les deux éléments clefs de ce projet, l'utilistion du framework [Serverless](http://www.serverless.com/) et la création de notre fonction Lambda.

*Note :* Tous les codes présentés dans cette suite d'articles [sont disponible dans ce dépôt GitHub](https://github.com/MrRaph/article-stopinator).

# Le framework [Serverless](http://www.serverless.com/)

## Installation

L'installation du framework est relativement simple, elle nécessite toute fois que [Node.js](node.js) soit installé sur votre poste. Ceci n'est pas couvert dans cette suite d'article.

Une fois [Node.js](node.js) installé sur votre poste, l'installation de [Serverless](http://www.serverless.com/) est très simple, il suffit de lancer la commande suivante.

    npm install -g serverless

Il est maintenant temps de passer à la configuration du framework.

## Configuration

La configuration principale de [Serverless](http://www.serverless.com/) est liée à la configuration de la [ligne de commande AWS](https://aws.amazon.com/fr/cli/) - que je vous conseille fortement d'[installer](http://docs.aws.amazon.com/fr_fr/cli/latest/userguide/installing.html). [Serverless](http://www.serverless.com/) va se servir des informations de connexion que vous aurez configuré pour utiliser [la ligne de commande AWS](https://aws.amazon.com/fr/cli/).

Assurez-vous que vous disposez d'une paire _Acces Key_, _Secret Key_ créée depuis la console AWS. Si vous n'en avez pas, [leur création est documentée ici par AWS](http://docs.aws.amazon.com/fr_fr/general/latest/gr/managing-aws-access-keys.html).

Une vidéo expliquant la configuration de informations de connexion pour Serverless est disponible sur la chaine Youtube du projet.


{{< youtube HSd9uYj2LJA >}}


### Si vous avez installé la ligne de commande AWS

Si vous avez déjà installé la CLI AWS, alors vous avez probablement déjà configuré l'authentification à votre compte. Vous pouvez vérifier cela en regardant le contenu des fichiers suivants (en fonction de l'OS que vous utilisez) :

* ~/.aws/credentials (Linux / macOS)
*  C:\Users\USERNAME \.aws\credentials (Windows)

Si vous n'avez pas encore configuré la CLI pour vous connecter à votre compte AWS, il faut utiliser la commande `aws configure`. Cette dernière vous demandera les informations nécessaires à la connexion à votre compte AWS et renseignera le fichier `.aws/credentials`. Ceci est documenté [ici](http://docs.aws.amazon.com/fr_fr/cli/latest/userguide/cli-chap-getting-started.html).

Vous pourrez ensuite utiliser ces informations de connexion avec [Serverless](http://www.serverless.com/).

### Si vous n'avez pas installé la ligne de commande AWS

[Serverless](http://www.serverless.com/) propose un moyen de configurer l'accès à votre compte via sa propre ligne de commande. Ceci ce fait via la ligne de commande suivante.

    serverless config credentials --provider aws --key <Access Key> --secret <Secret Key>

La configuration complète du framework est documentée [ici](https://github.com/serverless/serverless/blob/master/docs/providers/aws/guide/credentials.md).

### Identifier le nom du profile AWS

Pour utiliser les informations d'identification AWS configurée dans les paragraphes précédents, il faut que vous connaissiez le nom du profile associé à la paire _Acces Key_, _Secret Key_ que vous souhaitez utiliser. Pour cela, il faut aller voir dans le fichier `.aws/credentials`.

    [profileName1]
    aws_access_key_id=***************
    aws_secret_access_key=***************

    [profileName2]
    aws_access_key_id=***************
    aws_secret_access_key=***************

Dans l'exemple ci-dessus, deux profiles sont configurés, l'un s'appelant `profileName1` et l'autre `profileName2`. Dans la suite de cet article, j'utiliserai en exemple le profile `profileName1`.

## Création du service

Nous voilà maintenant dans le coeur du problème ! Nous allons créer un projet avec le framework Serverless. Ce projet va nous permettre de déployer et de configurer notre fonction Lambda sans même ouvrir la console web AWS.

La création du service, est très simple, elle revient à exécuter la commande suivante.

    serverless create --template aws-python --path Stopinator

![Création du service avec Serverless](/images/2017/05/serverles_create_service.png)

Cette commande va créer le dossier "_Stopinator_" ainsi que deux fichiers :

* handler.py
* serverless.yml

Le premier fichier - `handler.py` - contiendra le code de la fonction Lambda du _stopinator_ et le second - `serverless.yml` - contiendra lui la configuration de cette fonction et tous ses à-côtés. Il faudra en effet configurer l'event _CloudWatch_ qui va déclencher son exécution. Il faudra également qu'il contienne les éléments de configuration _IAM_ pour que notre fonction puisse agir sur les instances EC2.

# Créons notre fonction Lambda

_*Note :*_ _[Le code complet de la fonction est disponible ici](https://raw.githubusercontent.com/MrRaph/article-stopinator/master/handler.py)._

Le coeur de notre fonction Lambda va se situer dans le fichier `handler.py`. Nous allons remplacer la fonction existante dans ce fichier, la fonction `hello` qui s'y trouve a été créée par le framework Serverless lors de la création du service. Nous allons donc remplacer cette fonction `hello`par le code suivant.

    def doStop(event, context):

        response = "doStop"

        for instance in filterInstances(event['ENV'], 'running'):
            instance.stop()

        return response

Cette fonction prend deux paramètres - `event` et `context` - par défaut pour les fonctions Lambda. Elle appelle ensuite la fonction `filterInstances` à laquelle elle passe un paramètre `ENV` qu'elle a elle même reçue via les paramètres de la fonction Lambda et un paramètre contenant l'état souhaiter des instances à traiter. Dans ce cas, les instances sur lesquelles nous souhaitons agir sont celles qui sont en cours d'exécution, nous passons donc l'état `running`. Puis elle boucle sur chaque instance retournée par cette dernière fonction et stoppe l'instance concernée.

Nous allons également ajouter le code de la fonction `filterInstances` à la fin du fichier `handler.py`.


    def filterInstances(env, state):
        filters = [
                {'Name':'tag:Environment', 'Values':[ env ]},
                {'Name': 'instance-state-name', 'Values': [ state ]}
            ]
        allInstances = ec2.instances.filter(Filters=filters)

        return allInstances

Cette fonction va filtrer les instances en fonction de leur environnement et de leur état actuel puis retourner cette liste d'instance.

# La suite au prochain épisode !

 Maintenant nous avons configuré le framework Serverless, nous avons créé notre fonction Lambda, bref, nous sommes prêt à _stopiner_ !! Dans la troisième partie, nous mettrons le tout en musique !


*Note :* Tous les codes présentés dans cette suite d'articles [sont disponible dans ce dépôt GitHub](https://github.com/MrRaph/article-stopinator).
