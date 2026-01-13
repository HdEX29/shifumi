-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 13 jan. 2026 à 12:27
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+01:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de données : `shifumi`
--

-- --------------------------------------------------------

--
-- Structure de la table `classement`
--

DROP TABLE IF EXISTS `classement`;

CREATE TABLE IF NOT EXISTS `classement` (
    `id` int NOT NULL AUTO_INCREMENT,
    `joueurs` varchar(100) NOT NULL,
    `games` int NOT NULL DEFAULT '0',
    `gagnants` int NOT NULL DEFAULT '0',
    `perdants` int NOT NULL DEFAULT '0',
    `mis_a_jour` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `joueurs` (`joueurs`)
) ENGINE = InnoDB AUTO_INCREMENT = 237 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `classement`
--

INSERT INTO
    `classement` (
        `id`,
        `joueurs`,
        `games`,
        `gagnants`,
        `perdants`,
        `mis_a_jour`
    )
VALUES (
        1,
        'invite',
        171,
        33,
        37,
        '2025-12-17 12:47:48'
    ),
    (
        120,
        'Valdes Gabriela',
        42,
        8,
        5,
        '2025-12-17 08:16:07'
    ),
    (
        203,
        'Dorian',
        23,
        9,
        7,
        '2025-12-17 08:20:36'
    );

-- --------------------------------------------------------

--
-- Structure de la table `scores`
--

DROP TABLE IF EXISTS `scores`;

CREATE TABLE IF NOT EXISTS `scores` (
    `Id_scores` int NOT NULL AUTO_INCREMENT,
    `nom_utilisateur` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `mot_de_passe` varchar(30) NOT NULL,
    `nombre_partie` bigint DEFAULT '0',
    `victoire_joueur` bigint DEFAULT '0',
    `ip_address` varchar(45) NOT NULL,
    `timestamp_` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`Id_scores`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `scores`
--

INSERT INTO
    `scores` (
        `Id_scores`,
        `nom_utilisateur`,
        `mot_de_passe`,
        `nombre_partie`,
        `victoire_joueur`,
        `ip_address`,
        `timestamp_`
    )
VALUES (
        1,
        'Valdes Gabriela',
        '123',
        0,
        0,
        NULL,
        '2025-12-16 10:11:36'
    ),
    (
        3,
        'VG',
        '111',
        0,
        0,
        NULL,
        '2025-12-17 00:30:22'
    ),
    (
        4,
        'Gaby',
        'gg2406vv',
        0,
        0,
        NULL,
        '2025-12-17 01:10:03'
    ),
    (
        5,
        'Dorian',
        '1234',
        0,
        0,
        NULL,
        '2025-12-17 08:20:20'
    );

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;