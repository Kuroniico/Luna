-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 10 juin 2021 à 01:42
-- Version du serveur :  5.7.30
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données : `gestion_questionnaire_rh`
--

-- --------------------------------------------------------

--
-- Structure de la table `Categories`
--

CREATE TABLE `Categories` (
  `ID` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Introduction` int(11) DEFAULT NULL,
  `QuantiteMin` int(11) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Categories`
--

INSERT INTO `Categories` (`ID`, `Nom`, `Introduction`, `QuantiteMin`) VALUES
(1, 'Test d\'écoute', NULL, 5),
(2, 'Informatique', NULL, 5),
(3, 'Orthographe', NULL, 5),
(4, 'Conjugaison', NULL, 5),
(5, 'Mathematique', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Question`
--

CREATE TABLE `Question` (
  `ID` int(11) NOT NULL,
  `Categorie` varchar(50) NOT NULL,
  `Intitule` varchar(300) NOT NULL,
  `TypeReponse` int(11) NOT NULL DEFAULT '1',
  `Obligatoire` tinyint(1) NOT NULL DEFAULT '0',
  `Illustration` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Nom` (`Nom`);

--
-- Index pour la table `Question`
--
ALTER TABLE `Question`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Categorie` (`Categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Question`
--
ALTER TABLE `Question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`Categorie`) REFERENCES `Categories` (`Nom`);
