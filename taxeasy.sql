-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 12 jan. 2024 à 14:26
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `taxeasy`
--
CREATE DATABASE IF NOT EXISTS `taxeasy` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `taxeasy`;

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Numero` int(11) NOT NULL,
  `Rue` varchar(80) NOT NULL,
  `NomAdresse` varchar(60) DEFAULT NULL,
  `Vile` varchar(50) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Ville` (`Vile`)
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`Id`, `Numero`, `Rue`, `NomAdresse`, `Vile`, `latitude`, `longitude`) VALUES
(180, 10, ' rue dagneau', NULL, ' frameries', 50.4025, 3.89047),
(181, 40, ' Rue des Marais', NULL, ' Amougies', 50.743, 3.51062),
(182, 40, 'rue des marais', NULL, 'amougies', 1, 1),
(183, 102, ' ', NULL, 'Rue Provinciale', 50.7136, 3.4565),
(184, 9, ' ', NULL, 'Rue du Haut Rejet', 50.6977, 3.48802),
(185, 102, ' ', NULL, 'Rue Dr Roland', 50.53, 3.74037),
(186, 11, ' ', NULL, 'Rue de Moulbaix', 50.5909, 3.69587),
(187, 40, ' ', NULL, 'Rue du Couvent', 50.5941, 3.6852),
(188, 2, ' ', NULL, 'Rue du Mont', 50.6709, 3.7043),
(189, 36, ' ', NULL, 'Rue du Dieu des Monts', 50.6915, 3.64884),
(190, 21, ' ', NULL, 'Rue Chapelle Planchon', 50.7295, 3.59864),
(191, 98, ' ', NULL, 'Rue du Bois', 49.6607, 5.60815),
(192, 1, ' ', NULL, 'Bas Rejet', 50.7321, 3.48994),
(193, 57, ' ', NULL, 'Rés Joseph Defaux', 50.5864, 3.4957),
(194, 24, ' ', NULL, 'Rue du Professeur Delcampe', 50.5846, 3.54123),
(195, 48, ' ', NULL, 'Rue des Anglais', 50.5315, 3.9061);

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(512) NOT NULL,
  `Note` float NOT NULL,
  `IdCourse` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdCourseAvis` (`IdCourse`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`Id`, `Description`, `Note`, `IdCourse`) VALUES
(3, 'La voiture roulait vite', 2, 67),
(4, ' Tout s\'est bien passé.', 5, 66);

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DateReservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DistanceParcourue` float NOT NULL,
  `IdClient` int(11) NOT NULL,
  `IdChauffeur` int(11) NOT NULL,
  `IdAdresseDepart` int(11) NOT NULL,
  `IdAdresseFin` int(11) NOT NULL,
  `IdTarification` int(11) NOT NULL,
  `IdMajoration` int(11) NOT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdAdresseDepart` (`IdAdresseDepart`),
  KEY `FK_IdAdresseFin` (`IdAdresseFin`),
  KEY `FK_IdMajoration` (`IdMajoration`),
  KEY `FK_IdTarification` (`IdTarification`),
  KEY `FK_IdChauffeur` (`IdChauffeur`),
  KEY `FK_IdClient` (`IdClient`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`Id`, `DateReservation`, `DistanceParcourue`, `IdClient`, `IdChauffeur`, `IdAdresseDepart`, `IdAdresseFin`, `IdTarification`, `IdMajoration`, `duree`) VALUES
(59, '2024-01-11 18:32:50', 67, 7, 10, 180, 181, 33, 2, 3291),
(64, '2024-01-11 19:22:06', 3066.1, 7, 13, 183, 184, 41, 2, 267),
(66, '2024-01-11 19:41:26', 60, 23, 6, 185, 186, 40, 2, 857),
(67, '2024-01-11 20:39:21', 85, 23, 27, 188, 189, 33, 2, 678),
(68, '2024-01-11 22:02:11', 270, 25, 6, 190, 191, 41, 2, 9928),
(74, '2024-01-12 08:30:00', 300, 25, 10, 191, 181, 40, 2, 10504),
(75, '2024-01-17 19:00:00', 24968.7, 26, 10, 192, 193, 41, 2, 1437),
(76, '2024-01-20 16:00:00', 34859.2, 26, 10, 194, 195, 41, 2, 2118);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`Id`, `Nom`) VALUES
(1, 'Reservee'),
(2, 'reservation confirmer'),
(3, 'Chauffeur en route'),
(4, 'En cours'),
(5, 'Annule par client'),
(6, 'Annule par chauffeur'),
(7, 'Termine'),
(8, 'Paye');

-- --------------------------------------------------------

--
-- Structure de la table `lienautonome`
--

DROP TABLE IF EXISTS `lienautonome`;
CREATE TABLE IF NOT EXISTS `lienautonome` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PlaqueVehicule` varchar(10) NOT NULL,
  `IdChauffeur` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_plaque` (`PlaqueVehicule`),
  KEY `FK_chauffeur31` (`IdChauffeur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lienautonome`
--

INSERT INTO `lienautonome` (`Id`, `PlaqueVehicule`, `IdChauffeur`) VALUES
(7, 'A-UTO-001', 27);

-- --------------------------------------------------------

--
-- Structure de la table `liencourseetat`
--

DROP TABLE IF EXISTS `liencourseetat`;
CREATE TABLE IF NOT EXISTS `liencourseetat` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IdCourse` int(11) NOT NULL,
  `IdEtat` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdEtat` (`IdEtat`),
  KEY `FK_IdCourse` (`IdCourse`)
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liencourseetat`
--

