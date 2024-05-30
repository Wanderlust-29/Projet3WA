# Checklist pour le projet

## 1 : Installer et configurer son environnement de travail

### Est-ce que je peux montrer un environnement de travail complet et adaptable ?

#### Pour le PHP

- [x] WAMP, XAMP, MAMP qui fonctionne

OU

- [ ] Environnement avec une stack docker qui fonctionne

OU

- [ ] J'ai installé une stack LAMP (Linux, Apache, MySQL, PHP) directement sur mon poste

#### Pour React

- [ ] J'ai bien Node et nom d'installés sur mon post

#### Mon IDE

- [x] Je peux installer et configurer un IDE (faites une liste des extensions que vous utilisez)


#### Pour le versionning

- [x] Git est installé et fonctionne sur mon poste
- [x] Git fonctionne depuis mon IDE

#### Pour le déploiement

- [x] FileZilla est installé sur mon poste
- [x] Je sais comment envoyer des fichiers sur un serveur distant

#### Évolutivité

- [ ] Je sais comment faire pour utiliser une version différente de PHP sur mon poste
- [ ] Je sais comment faire pour utiliser une version différente de MySQL sur mon poste

#### Veille technologique

- [ ] Je sais où trouver les infos sur les nouveautés de PHP
- [ ] Je sais où trouver les infos sur les nouveautés de MySQL
- [ ] Je sais où trouver les infos sur les nouveautés HTML / CSS
- [ ] Je sais où trouver les infos sur les nouveautés de JavaScript
- [ ] Je sais où trouver les infos sur les nouveautés de React
- [ ] Je sais où trouver les infos sur les nouveautés de mon IDE

## 2 : Maquetter des interfaces utilisateur web ou web mobile

### Design

- [ ] Mes maquettes respectent la charte graphique
- [ ] Mes maquettes répondent aux exigences du Cahier des Charges
- [ ] Je peux montrer l'enchainement entre mes pages

### Accessibilité

- [ ] Mes maquettes tiennent compte des règles d'accessibilité :
  - [ ] Contrastes
  - [ ] Tailles des polices

## 3 : Réaliser des interface utilisateur statiques web ou web mobile

### Général

- [ ] Mes intégrations respectent mes maquettes
- [ ] Mon site peut être indexé par les moteurs de recherche
- [ ] Mes balises SEO sont bien remplies sur les pages publiques
- [ ] Mes intégrations passent la validation W3C
- [ ] Mes intégrations utilisent au maximum les balises sémantiques appropriées

### Accessibilité

- [ ] Toutes mes balises `<img>` ont des `alt` réellement descriptifs
- [ ] Tous mes `<input>` ont des `<label>`
- [ ] Toutes mes `<sections>`, `<div>`, `<article>` et `<nav>` ont des titres (je peux les rendre lisibles uniquement par les screen readers)
- [ ] Je respecte les règlementations en matière de contrastes
- [ ] Mes polices sont de tailles suffisantes pour être lisibles

### Sécurité

- [ ] Mes formulaires utilisent le type d'`<input>` approprié pour la saisie des informations (email, password, ...)
- [ ] Mes formulaires effectuent une première validation des saisies lorsque cela est possible (limite de caractères, patterns, required=true, ...)

### Responsive

- [ ] Mes intégrations s'adaptent à la taille de l'écran
  - [ ] Desktop
  - [ ] Tablette
  - [ ] Mobile
- [ ] Mes intégrations s'adaptent à la disposition de l'écran
  - [ ] Portrait
  - [ ] Paysage

## 4 : Développer la partie dynamique des interface utilisateur web ou web mobile

### Utilisation d'asynchrone

- [X] J'utilise au moins une fois `fetch` pour mettre à jour une information sans recharger ma page.
- [X] Je sais convertir du JSON pour l'utiliser dans mon code JavaScript

### Utilisation d'API externes

- [X] Je sais mettre en place et appeler une API externe depuis mon JavaScript (exemple le plus classique : une carte pour localiser une entreprise)

