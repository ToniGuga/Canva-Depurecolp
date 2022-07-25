##################################################
####### Installazione ambiente di sviluppo #######
##################################################

Per installare tailwind e tutti i componenti necessari per sviluppare usare nel terminale di VSCODE. Per aprire il Terminale di VSCODE usare i tasti CTRL+ò (CMD+ò in Mac).

scrivere "npm install" e premere invio

##########################
####### FTP Sync #########
##########################

Per avviare la syncronizzazione FTP con il server di sviluppo devi aver installato il plugin FTP-SYNC per VSCODE,
modificare il file .vscode/ftp-sync.json e inserire i dati del server ftp (remotePath, host, username, password)

Premere i tasti "CTRL + SHIT + P"

scrivere "FTP-sync: Sync Local to Remote" e premere invio, scegliere tipo di syncronizzazione "Full Sync".

Cartella file di configurazione: .vscode
File di configurazione: ftp-sync.json
File sample DEV: ftp-sync-DEV.json
File sample STAGE: ftp-sync-STAGE.json

Se vuoi uplodare su STAGE copiare il contenuto di ftp-sync-STAGE.json in ftp-sync.json e riavviare VS Code
Se vuoi uplodare su DEV copiare il contenuto di ftp-sync-DEV.json in ftp-sync.json e riavviare VS Code

############################################
###### FTP Deploy (non usare ancora) #######
############################################

Per configurare il Deploy su server di produzione (Go Live), modificare il file ftp-deploy.js e inserire i dati del server (remoteRoot, host, user, password). Per avviare il trasferimento eseguiti il seguente comando sul terminale:

npm run deploy

############################################
###### Ambienti di sviluppo CSS e JS #######
############################################

Esistono due ambienti di sviluppo per quanto riguarda la parte css e js

1) development
	1.1 comando terminale: npm run development (esegue build css + js generando i rispettivi file minimizzati)
	1.2 comando terminale: npm run development:js (esegue build js generando il rispettivo file minimizzato)
	1.3 comando terminale: npm run development:css (esegue build css generando il rispettivo file minimizzato)
2) production
	2.1 comando terminale: npm run production (esegue build css + js + purge generando i rispettivi file minimizzati)

Il secondo esegue il purge delle classi di Taiwind per otimmizzare il css del front-end.

I file non compilati CSS e JS si trovano dentro la cartella PROJECT/SRC/CSS O PROJECT/SRC/JS



