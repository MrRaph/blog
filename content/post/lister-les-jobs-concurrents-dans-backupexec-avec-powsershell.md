+++
author = "MrRaph_"
image = "https://techan.fr/images/2015/06/powershell-logo.jpg"
draft = false
title = "Lister les jobs concurrents dans BackupExec avec PowserShell"
categories = ["BackupExec","lister les jobs concurrents dans backupexec avec powsershell","Trucs et Astuces"]
tags = ["BackupExec","lister les jobs concurrents dans backupexec avec powsershell","Trucs et Astuces"]
description = ""
slug = "lister-les-jobs-concurrents-dans-backupexec-avec-powsershell"
date = 2015-06-24T16:29:34Z

+++


Afin de corriger des erreurs de backup et d’éviter  d’en avoir plus, nous avons fait le choix de lisser les jobs dans le temps afin d’avoir le moins de concurrence. L’interface de [BackupExec 2012](http://www.symantec.com/backup-exec/) est très pauvre à ce niveau là et je voulais absolument éviter de reporter toutes les planifications à la main dans un fichier.

J’ai donc trouvé une requête et un script PowerShell qui permettent de lister l’historique des jobs sur les X derniers jours. J’ai adapté ces scripts afin d’avoir l’historique des jobs et la concurrence entre ces derniers. Sur chaque ligne de résultat j’ai les informations de l’exécution du job et les jobs qui étaient actifs en même temps que lui.

 


## L’historique des jobs BackupEXEC

Voici la requête que j’ai trouvée sur le site [technet.microsoft.com](https://social.technet.microsoft.com/Forums/scriptcenter/en-US/f00d1c09-6373-415d-ab91-cfb80e94395d/powershell-xml-to-csv-backup-exec-logfiles), elle retourne les jobs qui ont été exécutés dans la fenêtre de temps donnée dans la clause « WHERE » – 7 jours dans cet exemple.

SELECT [JobName] ,[ActualStartTime] ,[ElapsedTimeSeconds] ,[FinalJobStatus] ,[FinalErrorCode] ,[MachineName] ,[TargetName] ,[MediaSetName] ,[TotalDataSizeBytes] ,[TotalNumberOfFiles] ,[TotalNumberOfDirectories] ,[TotalSkippedFiles] ,[TotalCorruptFiles] ,[TotalInUseFiles] FROM [BEDB].[dbo].[JobHistorySummary] WHERE [OriginalStartTime] > dateadd(day,-7, cast(getdate() as date))

Voici le résultat de son exécution dans Management Studio.

<div class="wp-caption aligncenter" id="attachment_1491" style="width: 664px">[![Lister les jobs concurrents dans BackupExec avec PowserShell](https://techan.fr/images/2015/06/BE_listee_des_jobs.jpg)](https://techan.fr/images/2015/06/BE_listee_des_jobs.jpg)L’historique des jobs sur les 7 derniers jours

</div> 

Voici le script PowerShell fourni sur le site [technet.microsoft.com](https://social.technet.microsoft.com/Forums/scriptcenter/en-US/f00d1c09-6373-415d-ab91-cfb80e94395d/powershell-xml-to-csv-backup-exec-logfiles), j’y ai juste ajouté une sortie dans un fichier CSV.

$sqlinstance='<NOM DU SERVEUR WINDOWS>\' $connectionstring="Integrated Security=SSPI;Persist Security Info=False;Initial Catalog=BEDB;Data Source=$sqlinstance" $date=[dateTIme]::Today.AddDays(-7) $query=@" SELECT [JobName] ,[ActualStartTime] ,[EndTime] ,[ElapsedTimeSeconds] ,[FinalJobStatus] ,[FinalErrorCode] ,[MachineName] ,[TargetName] ,[MediaSetName] ,[TotalDataSizeBytes] ,[TotalNumberOfFiles] ,[TotalNumberOfDirectories] ,[TotalSkippedFiles] ,[TotalCorruptFiles] ,[TotalInUseFiles] FROM [BEDB].[dbo].[JobHistorySummary] WHERE [OriginalStartTime] > '$date' ORDER BY [ActualStartTime], [EndTime] "@ function Get-DatabaseData { [CmdletBinding()] param( [string]$connectionString, [string]$query ) $connection = New-Object System.Data.SqlClient.SqlConnection $connection.ConnectionString = $connectionString $command = $connection.CreateCommand() $command.CommandText = $query $adapter = New-Object System.Data.SqlClient.SqlDataAdapter $command $dataset = New-Object System.Data.DataSet [void]$adapter.Fill($dataset) $dataset.Tables[0] } function Out-Excel { param($Path = "C:\temp\BE_Reports\Job_History_$(Get-Date -Format yyyyMMddHHmmss).csv") $input | Export-CSV -Path $Path -UseCulture -Encoding UTF8 -NoTypeInformation Invoke-Item -Path $Path } Get-DatabaseData $connectionstring $query | select machinename, actualstarttime, finaljobstatus, targetname Get-DatabaseData $connectionstring $query | Out-Excel

 

C’est intéressant, mais voyons comment répondre à la problématique …

 


## Lister les jobs concurrents dans BackupExec avec PowserShell

 

Voici donc la requête que j’ai créée à partir de celle que j’ai présentée plus haut.

WITH ALL_JOBS AS ( SELECT [JobHistoryID] ,[JobName] ,[ActualStartTime] ,[EndTime] ,[ElapsedTimeSeconds] ,[FinalJobStatus] ,[FinalErrorCode] ,[MachineName] ,[TargetName] ,[MediaSetName] ,[TotalDataSizeBytes] ,[TotalNumberOfFiles] ,[TotalNumberOfDirectories] ,[TotalSkippedFiles] ,[TotalCorruptFiles] ,[TotalInUseFiles] FROM [BEDB].[dbo].[JobHistorySummary] WHERE [OriginalStartTime] > dateadd(day,-7, cast(getdate() as date)) ) SELECT ALL_JOBS.JobName, ALL_JOBS.ActualStartTime, ALL_JOBS.EndTime, ALL_JOBS.TargetName, ( SELECT JobName + ', ' AS 'data()' FROM [BEDB].[dbo].[JobHistorySummary] WHERE [BEDB].[dbo].[JobHistorySummary].[JobHistoryID] != ALL_JOBS.[JobHistoryID] AND [BEDB].[dbo].[JobHistorySummary].[TargetName] = ALL_JOBS.[TargetName] AND ( ([BEDB].[dbo].[JobHistorySummary].[ActualStartTime] BETWEEN ALL_JOBS.[ActualStartTime] AND ALL_JOBS.[EndTime] ) OR ([BEDB].[dbo].[JobHistorySummary].[EndTime] BETWEEN ALL_JOBS.[ActualStartTime] AND ALL_JOBS.[EndTime] ) ) FOR XML PATH('') ) AS 'Jobs Concurrents' FROM ALL_JOBS ORDER BY ALL_JOBS.ActualStartTime DESC, ALL_JOBS.EndTime DESC

Pour chacun des jobs listés dans l’historique, j’ajoute un champ dans lequel je concatène le nom des jobs qui remplissent les conditions suivantes :

- Ne pas avoir le même ID que le job étudié : un job ne peut pas se concurrencer lui même.
- Avoir la même target que le job étudié : je compare uniquement la concurrence des jobs sur disque entre eux et des jobs sur bandes entre eux.
- Il faut également que la période d’exécution du job « concurrent » empiète sur celle du job étudié.

 

<div class="wp-caption aligncenter" id="attachment_1492" style="width: 664px">[![Lister les jobs concurrents dans BackupExec avec PowserShell](https://techan.fr/images/2015/06/BE_jobs_concurrents.jpg)](https://techan.fr/images/2015/06/BE_jobs_concurrents.jpg)On voit ici que les deux jobs sont concurrents.

</div> 

J’ai adapté le script PowerShell avec cette requête et j’y ai ajouté une sortie vers un fichier CSV afin de me simplifier la lecture des résultats.

 

$sqlinstance='<NOM DU SERVEUR WINDOWS>\' $connectionstring="Integrated Security=SSPI;Persist Security Info=False;Initial Catalog=BEDB;Data Source=$sqlinstance" $date=[dateTIme]::Today.AddDays(-7) $query=@" WITH ALL_JOBS AS ( SELECT [JobHistoryID] ,[JobName] ,[ActualStartTime] ,[EndTime] ,[ElapsedTimeSeconds] ,[FinalJobStatus] ,[FinalErrorCode] ,[MachineName] ,[TargetName] ,[MediaSetName] ,[TotalDataSizeBytes] ,[TotalNumberOfFiles] ,[TotalNumberOfDirectories] ,[TotalSkippedFiles] ,[TotalCorruptFiles] ,[TotalInUseFiles] FROM [BEDB].[dbo].[JobHistorySummary] WHERE [OriginalStartTime] > '$date' ) SELECT ALL_JOBS.JobName, ALL_JOBS.ActualStartTime, ALL_JOBS.EndTime, ALL_JOBS.TargetName, ( SELECT JobName + ', ' AS 'data()' FROM [BEDB].[dbo].[JobHistorySummary] WHERE [BEDB].[dbo].[JobHistorySummary].[JobHistoryID] != ALL_JOBS.[JobHistoryID] AND [BEDB].[dbo].[JobHistorySummary].[TargetName] = ALL_JOBS.[TargetName] AND ( ([BEDB].[dbo].[JobHistorySummary].[ActualStartTime] BETWEEN ALL_JOBS.[ActualStartTime] AND ALL_JOBS.[EndTime] ) OR ([BEDB].[dbo].[JobHistorySummary].[EndTime] BETWEEN ALL_JOBS.[ActualStartTime] AND ALL_JOBS.[EndTime] ) ) FOR XML PATH('') ) AS 'Jobs Concurrents' FROM ALL_JOBS ORDER BY ALL_JOBS.ActualStartTime DESC, ALL_JOBS.EndTime DESC "@ function Get-DatabaseData { [CmdletBinding()] param( [string]$connectionString, [string]$query ) $connection = New-Object System.Data.SqlClient.SqlConnection $connection.ConnectionString = $connectionString $command = $connection.CreateCommand() $command.CommandText = $query $adapter = New-Object System.Data.SqlClient.SqlDataAdapter $command $dataset = New-Object System.Data.DataSet [void]$adapter.Fill($dataset) $dataset.Tables[0] } function Out-Excel { param($Path = "C:\temp\BE_Reports\Job_Concurrents_$(Get-Date -Format yyyyMMddHHmmss).csv") $input | Export-CSV -Path $Path -UseCulture -Encoding UTF8 -NoTypeInformation Invoke-Item -Path $Path } Get-DatabaseData $connectionstring $query | Out-Excel

 

Et voilà, il ne reste plus qu’a analyser et modifier les jobs BackupEXEC.

 


##  Sources :

- Post sur le site [technet.microsoft.com](https://social.technet.microsoft.com/Forums/scriptcenter/en-US/f00d1c09-6373-415d-ab91-cfb80e94395d/powershell-xml-to-csv-backup-exec-logfiles)
- Sur [blogs.technet.com](http://blogs.technet.com) : [PowerShell and Excel: Fast, Safe, and Reliable](http://blogs.technet.com/b/heyscriptingguy/archive/2014/01/10/powershell-and-excel-fast-safe-and-reliable.aspx)


