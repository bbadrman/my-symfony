# create symfony project #

### Create a Mini Game With Docker, PHP5, Nginx & MariaDB ###

### pour demarer serveur php en mode public puisque le serveur savent que le fichier index sur public 
php -S localhost:8080 - t public 

### routing
 necessary to install routing  whith cmd:
    $ composer require symfony/routing

## probleme Cette page ne fonctionne pasImpossible de traiter cette demande via localhost à l'heure actuelle.
HTTP ERROR 500

soulition: http://localhost

### Ce site est inaccessiblelocalhost a mis fin à la connexion de manière inattendue.
Voici quelques conseils :

Vérifier la connexion
Vérifier le proxy et le pare-feu
ERR_CONNECTION_CLOSED

soulition :  taper ps -ef | grep php
  apres la liste en trouve dr       
   7212    6914  0 20:52 pts/0    00:00:00 php -S localhost:8080 - t public
et taper kill -9 7212
