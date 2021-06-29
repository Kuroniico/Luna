-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 10 juin 2021 à 15:09
-- Version du serveur : 10.3.27-MariaDB-0+deb10u1
-- Version de PHP : 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_questionnaires_rh`
--

-- --------------------------------------------------------

--
-- Structure de la table `Questions`
--

CREATE TABLE `Questions` (
  `_ID` int(11) NOT NULL,
  `Categorie` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `Intitule` varchar(300) COLLATE latin1_general_cs DEFAULT NULL,
  `Obligatoire` tinyint(1) NOT NULL DEFAULT 0,
  `Illustration` varchar(300) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Questions`
--

INSERT INTO `Questions` (`_ID`, `Categorie`, `Intitule`, `Obligatoire`, `Illustration`) VALUES
(1, 'Mathématiques ', 'Pas le temps', 1, '1 + 1'),
(2, 'Mathématiques ', 'Pas le temps', 0, '1 + 1'),
(3, 'Conjugaison', 'Pas le temps', 1, '1 + 1'),
(4, 'Test d\'écoute', 'Pas le temps', 0, '1 + 1'),
(5, 'Mathématiques', 'Rappelez le théorème de Pythagore ', 1, 'En vrai ça sert à rien lol '),
(6, 'Mathématiques', '127*92', 1, NULL),
(7, 'Mathématiques', '27-12', 0, NULL),
(8, 'Mathématiques', '5616+245', 0, NULL),
(9, 'Mathématiques', '5414+5752', 0, NULL),
(10, 'Mathématiques', '5+484', 0, NULL),
(11, 'Mathématiques', '5487164*48454/561548-5541', 0, NULL),
(12, 'Mathématiques', '1+2', 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`_ID`),
  ADD KEY `Theme` (`Categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Questions`
--
ALTER TABLE `Questions`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