### Écoute des évenements

- [X] J'ai mis en place une écoute et un traitement des évenements du DOM (exemple le plus classique : la soumission d'un formulaire)

### UX

- [X] J'ai mis en place une expérience utilisateur adaptée (par exemple sur le traitement de mes formulaires)

### Tests

- [X] Je peux citer le nom d'une librairie permettant de faire des tests unitaires en JavaScript (Jest)

## 5 : Mettre en place une base de données relationnelle

### Implémentation

- [ ] L'implémentation de ma base de données est conforme à mon modèle de données
- [X] Si mon implémentation est différente, je peux le justifier et j'ai mon nouveau modèle de données disponible

### Conventions

- [X] Mes noms de tables et de colonnes sont en anglais
- [X] Mes noms de tables et de colonnes sont en snake case (tout en minucule et des \_ à la place des espaces)
- [X] Mes colonnes utilisent les types appropriés (int, varchar, datetime, ...)

### Sécurité

- [X] Les mots de passe ne sont pas stockés en clair dans ma base de données

### Relations

- [x] J'ai moins une relation simple dans ma base de données avec sa foreign key
- [x] J'ai au mons une relation complexe avec table de liaison dans ma base de données

### Sauvegarde et restauration

- [X] J'ai un jeu de données de test complet qui me permet de réinitialiser ma base
- [X] Je sais comment sauvegarder et restaurer ma base de données

### Requêtes

- [X] J'ai au moins un exemple de SELECT \*
- [X] J'ai au moins un exemple de SELECT WHERE
- [X] J'ai au moins un exemple de JOIN
- [X] J'ai au moins un exemple de INSERT INTO
- [X] J'ai au moins un exemple de UPDATE
- [X] J'ai au moins un exemple de DELETE

## 6 : Développer des composants d’accès aux données SQL et NoSQL

### NoSQL

- [X] J'ai bien à disposition les requêtes de mon évaluation de MongoDB

### SQL

#### Models

- [X] Chaque table de ma base de données qui n'est pas une table de liaison a un Model Correspondant
- [X] Mes models reprennent bien les colonnes de mes tables ainsi que leur type et si elles peuvent être nulles ou non
- [X] Les relations entre mes tables sont représentées par une composition dans ma POO
  - [X] Les relations simple : en attribut, la classe correspondante
  - [x] Les relations complexes : en attribut, un array de la classe correspondante

#### Gestion d'erreur

- [x] Mes managers gèrent le cas où ma base de données ne retourne rien et n'affiche pas d'erreur
- [x] Mon AbstractManager gère le cas où mes informations de connexion ne fonctionnent pas et n'affiche pas d'erreur
- [x] Les informations de connexion à ma base de données ne sont pas versionnées (j'utilise un .env non versionné)

#### Managers

- [x] Toutes les requêtes de ma base de données sont dans mes managers
- [x] Mes managers se chargent d'hydrater mes modèles

## 7 : Développer des composants métier coté serveur

### Implémentation

- [ ] Les comportements sont conformes au cahier des charges
- [ ] J'ai réalisé des tests unitaires pour au moins une de mes classes

### Sécurité

- [X] J'ai sécurisé les accès aux pages privées
- [X] Je me protège des failles XSS
- [X] Je me protège des failles CSRF
- [X] Je me protège des injections SQL
- [X] J'exige une authentification forte

### Qualité du code

- [ ] Je respecte les bonnes pratique de POO
  - [ ] Classes avec attributs private et methodes public
  - [ ] Classes abstraites et héritage
- [ ] La seule chose qui n'est pas une classe c'est mon index.php, mes fichiers de configuration et mes templates
- [ ] Mon code source est commenté, en anglais
- [ ] Toutes mes méthodes sont type hintées

## 8 : Documenter le déploiement d’une application dynamique web ou web mobile

- [ ] Dans le README de mon repository j'explique comment installer mon projet
- [ ] Filezilla est installé sur mon poste et je sais l'utiliser
