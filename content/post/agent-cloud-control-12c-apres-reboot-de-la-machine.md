+++
categories = ["Cloud Control","cloud control 12c agent down","Oracle","Survival Guide"]
image = "https://techan.fr/wp-content/uploads/2014/10/SQL_term.png"
slug = "agent-cloud-control-12c-apres-reboot-de-la-machine"
date = 2014-11-26T18:31:30Z
author = "MrRaph_"
tags = ["Cloud Control","cloud control 12c agent down","Oracle","Survival Guide"]
description = ""
draft = false
title = "Agent Cloud Control 12c down après reboot de la machine"

+++


Après une action sur une VM Oracle Linux hébergeant deux bases Oracle, j’ai eu la mauvaise surprise de voir que l’agent Cloud Control 12c a bien redémarrer mais était vu comme down dans le Cloud Control. Je dois avouer que j’ai pas mal tourné en rond que cette flèche rouge m’a pas mal irrité …  
  
[![Agent Cloud Control 12c down](https://techan.fr/wp-content/uploads/2014/11/agent_recalcitrant1.png)](https://techan.fr/wp-content/uploads/2014/11/agent_recalcitrant1.png)

 

Après quelques recherches sur Google, et presque en déspeoir de cause, j’ai testé unedes dernières marche à suivre pour corriger l’agent Cloud Control 12c down.

Cette marche à suivre se trouve sur le site [community.oracle.com](https://community.oracle.com/thread/2429559?start=0&tstart=0), la réposne de « washington_peres ».

 

[![forcer_agent_recalcitrant](https://techan.fr/wp-content/uploads/2014/11/forcer_agent_recalcitrant.png)](https://techan.fr/wp-content/uploads/2014/11/forcer_agent_recalcitrant.png)J’ai donc appliqué cette procédure.

**<span style="text-decoration: underline;">Note :</span>** Il faut se placer dans le répertoire « $AGENT_HOME/bin » pour lancer ces commandes.

[oracle@xxxxxx bin](ORCL)$ ./emctl stop agent Oracle Enterprise Manager Cloud Control 12c Release 3 Copyright (c) 1996, 2013 Oracle Corporation. All rights reserved. Stopping agent ..... stopped. [oracle@xxxxxx bin](ORCL)$ ./emctl secure agent Oracle Enterprise Manager Cloud Control 12c Release 3 Copyright (c) 1996, 2013 Oracle Corporation. All rights reserved. Agent is already stopped... Done. Securing agent... Started. Enter Agent Registration Password : EMD gensudoprops completed successfully Securing agent... Successful. [oracle@xxxxxx bin](ORCL)$ ./emctl start agent Oracle Enterprise Manager Cloud Control 12c Release 3 Copyright (c) 1996, 2013 Oracle Corporation. All rights reserved. Starting agent ............... started. [oracle@xxxxxx bin](ORCL)$ ./emctl status agent Oracle Enterprise Manager Cloud Control 12c Release 3 Copyright (c) 1996, 2013 Oracle Corporation. All rights reserved. --------------------------------------------------------------- Agent Version : 12.1.0.3.0 OMS Version : 12.1.0.3.0 Protocol Version : 12.1.0.1.0 Agent Home : /u01/oracle/product/em_agent/agent_inst Agent Binaries : /u01/oracle/product/em_agent/core/12.1.0.3.0 Agent Process ID : 11371 Parent Process ID : 11315 Agent URL : https://xxxxxx.xxxxx.fr:3872/emd/main/ Repository URL : https://xxxxxx.xxxxx.fr:4904/empbs/upload Started at : 2014-11-26 17:09:56 Started by user : oracle Last Reload : (none) Last successful upload : 2014-11-26 17:10:05 Last attempted upload : 2014-11-26 17:10:05 Total Megabytes of XML files uploaded so far : 0,02 Number of XML files pending upload : 1 Size of XML files pending upload(MB) : 0 Available disk space on upload filesystem : 70,99 % Collection Status : Collections enabled Heartbeat Status : Ok Last attempted heartbeat to OMS : 2014-11-26 17:10:03 Last successful heartbeat to OMS : 2014-11-26 17:10:03 Next scheduled heartbeat to OMS : 2014-11-26 17:11:04 --------------------------------------------------------------- Agent is Running and Ready [oracle@xxxxxx bin](ORCL)$ ./emctl config agent addinternaltargets Oracle Enterprise Manager Cloud Control 12c Release 3 Copyright (c) 1996, 2013 Oracle Corporation. All rights reserved. [oracle@xxxxxx bin](ORCL)$

 

Une fois ces  actions réalisées, la flèche repasse miraculeusement au vert !! ![:)](http://blog.techan.fr/wp-includes/images/smilies/simple-smile.png)

 

[![agent_recalcitrant_up](https://techan.fr/wp-content/uploads/2014/11/agent_recalcitrant_up.png)](https://techan.fr/wp-content/uploads/2014/11/agent_recalcitrant_up.png)

 

 


