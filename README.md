# Shifumi – Solution Web  
**Jeu Pierre-Feuille-Ciseaux-Lézard-Spock avec Base de Données**

![Statut](https://img.shields.io/badge/Statut-Terminé-brightgreen)
![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange)
![MariaDB](https://img.shields.io/badge/Database-MariaDB-blue)
![HTML](https://img.shields.io/badge/HTML-HTML5-E34F26)
![CSS](https://img.shields.io/badge/CSS-3-1572B6)

## Contexte du projet

Ce projet a été réalisé dans le cadre d’un **projet pédagogique de développement web et base de données**.  
L’objectif est de créer une **application web dynamique** permettant de jouer au jeu **Shifumi (Pierre-Feuille-Ciseaux-Lézard-Spock)** tout en enregistrant les résultats dans une base de données.

Le projet met en œuvre :
- PHP
- HTML & CSS
- SQL (MySQL)
- Connexion PDO


## Objectifs

- Permettre à un joueur de jouer contre l’ordinateur  
- Enregistrer chaque partie jouée  
- Afficher l’historique des parties  
- Mettre en pratique :
  - PHP procédural
  - requêtes SQL
  - formulaires HTML
  - base de données relationnelle

###  Jeu
- Choix du joueur :
  - Pierre  
  - Feuille  
  - Ciseaux  
  - Lézard  
  - Spock  
- Choix aléatoire de l’ordinateur  
- Détermination du résultat :
  - Victoire
  - Défaite
  - Égalité


###  Historique
- Enregistrement de chaque partie :
  - choix du joueur
  - choix de l’ordinateur
  - résultat
- Affichage des parties précédentes


## Base de données

La base de données stocke l’historique des parties.


###  Script SQL
Le fichier suivant permet de créer la base et les tables : shifumi.sql


###  Données stockées
Chaque partie contient :
- id
- choix du joueur
- choix de l’ordinateur
- résultat
- date


## Technologies utilisées

| Frontend | HTML, CSS |
| Backend | PHP |
| Base de données | MySQL |
| Serveur local | WAMP  |


## Structure du projet


├── index.php # Page principale du jeu
├── login.php # Connexion à la base de données
├── style.css # Design du site
├── shifumi.sql # Base de données
└── README.md


### Configurer la connexion

Dans `login.php`, vérifier ou modifier :

```php
$host = "localhost";
$dbname = "shifumi";
$user = "root";
$password = "";

Lancer le site dans un navigateur :

http://localhost/shifumi/index.php

