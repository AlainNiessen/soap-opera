## 1) Symfony

Prérequis à l’installation de Symfony:
1. PHP 7.2.5 ou >
2. Composer: https://getcomposer.org/download/

Installer Symfony:
https://symfony.com/download

Pour lancer le serveur Symfony:
Veuillez ouvrir la console à la racine du projet et introduire: 

**symfony server:start**

## 2) Composer

Liste des composer installés: composer.json

Pour pouvoir utiliser les composer, veuillez ouvrir la console à la racine du projet et introduire: 

**composer install**

Cette commande va vous installer un dossier qui s'appelle 'vendor' qui vous permet d'utiliser les composer listé dans composer.json.

## 3) Webpack Encore et Yarn

Installer Node.js: https://nodejs.org/en/

Installer Yarn: 
Il est recommandé d'installer Yarn à travers de npm package manager, qui est inclus dans l'installation Node.js.
Veuillez ouvrir la console à la racine du projet et introduire: 

**npm install --global yarn**

Liste des dépendances: packages.json

Pour pouvoir utiliser les dépendances, veuillez ouvrir la console à la racine du projet et introduire: 

**yarn install**

Cette commande va vous installer un dossier qui s'appelle 'node-modules' qui vous permet d'utiliser les dépendances dans packages.json.

## 4) Compilation SCSS -> CSS

Pour compiler le SCSS en CSS, ouvrir la console à la racine de votre projet et introduire: 

**yarn run encore dev --watch.**

--watch vous permet que la compilation se fait automatiquement après chaque modification en SCSS. Sinon vous devriez introduire 'yarn run encore dev' après chaque modification

La commande **yarn run encore prod** va vous compiler un CSS et JS minifié pour la production.

## 5) Base de données

### a) Lier la abse de données avec le projet

Les informations de connexion à la base de données sont stockées dans une variable d'environnement appelée DATABASE_URL. Pour le développement, vous pouvez trouver et personnaliser ceci dans **.env** :

1. Nom utilisateur
2. Mot de passe
3. nom de la base de données

**DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"**

### b) Construction de la base de données

Une fois la base de données créée et connectée au projet via le fichier .env, la base de données peut maintenant recevoir sa structure de table. Ensuite, exécutez dans la console la migration pour ajouter la table à votre base de données :

**php bin/console doctrine:migrations:migrate**

Le dossier migrations contient un certain nombre de migrations qui sont implémentées par cette commande et construisent ainsi automatiquement la structure de la base de données

## 6) Mail

Pour pouvoir envoyer des mails depuis le projet, il faut aller dans le fichier **.env** et ajouter des informations au point MAILER_DNS:

1. son adresse mail
2. son mot de passe
3. adresse host du fournisseur (ou du serveur)
4. le port

**MAILER_DSN=smtp://user:pass@smtp.example.com:port**

