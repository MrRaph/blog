+++
slug = "migrer-gitlab-dans-un-container-docker"
draft = false
date = 2016-08-29T14:19:33Z
image = "https://about.gitlab.com/images/press/logo/wm_no_bg.svg"
description = "Voici une procédure expliquant comment migrer un GitLab installé en dur sur une machine dans un container Docker."
categories = ["Docker","GitLab","Migrer GitLab dans Docker","docker-compose","Trucs et Astuces","Linux"]
tags = ["Docker","GitLab","Migrer GitLab dans Docker","docker-compose","Trucs et Astuces","Linux"]
title = "Migrer GitLab dans un container Docker"
author = "MrRaph_"

+++

Depuis quelques temps déjà tous les services que j'auto-héberge sont "Dockerisés", tous sauf un ... et pas des moindres ... Le caillou dans ma sandale était mon [GitLab](https://about.gitlab.com/) qui restait hébergé sur une machine qui lui était dédiée. Un beau jour, j'ai pris mon courage à deux mains et j'ai migré ce petit chenapant dans mon infrastructure Docker !

[Une image officielle très bien faite](https://hub.docker.com/r/gitlab/gitlab-ce/) exite déjà depuis un moment pour GitLab, autant en profiter et économiser une machine ! :-)

Voici la manière dont j'ai procédé pour effectuer ce changement.

## Sauvegarder GitLab

La première étape est de sauvegarder la configuration actuelle du GitLab. Ceci se fait simplement avec la commande ci-dessous.

    sh -c 'umask 0077; tar -cf $(date "+etc-gitlab-%s.tar") -C / etc/gitlab'

Lorsque la configuration est sauvegardée, c'est au tour de tout le reste ! Pour cela encore, c'est très simple, GitLab fourni tout ce qu'il faut pour ! ;-)

    gitlab-rake gitlab:backup:create RAILS_ENV=production

Vous voilà maintenant en possession de vos sauvegardes, que vous prendrez soin de transferer vers l'hôte Docker qui va accueillir GitLab.

## Préparation du fichier docker-compose

Nous allons utiliser `docker-compose` pour créer notre GitLab, ceci simplifiera grandement les tâches d'administration - notamment ses mises à jour !

Voici le fichier `docker-compose.yml` que j'ai utilisé, adaptez le suivant votre environnement, en particulier le FQDN, le montages et le réseau.

    version: '2'

    services:
     gitlab:
   
     image: gitlab/gitlab-ce
   
     restart: always
   
     container_name: gitlab
   
     volumes:
      - /data/gitlab/config:/etc/gitlab
      - /etc/letsencrypt:/etc/letsencrypt
      - /data/gitlab/logs:/var/log/gitlab
      - /data/gitlab/data:/var/opt/gitlab
      - /data/gitlab/logs/reconfigure:/var/log/gitlab/reconfigure
    ports:
      - "2222:22"
    environment:
      - VIRTUAL_HOST=git.example.com
      - GITLAB_OMNIBUS_CONFIG="external_url 'http://git.example.com'"
    networks:
      - web
    networks:
      web:
     external:
       name: web

On démarre un container GitLab avec la commande suivante :

    docker-compose up -d


## Migrons !

Voici venu le temps de la migration ! La première étape est de copier le fichier du backup de GitLab dans le container.

`docker cp /tmp/1465464740_gitlab_backup.tar gitlab:/var/opt/gitlab/backups`

Il faut ensuite remettre les droits d'aplomb sur le dossier qui contient les backups.

    docker exec gitlab chmod -R 775 /var/opt/gitlab/backups

On arrête quelques services de GitLab pour être tranquile.

    docker exec gitlab gitlab-ctl stop unicorn
    docker exec gitlab gitlab-ctl stop sidekiq

Puis on lance une vérification.

    docker exec gitlab gitlab-rake gitlab:check SANITIZE=true

Et enfin on restaure le backup, aller vous chercher un café, ça peut durer très longtemps !

    docker exec gitlab gitlab-rake gitlab:backup:restore BACKUP=1465464740

# Vérification post restauration

La restauration est terminée ?!? Il est temps de faire quelques tâches post-restauration. La première est de changer les droits sur le répertoire `/var/opt/gitlab/gitlab-rails/uploads`.

    docker exec gitlab chown -R git /var/opt/gitlab/gitlab-rails/uploads

Il ne reste ensuite qu'a reconfigurer et à démarrer GitLab !

    docker exec gitlab gitlab-ctl reconfigure
    docker exec gitlab gitlab-ctl start

Et voilà, votre GitLab devrait fonctionner comme l'ancien mais dans un container !! :-)

## En bonus, la procédure de mise à jour !

Une nouvelle version de l'image GitLab est disponible sur le Docker Hub ? Voici comment mettre à jour votre installation !

Dans un premier temps, récupérez la nouvelle image avec `docker-compose`.

    docker-compose pull

Puis faites lui recréer votre/vos container(s) !

    dokcer-compose up -d

GitLab est à jour ! :) 