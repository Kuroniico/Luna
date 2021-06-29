-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 29 juin 2021 à 15:28
-- Version du serveur : 10.3.29-MariaDB-0+deb10u1
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
-- Structure de la table `Admins`
--

CREATE TABLE `Admins` (
  `ID` int(11) NOT NULL,
  `_Mail` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `_Password` text COLLATE latin1_general_cs NOT NULL,
  `Localisation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Admins`
--

INSERT INTO `Admins` (`ID`, `_Mail`, `_Password`, `Localisation`) VALUES
(1, 'admin@coriolis.fr', '1234', 1),
(13, 'guillaumebaca@coriolis.fr', 'C0r10l1s1234', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Candidats`
--

CREATE TABLE `Candidats` (
  `_ID` int(11) NOT NULL,
  `_Token` varchar(32) COLLATE latin1_general_cs NOT NULL,
  `Nom` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `Prenom` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `DateDeNaissance` date DEFAULT NULL,
  `Telephone` varchar(12) COLLATE latin1_general_cs DEFAULT NULL,
  `Mail` varchar(100) COLLATE latin1_general_cs DEFAULT NULL,
  `DateDuJour` timestamp NOT NULL DEFAULT current_timestamp(),
  `IDPEmploi` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `DateDebutDisp` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `DatefinDisp` varchar(10) COLLATE latin1_general_cs DEFAULT NULL,
  `ControleRef` tinyint(1) DEFAULT 0,
  `DebutTest` timestamp NOT NULL DEFAULT current_timestamp(),
  `TempsRestant` int(11) NOT NULL,
  `TempsAdRestant` int(11) NOT NULL,
  `Localisation` int(11) DEFAULT NULL,
  `Salle de formation` int(11) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Candidats`
--

INSERT INTO `Candidats` (`_ID`, `_Token`, `Nom`, `Prenom`, `DateDeNaissance`, `Telephone`, `Mail`, `DateDuJour`, `IDPEmploi`, `DateDebutDisp`, `DatefinDisp`, `ControleRef`, `DebutTest`, `TempsRestant`, `TempsAdRestant`, `Localisation`, `Salle de formation`) VALUES
(1, 'PJ', 'Polnareff', 'Jean-Pierre', '2021-06-03', '5664646555', 'jppolnareff@paraplégie.fr', '2021-06-29 07:42:34', 'JPPolnareff', '2021-06-01', '2021-06-11', 0, '2021-06-29 07:42:34', 30, 10, NULL, NULL),
(2, 'ef1', 'ehfgzeygf', 'fftuftuftfufuyftu', '2021-06-04', 'frefefer', 'frefr', '2021-06-29 09:11:26', 'fererf', '2021-06-16', '2021-06-13', 0, '2021-06-29 09:11:26', 30, 10, NULL, NULL),
(3, 'JT2', 'Jean', 'Test', '2021-06-03', '', '', '2021-06-29 12:25:41', '', '', '', 0, '2021-06-29 12:25:41', 30, 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Categories`
--

CREATE TABLE `Categories` (
  `Nom` varchar(50) COLLATE latin1_general_cs NOT NULL,
  `Introduction` longtext COLLATE latin1_general_cs DEFAULT NULL,
  `QuantiteMin` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Categories`
--

INSERT INTO `Categories` (`Nom`, `Introduction`, `QuantiteMin`) VALUES
('Anglais', 'Nous nous reverrons, un jour ou l\'autre... Salut mon pote', 7),
('Informatique', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur quis nisl enim. Proin dignissim leo arcu. Sed eget sapien gravida, auctor risus nec, hendrerit orci.', 5),
('Mathématiques', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur quis nisl enim. Proin dignissim leo arcu. Sed eget sapien gravida, auctor risus nec, hendrerit orci.', 5),
('Orthographe', 'À l\'heure des abréviations \"SMS\" et des nouveaux raccourcis sémantiques, pur \"web\" dans les blogs, forums et autres chats, pourquoi ne pas revoir vos basiques en Français ? Notice d\'utilisation : des phrases vous sont proposées. Pour chaque phrase, si vous voyez une faute, indiquez la faute et sa correction, sinon, cochez la case \"il n\'y a pas de faute\".', 3),
('Test d\'écoute', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur quis nisl enim. Proin dignissim leo arcu. Sed eget sapien gravida, auctor risus nec, hendrerit orci.', 5);

-- --------------------------------------------------------

--
-- Structure de la table `Parametres`
--

CREATE TABLE `Parametres` (
  `DureeTest` int(11) NOT NULL,
  `TempsAd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Parametres`
--

INSERT INTO `Parametres` (`DureeTest`, `TempsAd`) VALUES
(30, 10);

-- --------------------------------------------------------

--
-- Structure de la table `Questions`
--

CREATE TABLE `Questions` (
  `_ID` int(11) NOT NULL,
  `Categorie` varchar(50) COLLATE latin1_general_cs DEFAULT NULL,
  `Intitule` longtext COLLATE latin1_general_cs DEFAULT NULL,
  `Obligatoire` tinyint(1) NOT NULL DEFAULT 0,
  `Illustration` varchar(300) COLLATE latin1_general_cs DEFAULT NULL,
  `ReponseType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Questions`
--

INSERT INTO `Questions` (`_ID`, `Categorie`, `Intitule`, `Obligatoire`, `Illustration`, `ReponseType`) VALUES
(1, 'Mathématiques', 'Un client consomme 1230€ d\'électricité par an. Après un diagnostic, on lui propose une baisse de puissance. Suite à cette modification, on estime qu\'il consommera 999€ d\'électricité par an.\nCependant, cela nécessite une intervention qui lui sera facturée 90€\n\nQuelle sera l\'économie réalisée sur un an (sans tenir compte du coût de l\'intervention) ? Détaillez vos calculs.', 1, 'https://epic7x.com/wp-content/uploads/2019/01/maid-chloe.png', 2),
(4, 'Test d\'écoute', 'Pas le temps', 0, '', 0),
(6, 'Mathématiques', '127*92', 1, NULL, 0),
(7, 'Mathématiques', '27-12', 0, NULL, 0),
(8, 'Mathématiques', '5616+245', 0, NULL, 0),
(9, 'Mathématiques', '5414+5752', 0, NULL, 0),
(10, 'Mathématiques', '5+484', 0, NULL, 0),
(11, 'Mathématiques', '5487164*48454/561548-5541', 0, NULL, 0),
(12, 'Mathématiques', '1+2', 0, NULL, 0),
(13, 'Test d\'écoute', 'Quelle est l\'une des qualités primordiales pour un conseiller clientèle :', 0, NULL, 2),
(14, 'Test d\'écoute', 'Comment formuleriez-vous cette phrase ?', 0, NULL, 2),
(15, 'Test d\'écoute', 'Choisissez la formulation qui convient le mieux :', 1, NULL, 2),
(16, 'Test d\'écoute', 'Quelle qualité est demandée pour un conseiller au-delà des qualités relationnelles :', 0, NULL, 2),
(17, 'Test d\'écoute', ' Que veut dire faire le mot \"empathie\" ?', 0, NULL, 2),
(18, 'Test d\'écoute', 'Lors d\'une communication téléphonique, je dois parler au : ', 0, NULL, 2),
(25, 'Informatique', 'Uniquement avec le clavier d\'ordinateur, comment faire :\r\nCopier :', 1, NULL, 1),
(26, 'Informatique', 'Uniquement avec le clavier d\'ordinateur, comment faire :\r\nColler :', 0, NULL, 1),
(27, 'Informatique', 'Uniquement avec le clavier d\'ordinateur, comment faire :\r\nCouper :', 0, NULL, 1),
(28, 'Informatique', 'Que fait control X ?', 0, NULL, 1),
(29, 'Informatique', 'Que fait control C ?', 0, NULL, 1),
(30, 'Informatique', 'Que fait control V ?', 0, NULL, 1),
(31, 'Informatique', 'Quel est le raccourci clavier pour lancer une impression ?', 0, NULL, 1),
(32, 'Informatique', 'Quelles sont les premières lettres du clavier ?', 0, NULL, 1),
(33, 'Orthographe', 'Tu (acquérir) une expérience précieuse dans la relation client ', 1, NULL, 1),
(34, 'Orthographe', 'Je me (rendre) indispensable pour développer avec le client une relation durable et lui proposer une offre adaptée ', 0, NULL, 1),
(35, 'Orthographe', 'Les téléacteurs (croître) rapidement leurs taux de ventes tout en respectant la règle des 5 C', 0, NULL, 1),
(36, 'Orthographe', 'Il (concevoir) que 30% des actions de prospections menées, ont été efficaces', 0, NULL, 1),
(37, 'Orthographe', 'Depuis quelques années, les prix (augmenter), ce qui engendre le mécontentement des clients', 0, NULL, 1),
(38, 'Orthographe', 'Les marchandises qu\'ils avaient apporté sont considérées comme abimées', 1, NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `QuestionsTests`
--

CREATE TABLE `QuestionsTests` (
  `_ID` int(11) NOT NULL,
  `_IDQuestion` int(11) NOT NULL,
  `_IDTest` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `QuestionsTests`
--

INSERT INTO `QuestionsTests` (`_ID`, `_IDQuestion`, `_IDTest`) VALUES
(6, 1, 1),
(24, 1, 2),
(42, 1, 3),
(61, 1, 4),
(79, 1, 5),
(36, 4, 2),
(52, 4, 3),
(69, 4, 4),
(88, 4, 5),
(7, 6, 1),
(25, 6, 2),
(43, 6, 3),
(60, 6, 4),
(78, 6, 5),
(62, 7, 4),
(26, 8, 2),
(45, 8, 3),
(9, 9, 1),
(82, 9, 5),
(8, 10, 1),
(28, 10, 2),
(46, 10, 3),
(81, 10, 5),
(27, 11, 2),
(44, 11, 3),
(63, 11, 4),
(10, 12, 1),
(64, 12, 4),
(80, 12, 5),
(18, 13, 1),
(35, 13, 2),
(54, 13, 3),
(71, 13, 4),
(87, 13, 5),
(15, 14, 1),
(33, 14, 2),
(72, 14, 4),
(90, 14, 5),
(14, 15, 1),
(32, 15, 2),
(50, 15, 3),
(68, 15, 4),
(86, 15, 5),
(34, 16, 2),
(89, 16, 5),
(17, 17, 1),
(51, 17, 3),
(70, 17, 4),
(16, 18, 1),
(53, 18, 3),
(1, 25, 1),
(19, 25, 2),
(37, 25, 3),
(55, 25, 4),
(73, 25, 5),
(40, 26, 3),
(75, 26, 5),
(4, 27, 1),
(23, 27, 2),
(38, 27, 3),
(76, 27, 5),
(2, 28, 1),
(39, 28, 3),
(57, 28, 4),
(20, 29, 2),
(41, 29, 3),
(58, 29, 4),
(5, 30, 1),
(56, 30, 4),
(77, 30, 5),
(21, 31, 2),
(74, 31, 5),
(3, 32, 1),
(22, 32, 2),
(59, 32, 4),
(12, 33, 1),
(30, 33, 2),
(47, 33, 3),
(65, 33, 4),
(83, 33, 5),
(13, 34, 1),
(67, 35, 4),
(31, 37, 2),
(49, 37, 3),
(85, 37, 5),
(11, 38, 1),
(29, 38, 2),
(48, 38, 3),
(66, 38, 4),
(84, 38, 5);

-- --------------------------------------------------------

--
-- Structure de la table `ReponsesTests`
--

CREATE TABLE `ReponsesTests` (
  `_ID` int(11) NOT NULL,
  `_IDQuestion` int(11) NOT NULL,
  `_IDTest` int(11) NOT NULL,
  `_IDCantidat` int(11) NOT NULL,
  `Reponse` varchar(1000) COLLATE latin1_general_cs DEFAULT NULL,
  `Select` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `ReponsesTests`
--

INSERT INTO `ReponsesTests` (`_ID`, `_IDQuestion`, `_IDTest`, `_IDCantidat`, `Reponse`, `Select`) VALUES
(1, 25, 1, 2, 'xjfxkkf', NULL),
(2, 26, 1, 2, 'kfckcyl', NULL),
(3, 27, 1, 2, 'yfglhull', NULL),
(4, 30, 1, 2, 'ulufhmgi', NULL),
(5, 31, 1, 2, 'mgimùoù', NULL),
(6, 33, 1, 2, 'gjoùijgùùjgùo', NULL),
(7, 37, 1, 2, 'ijgùùkhoùo', NULL),
(8, 13, 1, 5, NULL, 0),
(9, 25, 8, 6, 'kjsehmhjdrio', NULL),
(10, 29, 8, 6, 'eshglhjlmjoj', NULL),
(11, 1, 8, 6, NULL, 1),
(12, 13, 8, 6, NULL, 1),
(13, 14, 8, 6, NULL, 1),
(14, 25, 1, 13, 'Je suis un test', NULL),
(15, 13, 1, 13, NULL, 1),
(16, 18, 14, 15, NULL, 0),
(17, 14, 14, 15, NULL, 1),
(18, 1, 2, 2, NULL, 1),
(19, 1, 4, 3, NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Réponse`
--

CREATE TABLE `Réponse` (
  `_ID` int(11) NOT NULL,
  `_IDQuestion` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Reponse` varchar(2000) COLLATE latin1_general_cs DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Réponse`
--

INSERT INTO `Réponse` (`_ID`, `_IDQuestion`, `Type`, `Reponse`) VALUES
(3, 2, 1, ''),
(4, 3, 3, 'Vrai. Justification:'),
(5, 3, 3, 'Faux. Justification'),
(6, 13, 2, 'Souriant'),
(9, 14, 2, '\"Ne voulez-vous pas ... ?\"'),
(10, 14, 2, '\"Voulez-vous ... ?\"'),
(11, 15, 2, 'Je comprends votre point de vue'),
(12, 15, 2, 'Vous avez tort '),
(13, 15, 2, 'Vous ne comprenez pas '),
(14, 16, 2, 'Connaissance de l\'outil informatique '),
(15, 16, 2, 'Avoir des facilités en mathématiques '),
(16, 16, 2, 'Avoir des facilités en langue vivante'),
(17, 17, 2, 'Se mettre à la place du client ?'),
(18, 17, 2, 'Prendre des décisions à la place du client '),
(19, 17, 2, 'Finir les phrases du client '),
(20, 18, 2, 'Présent'),
(21, 18, 2, 'Futur'),
(30, 33, 1, ''),
(31, 34, 1, ''),
(32, 35, 1, ''),
(33, 36, 1, ''),
(34, 37, 1, ''),
(35, 38, 3, 'Faute - Correction :'),
(36, 38, 3, 'Il n\'y a pas de faute;'),
(37, 1, 2, 'Salut'),
(38, 1, 2, 'Mon'),
(39, 1, 2, 'Pote'),
(40, 1, 2, 'Nous'),
(44, 40, 2, NULL),
(56, 1, 2, NULL),
(61, 1, 2, NULL),
(62, 1, 2, NULL),
(63, 25, 2, 'TESTde'),
(68, 26, 2, NULL),
(69, 26, 2, NULL),
(70, 26, 2, NULL),
(219, 25, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Tests`
--

CREATE TABLE `Tests` (
  `_ID` int(11) NOT NULL,
  `NSalle` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `Localisation` varchar(10) COLLATE latin1_general_cs NOT NULL,
  `DateDebut` timestamp NOT NULL DEFAULT current_timestamp(),
  `Createur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Déchargement des données de la table `Tests`
--

INSERT INTO `Tests` (`_ID`, `NSalle`, `Localisation`, `DateDebut`, `Createur`) VALUES
(1, '1', '1', '2021-06-29 07:42:09', 1),
(2, '1', '1', '2021-06-29 09:10:52', 1),
(3, '1', '1', '2021-06-29 12:25:26', 1),
(4, '1', '1', '2021-06-29 12:25:30', 1),
(5, '1', '1', '2021-06-29 12:43:18', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Candidats`
--
ALTER TABLE `Candidats`
  ADD PRIMARY KEY (`_ID`),
  ADD KEY `_Token` (`_Token`);

--
-- Index pour la table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`Nom`);

--
-- Index pour la table `Questions`
--
ALTER TABLE `Questions`
  ADD PRIMARY KEY (`_ID`),
  ADD KEY `Theme` (`Categorie`);

--
-- Index pour la table `QuestionsTests`
--
ALTER TABLE `QuestionsTests`
  ADD PRIMARY KEY (`_ID`),
  ADD KEY `_IDQuestion` (`_IDQuestion`,`_IDTest`);

--
-- Index pour la table `ReponsesTests`
--
ALTER TABLE `ReponsesTests`
  ADD PRIMARY KEY (`_ID`),
  ADD KEY `_IDQuestion` (`_IDQuestion`,`_IDTest`,`_IDCantidat`);

--
-- Index pour la table `Réponse`
--
ALTER TABLE `Réponse`
  ADD PRIMARY KEY (`_ID`);

--
-- Index pour la table `Tests`
--
ALTER TABLE `Tests`
  ADD PRIMARY KEY (`_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `Candidats`
--
ALTER TABLE `Candidats`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Questions`
--
ALTER TABLE `Questions`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `QuestionsTests`
--
ALTER TABLE `QuestionsTests`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT pour la table `ReponsesTests`
--
ALTER TABLE `ReponsesTests`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `Réponse`
--
ALTER TABLE `Réponse`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT pour la table `Tests`
--
ALTER TABLE `Tests`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
