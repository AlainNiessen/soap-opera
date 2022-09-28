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

### a) Lier la base de données avec le projet

Les informations de connexion à la base de données sont stockées dans une variable d'environnement appelée DATABASE_URL. Vous pouvez trouver et personnaliser ceci dans **.env** :

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

## 7) Authentification avec Google

### a) Installation et configuration

Installation du bundle: **composer require knpuniversity/oauth2-client-bundle**<br>
Télécharger la bibliothèque client Google: **composer require league/oauth2-google**<br>

Configurer le fournisseur:<br>

**config/packages/knpu_oauth2_client.yaml**

knpu_oauth2_client:<br>
    clients:<br>
        google:<br>
            # activation du type GOOGLE<br>
            type: google<br>
            # variables globales définies dans le fichier .env<br>
            client_id: '%env(OAUTH_GOOGLE_CLIENT_ID)%'<br>
            client_secret: '%env(OAUTH_GOOGLE_CLIENT_SECRET)%'<br>
            # nom du redirect route<br>
            redirect_route: connect_google_check<br>
            redirect_params: {}<br>

**.env**

OAUTH_GOOGLE_CLIENT_ID="XXX"<br>
OAUTH_GOOGLE_CLIENT_SECRET="XXX"<br>

### b) Création projet et récupération des identifiants

Pour pouvoir définir le **OAUTH_GOOGLE_CLIENT_ID** et **OAUTH_GOOGLE_CLIENT_SECRET**, il faut créer un compte sur **https://console.cloud.google.com/** et y créer un projet. Aprés avoir créer un projet, on réçoit des identifiants pour ce projet. Les identifiants seront défini par aprés dans le fichier **.env**.

## 8) Les paiements via Stripe

Le traitement des paiements se font dans le PaimentController et le traitement est déjà défini (par exemple les routes de redirection en cas d'un paiement réussi). Pour garantir le bon fonctionnement, il faut définir une clé dans le fichier **.env**.

**STRIPE_SK_TEST=XXX**

C'est une clé pour pouvoir effectuer des paiements en mode de test. Pour récevoir ce clé, il faut créer un compte sur le site de Stripe en tant que développeur et y créer un projet. La clé sera réprésentant pour ce projet et doit être défini dans le fichier **.env**. Pour passer à des vrais paiement, il faut activer le projet et sortir du mode de test.
