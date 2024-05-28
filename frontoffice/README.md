# FastCheckout V1 Frontent Application Reactnative
## 💻 Developement

> Assurez-vous que la version de votre node est v18.15.0 et npm v9.6.1

#### 1.🪂 Clôner le Projet

```bash
git clone git@rendu-git.etna-alternance.net:module-8898/activity-48680/fastCheckout.git
cd frontoffice
```

#### 2. Installez le expo cli globalement

```bash
npm install -g expo-cli
```

Expo

> Expo constitue un ensemble de librairies, de services et d’outils tournant autour de React Native. On va notamment retrouver expo-cli qui permet de générer un projet React Native avec la surcouche Expo.
> Avec Expo, vous allez pouvoir créer et déployer une application iOS et Android sans voir la couche native. Cependant, même s’il est spacieux, vous restez dans l’enclos prévu par Expo. Les versions de React Native sont fixées dans les versions d’Expo et les modules et corrections natifs sont limités (Librairies natives non disponibles, celles qui sont disponibles doivent être mises à jour en même temps qu’Expo,…).

#### 3. ⌛ Installez les dépendances du projet

```bash
npm install
```

#### 4. Lancer le serveur de développement

```bash
npx expo start
```

ou
npm start
```

#🧑‍💻 Pour le developpeur Front-end voici l'exemple a suivre:

## 🚦 Fonctionnement

1. Les `développeurs` créent une branche de `front/feat-Id-Ticket-Trello-*` à partir du dernier commit de `main`.
2. Les `développeurs` implémentent la nouvelle fonctionnalité en un ou plusieurs commits puis merge leurs apports sur `main`.

## 🎓 References

#### 1. Create project

```bash
expo init FastCheckout
```

> - [Plus d'information](https://reactnative.dev/docs/environment-setup)

#### 2. Ajouter un Scanner

```bash
expo install expo-barcode-scanner
```

> - [Voir la suite](https://docs.expo.dev/versions/latest/sdk/bar-code-scanner/)

#### 3. Connexion api

> - La plupart des applications Web et mobiles stockent des données dans le cloud et communiquent avec un service. Par exemple, un service qui obtient la météo actuelle dans votre région ou renvoie une liste de GIF basée sur un terme de recherche.

Les bases de données et les services Web ont ce qu'on appelle une API (Application Programming Interface) que les applications peuvent utiliser pour communiquer via une URL. En d'autres termes, une API permet aux applications de récupérer ou d'envoyer des données vers et depuis des bases de données ou des services Web.

Les applications utilisent des requêtes HTTP, par exemple, GET, POST et PUT, pour communiquer avec les API. En bref, Axios permet à nos applications d'exécuter facilement ces commandes.

##### 3.1 Installer le paquet axios

> Utilisation d'Axios avec React Native pour gérer les demandes d'API

```bash
npm i axios --save
```

> - [installation](https://www.npmjs.com/package/react-native-axios)
> - [documentation sur axios](https://axios-http.com/fr/docs/intro)

##### 4 Barre de Navigation

> - [Installation de la bibliothèque](https://reactnavigation.org/docs/hello-react-navigation)
> - [Bottom Tabs Navigator](https://reactnavigation.org/docs/bottom-tab-navigator/)
> - [Icone](https://ionic.io/ionicons)
