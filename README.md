# FastCheckout 

FastCheckout est une application permettant à des utilisateurs de pouvoir effectuer leurs achats en magasin, sans pour autant passer par la caisse.

## Outils nécessaires / préinstallé

- Docker

## Installation Projet

### 1- Clôner le Projet

```bash
git clone git@rendu-git.etna-alternance.net:module-8898/activity-48680/fastCheckout.git
```

### 2- .env

- vérifier que le .env existe : dans group-XXXX/backoffice/backoffice/.env

- sinon
```bash
cd backoffice/backoffice
```
```bash
touch .env
```

```bash
cp.env.exemple .env
```

### 2- Docker

### Windows:
Lancer Docker desktop

### Linux:
```bash
docker compose up -d --build
```

### 3- Déployer l'application localement

dans group-XXXX/backoffice

### 3.a Connexion au conteneur en bash

```bash
docker exec -it apache bash
```
vous êtes maintenant sur l'invitation de commande apache bash (vous etes dans le conteneur)
### Installer les dépendances

```bash
	composer install
```
-si vous avez le pb: 
"Executing script assets:install public [KO]
[KO]
Script assets:install %PUBLIC_DIR% returned with error code 1"

-solution: https://stackoverflow.com/questions/57393132/error-code-1-cacheclear-during-composer-require

### 3-b Installer les assets

```bash
	php bin/console assets:install
```

### Installer les migrations (BDD)
Attention: avant d'installer les migrations verifier que le backoffice est lancé sur docker

```bash
	php bin/console doctrine:migrations:migrate
```

### 3-c Lancer le serveur Symfony

```bash
	symfony server:start
```
il suffit de le lancer qu'une seule fois pour tout le reste du temps



### 3-d Crée un utilisateur ADMIN

- Allez sur PgAdmin (localhost::8081 ou http://127.0.0.1:8081/), 
- Connectez vous via l'identifiant: admin@admin.com et le mot de passe: root
- Cliquez sur "Add new server"
- Entrez les configurations suivantes: 
Hostname/Adress : postgres | 
Port : 5432 | 
Maintenance Database : backoffice | 
Username : elyes | 
Password : 123456
- Sur la gauche au niveau de Browser aller dans servers/postgres/Databases/backoffice/schemas/public/tables/user 
- clique droit sur user
- Scripts > INSERT Script
- Copier le script
```bash
INSERT INTO public."user"(
	id, email, roles, password)
	VALUES (1, 'admin@admin.fr', '["ROLE_USER","ROLE_ADMIN","ROLE_SUPERADMIN"]', '$2y$13$JceIqUxMcfOFV5Ub2xbU9u2nRPxxqrYBJefJ5M/fB6ripPrh20XDO');
```

### 3-e Télécharger les fixtures
```bash
php bin/console doctrine:fixtures:load
```

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
### Mettre à jour le schéma de BDD
```bash
php bin/console doctrine:migrations:execute
``` 
### Si MàJ à jour le schéma de BDD beug alors :
```bash
php bin/console doctrine:database:drop --force
``` 
```bash
php bin/console doctrine:database:create
``` 
```bash
php bin/console doctrine:migrations:migrate
``` 
```bash
php bin/console doctrine:fixtures:load
```

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
### Nettoyer le cache
```bash
php bin/console ca:cl
``` 

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
### Dans le cas où l'on souhaite supprimer la BDD (seulement en cas de conflit)
```bash
php bin/console doctrine:database:drop --force
```

------------------------------------------------------------------------------------------------------------------------------------------------------------------------
### Dans le cas où l'on souhaite créer la BDD

```bash
php bin/console doctrine:database:create
```