INSERT INTO `liencourseetat` (`Id`, `Date`, `IdCourse`, `IdEtat`) VALUES
(148, '2024-01-11 17:29:19', 58, 1),
(149, '2024-01-11 17:29:19', 58, 1),
(150, '2024-01-11 18:36:58', 59, 2),
(151, '2024-01-11 18:39:21', 59, 4),
(152, '2024-01-11 18:39:27', 59, 7),
(153, '2024-01-11 18:22:06', 64, 1),
(155, '2024-01-11 18:41:26', 66, 1),
(164, '2024-01-11 20:03:06', 66, 2),
(165, '2024-01-11 20:15:09', 66, 4),
(166, '2024-01-11 20:16:02', 66, 7),
(167, '2024-01-11 20:35:04', 66, 8),
(168, '2024-01-11 19:39:21', 67, 1),
(171, '2024-01-11 21:41:25', 67, 2),
(172, '2024-01-11 21:41:25', 67, 3),
(173, '2024-01-11 21:41:40', 67, 4),
(174, '2024-01-11 21:41:40', 67, 7),
(175, '2024-01-11 21:02:11', 68, 1),
(181, '2024-01-12 07:30:00', 74, 1),
(182, '2024-01-11 22:16:30', 68, 2),
(183, '2024-01-11 22:16:34', 68, 4),
(184, '2024-01-11 22:16:39', 68, 7),
(185, '2024-01-11 22:17:27', 74, 2),
(186, '2024-01-11 22:21:50', 59, 4),
(187, '2024-01-11 22:24:06', 59, 7),
(188, '2024-01-11 22:24:10', 74, 4),
(189, '2024-01-11 22:25:14', 74, 7),
(190, '2024-01-17 18:00:00', 75, 1),
(191, '2024-01-12 13:48:25', 75, 2),
(192, '2024-01-20 15:00:00', 76, 1),
(193, '2024-01-12 13:52:16', 75, 4),
(194, '2024-01-12 13:56:00', 76, 2);

-- --------------------------------------------------------

--
-- Structure de la table `localite`
--

