# Gene Sequencer

## Commandes utiles

```
# Reconstruire l'image : la base de données sqlite a été ajouté
docker compose build

# Créer et entrer dans un shell dans un conteneur
docker compose run --rm env-php bash

# Installer les dépendances avec composer (dans le sheel de l'environnement)
/app # composer install

# Exécuter l’application 
/app # php app.php "TGCA" "ACTA"

# Exécuter les tests en ligne de commande
/app # ./vendor/bin/phpunit
```