DROP TABLE IF EXISTS `localite`;
CREATE TABLE IF NOT EXISTS `localite` (
  `Ville` varchar(50) NOT NULL,
  `CodePostal` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`Ville`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `localite`
--

INSERT INTO `localite` (`Ville`, `CodePostal`) VALUES
(' Amougies', 7750),
(' frameries', 7080),
('amougies', 7750),
('Bas Rejet', 7750),
('Rés Joseph Defaux', 7530),
('Rue Chapelle Planchon', 7912),
('Rue de Moulbaix', 7903),
('Rue des Anglais', 7050),
('Rue Dr Roland', 7970),
('Rue du Bois', 6740),
('Rue du Couvent', 7903),
('Rue du Dieu des Monts', 7911),
('Rue du Haut Rejet', 7760),
('Rue du Mont', 7911),
('Rue du Professeur Delcampe', 7534),
('Rue Provinciale', 7760);

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE IF NOT EXISTS `maintenance` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(512) NOT NULL,
  `DateDebut` date NOT NULL,
  `DateFin` date NOT NULL,
  `IdProbleme` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdProblem` (`IdProbleme`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`Id`, `Description`, `DateDebut`, `DateFin`, `IdProbleme`) VALUES
(1, 'Rendez-vous garage.', '2024-02-01', '2024-02-01', 13);

-- --------------------------------------------------------

--
-- Structure de la table `personne`
--

DROP TABLE IF EXISTS `personne`;
CREATE TABLE IF NOT EXISTS `personne` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(32) NOT NULL,
  `Prenom` varchar(32) NOT NULL,
  `Email` varchar(120) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `NumeroDeTelephone` int(10) UNSIGNED NOT NULL,
  `IdStatus` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `FK_IdStatus` (`IdStatus`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`Id`, `Nom`, `Prenom`, `Email`, `Mdp`, `NumeroDeTelephone`, `IdStatus`) VALUES
(6, 'test', 'test', 'test.test@test.test', '$2y$10$lHHfwPjCkspNTqID9LGfWuT5Tt8DCpDuFOdBdnveSFOZ0MW48NzSy', 479739695, 2),
(7, 'aa', 'aa', 'aa@aa.be', '$2y$10$.fvEITUNJfBwphA1.Oc/2O7ZNAdOAaByxUKaew1BLV3PVLPPge0aa', 0, 1),
(8, 'admin', 'admin2', 'admin@admin.be', '$2y$10$UqCLTVPPRuhWdxBvoKiCAeEcCpM/Cw3Ir81eaQnFyi.94DNhzMFjq', 0, 3),
(9, 'Client', 'test', 'client@test.be', 'ptdr il pourra jamais se conncter', 6942000, 1),
(10, 'demo', 'chauffeur', 'demo@chauffeur.be', '$2y$10$lM.FtatJw5DpNnbqf8UCJO6dieYlK91lkz.ERAHg5jZGMr4DC9eNW', 123456789, 2),
(13, 'Attente', 'Attente', 'Attente@Attente.be', 'PTDR', 6500000, 5),
(20, 'Autonome', 'supprimer', 'taxeasy', 'autonome', 65000000, 7),
(21, 'Autonome', 'supprimer', 'taxeasy', 'autonome', 65000000, 7),
(22, 'Autonome', 'supprimer', 'taxeasy', 'autonome', 65000000, 7),
(23, 'client2', 'demo', 'client2@demo.be', '$2y$10$8VhUnYFZyuQ5Xp2NQz/iIewcvbXiK7MR6ojhXPwKK246V8VTARvzK', 479000000, 1),
(25, 'client', 'abanir', 'client@abanir.be', '$2y$10$6Ilp5qH7pjFidkRaZedy7.wUC4WcmSysrG1nE.CJmYz6aepVV4lTW', 78965443, 4),
(26, 'demo2', 'client', 'demo2@client.be', '$2y$10$3nDKNGIJ4sTzveHFTppq3.XSVS4N8zZsxmXabUNX.Nf5ulEq8tZIC', 456, 1),
(27, 'Autonome', 'A-UTO-001', 'taxeasy', 'autonome', 65000000, 6);

-- --------------------------------------------------------

--
-- Structure de la table `photocourse`
--

DROP TABLE IF EXISTS `photocourse`;
CREATE TABLE IF NOT EXISTS `photocourse` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CheminDAcces` varchar(64) NOT NULL,
  `IdCourse` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Fk_IdCoursePhoto` (`IdCourse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `photoprobleme`
--

DROP TABLE IF EXISTS `photoprobleme`;
CREATE TABLE IF NOT EXISTS `photoprobleme` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CheminDAcces` varchar(64) NOT NULL,
  `IdProbleme` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdPhotoProblem` (`IdProbleme`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photoprobleme`
--

INSERT INTO `photoprobleme` (`Id`, `CheminDAcces`, `IdProbleme`) VALUES
(1, 'probleme/14/0.jpg', 14);

-- --------------------------------------------------------

--
-- Structure de la table `probleme`
--

DROP TABLE IF EXISTS `probleme`;
CREATE TABLE IF NOT EXISTS `probleme` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(512) NOT NULL,
  `Regle` tinyint(1) NOT NULL DEFAULT '0',
  `Rouler` tinyint(1) NOT NULL,
  `IdCourse` int(11) NOT NULL,
  `IdAdresse` int(11) NOT NULL,
  `IdTypeProbleme` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_IdCourseProbleme` (`IdCourse`),
  KEY `FK_IdTypeProbleme` (`IdTypeProbleme`),
  KEY `FK_IdAdresseProblem` (`IdAdresse`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `probleme`
--

INSERT INTO `probleme` (`Id`, `Description`, `Regle`, `Rouler`, `IdCourse`, `IdAdresse`, `IdTypeProbleme`) VALUES
(13, ' L\'auto indique qu\'il faut faire l\'entretient', 1, 1, 59, 182, 1),
(14, ' J\'ai eu un accrochage en croissant un tracteur ', 0, 0, 66, 182, 2);

-- --------------------------------------------------------

--
-- Structure de la table `tarification`
--

DROP TABLE IF EXISTS `tarification`;
CREATE TABLE IF NOT EXISTS `tarification` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PrixAuKilometre` float NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PlaqueVehicule` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Vehicule` (`PlaqueVehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tarification`
--

INSERT INTO `tarification` (`Id`, `PrixAuKilometre`, `Date`, `PlaqueVehicule`) VALUES
(33, 1, '2024-01-11 17:51:47', 'T-AUT-001'),
(34, 2, '2024-01-11 17:51:50', 'T-AUT-001'),
(35, 3, '2024-01-11 17:51:52', 'T-AUT-001'),
(36, 2.5, '2024-01-11 17:51:55', 'T-AUT-001'),
(37, 45, '2024-01-11 17:53:51', 'A-UTO-001'),
(38, 60, '2024-01-11 17:53:54', 'A-UTO-001'),
(39, 47.5, '2024-01-11 17:53:57', 'A-UTO-001'),
(40, 2.25, '2024-01-11 17:54:06', 'T-AAA-002'),
(41, 3.75, '2024-01-11 17:54:20', 'T-AAA-003'),
(42, 3, '2024-01-11 17:54:29', 'T-AAA-003');

-- --------------------------------------------------------

--
-- Structure de la table `typecarburant`
--

DROP TABLE IF EXISTS `typecarburant`;
CREATE TABLE IF NOT EXISTS `typecarburant` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typecarburant`
--

INSERT INTO `typecarburant` (`Id`, `Nom`) VALUES
(1, 'Diesel'),
(2, 'Essence'),
(3, 'Diesel Hybride'),
(4, 'Essence Hybride'),
(5, 'Electrique');

-- --------------------------------------------------------

--
-- Structure de la table `typemajoration`
--

DROP TABLE IF EXISTS `typemajoration`;
CREATE TABLE IF NOT EXISTS `typemajoration` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(20) NOT NULL,
  `Coefficient` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typemajoration`
--

INSERT INTO `typemajoration` (`Id`, `Nom`, `Coefficient`) VALUES
(1, 'normal', 1),
(2, 'weekend', 1.7);

-- --------------------------------------------------------

--
-- Structure de la table `typepersonne`
--

DROP TABLE IF EXISTS `typepersonne`;
CREATE TABLE IF NOT EXISTS `typepersonne` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NomTitre` varchar(12) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typepersonne`
--

INSERT INTO `typepersonne` (`Id`, `NomTitre`) VALUES
(1, 'Client'),
(2, 'Chauffeur'),
(3, 'Admin'),
(4, 'Banni'),
(5, 'Attente'),
(6, 'Autonome'),
(7, 'Ancien');

-- --------------------------------------------------------

--
-- Structure de la table `typeprobleme`
--

DROP TABLE IF EXISTS `typeprobleme`;
CREATE TABLE IF NOT EXISTS `typeprobleme` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(32) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeprobleme`
--

INSERT INTO `typeprobleme` (`Id`, `Nom`) VALUES
(1, 'Entretien'),
(2, 'Dégât léger carrosserie'),
(3, 'Dégât lourd carrosserie'),
(4, 'Accident léger'),
(5, 'Perte totale');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `PlaqueVoiture` varchar(12) NOT NULL,
  `Marque` varchar(40) NOT NULL,
  `Modele` varchar(60) NOT NULL,
  `Couleur` varchar(30) NOT NULL,
  `Annee` int(11) NOT NULL,
  `Carburant` int(30) NOT NULL,
  `Kilometrage` int(11) NOT NULL,
  `PlaceDisponible` int(11) NOT NULL,
  `PMR` varchar(3) NOT NULL,
  PRIMARY KEY (`PlaqueVoiture`),
  KEY `FK_IdCarburan` (`Carburant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`PlaqueVoiture`, `Marque`, `Modele`, `Couleur`, `Annee`, `Carburant`, `Kilometrage`, `PlaceDisponible`, `PMR`) VALUES
('A-UTO-001', 'BMW', 'I9', 'noir', 2034, 5, 1750, 4, 'Non'),
('T-AAA-002', 'Toyota', 'Corolla', 'noir', 2019, 4, 165360, 4, 'Non'),
('T-AAA-003', 'Peugeot', 'Partner', 'blanc', 2022, 2, 45270, 2, 'PMR'),
('T-AUT-001', 'Peugeot', '208', 'rouge', 2017, 1, 115075, 4, 'Non');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD CONSTRAINT `FK_Ville` FOREIGN KEY (`Vile`) REFERENCES `localite` (`Ville`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `FK_IdCourseAvis` FOREIGN KEY (`IdCourse`) REFERENCES `course` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `FK_IdAdresseDepart` FOREIGN KEY (`IdAdresseDepart`) REFERENCES `adresse` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdAdresseFin` FOREIGN KEY (`IdAdresseFin`) REFERENCES `adresse` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdChauffeur` FOREIGN KEY (`IdChauffeur`) REFERENCES `personne` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdClient` FOREIGN KEY (`IdClient`) REFERENCES `personne` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdMajoration` FOREIGN KEY (`IdMajoration`) REFERENCES `typemajoration` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdTarification` FOREIGN KEY (`IdTarification`) REFERENCES `tarification` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `lienautonome`
--
ALTER TABLE `lienautonome`
  ADD CONSTRAINT `FK_chauffeur31` FOREIGN KEY (`IdChauffeur`) REFERENCES `personne` (`Id`),
  ADD CONSTRAINT `FK_plaque` FOREIGN KEY (`PlaqueVehicule`) REFERENCES `vehicule` (`PlaqueVoiture`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `liencourseetat`
--
ALTER TABLE `liencourseetat`
  ADD CONSTRAINT `FK_IdCourse` FOREIGN KEY (`IdCourse`) REFERENCES `course` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdEtat` FOREIGN KEY (`IdEtat`) REFERENCES `etat` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `FK_IdProblem` FOREIGN KEY (`IdProbleme`) REFERENCES `probleme` (`Id`);

--
-- Contraintes pour la table `personne`
--
ALTER TABLE `personne`
  ADD CONSTRAINT `FK_IdStatus` FOREIGN KEY (`IdStatus`) REFERENCES `typepersonne` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `photocourse`
--
ALTER TABLE `photocourse`
  ADD CONSTRAINT `Fk_IdCoursePhoto` FOREIGN KEY (`IdCourse`) REFERENCES `course` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `photoprobleme`
--
ALTER TABLE `photoprobleme`
  ADD CONSTRAINT `FK_IdPhotoProblem` FOREIGN KEY (`IdProbleme`) REFERENCES `probleme` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `probleme`
--
ALTER TABLE `probleme`
  ADD CONSTRAINT `FK_IdAdresseProblem` FOREIGN KEY (`IdAdresse`) REFERENCES `adresse` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdCourseProbleme` FOREIGN KEY (`IdCourse`) REFERENCES `course` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdTypeProbleme` FOREIGN KEY (`IdTypeProbleme`) REFERENCES `typeprobleme` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `tarification`
--
ALTER TABLE `tarification`
  ADD CONSTRAINT `FK_Vehicule` FOREIGN KEY (`PlaqueVehicule`) REFERENCES `vehicule` (`PlaqueVoiture`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_IdCarburan` FOREIGN KEY (`Carburant`) REFERENCES `typecarburant` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
