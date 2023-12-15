-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 déc. 2023 à 14:41
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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`Id`, `Numero`, `Rue`, `NomAdresse`, `Vile`, `latitude`, `longitude`) VALUES
(1, 40, 'debut', NULL, 'mons', 42, 69),
(2, 60, 'fin', NULL, 'chaleroi', 21, 35),
(3, 20, 'accident', NULL, 'mont de l\'enlcus', 0, 0),
(4, 10, 'rue des garages', NULL, 'mons', 1, 1),
(5, 26, 'rivage', NULL, 'harichies', 1, 1),
(6, 40, 'test', NULL, 'perdu', 1, 1),
(7, 666, 'enfer', NULL, '???', 1, 1),
(8, 666, 'enfer', NULL, 'mons', 1, 1),
(9, 20, 'accident', NULL, 'charleroi', 1, 1),
(15, 9, 'rue de houdain  ', NULL, 'mons', 50.8257, 4.37067);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`Id`, `Description`, `Note`, `IdCourse`) VALUES
(1, 'le chauffeur n\'a pas parlé', 5, 2),
(2, 'le chauffeur a eu un accident', 1, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`Id`, `DateReservation`, `DistanceParcourue`, `IdClient`, `IdChauffeur`, `IdAdresseDepart`, `IdAdresseFin`, `IdTarification`, `IdMajoration`, `duree`) VALUES
(1, '2023-11-26 23:26:04', 40, 7, 10, 1, 2, 7, 1, 1000),
(2, '2023-11-26 23:42:02', 60, 8, 6, 2, 3, 8, 1, 1000),
(3, '2023-11-26 23:43:56', 90, 7, 10, 1, 2, 3, 1, 1000),
(4, '2023-12-11 19:35:55', 501, 9, 10, 1, 2, 24, 1, 1000),
(5, '2033-12-21 20:21:54', 69, 9, 6, 1, 2, 18, 1, 1000),
(6, '2031-12-17 22:51:58', 42, 6, 22, 1, 2, 31, 2, 50),
(7, '2025-12-12 08:44:59', 0, 9, 13, 4, 5, 17, 2, 3000),
(8, '2025-12-12 08:47:07', 0, 23, 10, 6, 7, 10, 1, 1000000);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lienautonome`
--

INSERT INTO `lienautonome` (`Id`, `PlaqueVehicule`, `IdChauffeur`) VALUES
(5, 'T-AUT-001', 21),
(6, 'T-AUT-002', 22);

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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liencourseetat`
--

INSERT INTO `liencourseetat` (`Id`, `Date`, `IdCourse`, `IdEtat`) VALUES
(1, '2023-12-02 21:34:41', 2, 7),
(2, '2023-12-02 22:03:01', 1, 1),
(3, '2023-12-02 22:03:08', 1, 3),
(4, '2023-12-02 22:03:16', 1, 4),
(5, '2023-12-02 22:03:23', 1, 5),
(10, '2023-12-03 09:51:20', 3, 8),
(11, '2023-12-03 09:54:00', 3, 7),
(12, '2023-12-11 18:36:12', 4, 1),
(13, '2023-12-11 18:36:31', 4, 2),
(14, '2023-12-11 18:36:31', 4, 3),
(15, '2023-12-11 19:22:57', 5, 1),
(17, '2023-12-14 21:55:47', 6, 1),
(18, '2023-12-14 21:56:28', 6, 2),
(20, '2023-12-14 22:02:22', 6, 2),
(21, '2023-12-14 22:02:31', 6, 1),
(22, '2023-12-14 22:02:35', 6, 2),
(23, '2023-12-14 22:02:58', 6, 1),
(24, '2023-12-14 23:58:44', 4, 4),
(25, '2023-12-14 23:59:26', 6, 2),
(27, '2023-12-15 08:43:48', 8, 2),
(28, '2023-12-15 08:44:11', 8, 6),
(29, '2023-12-15 08:44:15', 8, 2),
(30, '2023-12-15 08:44:35', 7, 2),
(31, '2023-12-15 08:44:43', 7, 6),
(32, '2023-12-15 08:45:16', 8, 6),
(33, '2023-12-15 08:45:33', 8, 2),
(34, '2023-12-15 08:45:37', 7, 2),
(35, '2023-12-15 08:45:42', 8, 6),
(36, '2023-12-15 08:47:26', 8, 2),
(37, '2023-12-15 08:47:28', 8, 6),
(38, '2023-12-15 09:08:15', 8, 2),
(39, '2023-12-15 09:08:42', 8, 6),
(40, '2023-12-15 09:13:45', 8, 2),
(41, '2023-12-15 09:14:09', 8, 6),
(42, '2023-12-15 09:15:19', 8, 2),
(43, '2023-12-15 09:15:26', 8, 6),
(44, '2023-12-15 09:23:56', 7, 6),
(45, '2023-12-15 09:24:02', 8, 2),
(46, '2023-12-15 09:25:08', 7, 2),
(47, '2023-12-15 09:27:50', 7, 2),
(48, '2023-12-15 09:31:15', 7, 6),
(49, '2023-12-15 09:31:19', 7, 2),
(50, '2023-12-15 09:34:23', 7, 6),
(51, '2023-12-15 09:41:06', 8, 6),
(52, '2023-12-15 09:41:13', 7, 2),
(53, '2023-12-15 09:41:15', 8, 2),
(54, '2023-12-15 09:45:50', 8, 6),
(55, '2023-12-15 09:45:53', 8, 2),
(56, '2023-12-15 09:45:59', 8, 6),
(57, '2023-12-15 09:47:11', 8, 2),
(58, '2023-12-15 09:47:13', 7, 6),
(59, '2023-12-15 09:49:18', 8, 6),
(60, '2023-12-15 09:49:22', 7, 2),
(61, '2023-12-15 09:49:26', 8, 2),
(62, '2023-12-15 09:49:28', 8, 6),
(63, '2023-12-15 09:50:17', 8, 2),
(64, '2023-12-15 09:50:40', 8, 2),
(65, '2023-12-15 09:51:07', 8, 2),
(66, '2023-12-15 09:52:23', 8, 2),
(67, '2023-12-15 09:53:41', 8, 2),
(68, '2023-12-15 09:55:11', 8, 2),
(69, '2023-12-15 09:56:06', 8, 2),
(70, '2023-12-15 09:57:49', 8, 2),
(71, '2023-12-15 10:05:06', 8, 2),
(72, '2023-12-15 10:06:41', 8, 2),
(73, '2023-12-15 10:06:55', 8, 6),
(74, '2023-12-15 10:06:57', 8, 2),
(75, '2023-12-15 10:08:39', 8, 2),
(76, '2023-12-15 10:09:35', 8, 2),
(77, '2023-12-15 10:10:22', 8, 6),
(78, '2023-12-15 10:10:25', 8, 2),
(79, '2023-12-15 10:12:41', 8, 6),
(81, '2023-12-15 13:35:55', 7, 1),
(82, '2023-12-15 13:48:59', 8, 2),
(83, '2023-12-15 13:49:10', 4, 7),
(84, '2023-12-15 13:49:13', 8, 4);

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
('???', 666),
('chaleroi', 6000),
('charleroi', 9000),
('harichies', 7810),
('mons', 7000),
('mont de l\'enlcus', 7750),
('perdu', 9999);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`Id`, `Description`, `DateDebut`, `DateFin`, `IdProbleme`) VALUES
(1, 'reparation', '2023-11-15', '2023-11-30', 1),
(2, 'essaie d\'ajout d\'une nouvelle maintenance', '2023-12-02', '2023-12-23', 2),
(3, 'test', '2023-12-31', '2024-01-06', 2),
(4, 'entretien', '2023-12-17', '2023-12-24', 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

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
(20, 'Autonome', 'supprimer', 'taxeasy', 'autonome', 65000000, 6),
(21, 'Autonome', 'T-AUT-001', 'taxeasy', 'autonome', 65000000, 6),
(22, 'Autonome', 'T-AUT-002', 'taxeasy', 'autonome', 65000000, 6),
(23, 'client2', 'demo', 'client2@demo.be', '$2y$10$8VhUnYFZyuQ5Xp2NQz/iIewcvbXiK7MR6ojhXPwKK246V8VTARvzK', 479000000, 1),
(25, 'client', 'abanir', 'client@abanir.be', '$2y$10$6Ilp5qH7pjFidkRaZedy7.wUC4WcmSysrG1nE.CJmYz6aepVV4lTW', 78965443, 4),
(26, 'demo2', 'client', 'demo2@client.be', '$2y$10$3nDKNGIJ4sTzveHFTppq3.XSVS4N8zZsxmXabUNX.Nf5ulEq8tZIC', 456, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photocourse`
--

INSERT INTO `photocourse` (`Id`, `CheminDAcces`, `IdCourse`) VALUES
(3, 'course/3/0.jpg', 3),
(4, 'course/3/1.jpg', 1),
(5, 'course/3/2.jpg', 1),
(6, 'course/3/0.jpg', 3),
(7, 'course/3/1.jpg', 3),
(8, 'course/3/2.jpg', 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photoprobleme`
--

INSERT INTO `photoprobleme` (`Id`, `CheminDAcces`, `IdProbleme`) VALUES
(1, 'probleme/2/image1.jpg', 2),
(2, 'probleme/2/image2.jpg', 2),
(3, 'probleme/2/image3.jpg', 2),
(8, 'probleme/4/0.jpg', 4),
(9, 'probleme/4/0.jpg', 4),
(10, 'probleme/4/1.jpg', 4),
(11, 'probleme/4/2.jpg', 4),
(12, 'probleme/4/3.jpg', 4),
(13, 'probleme/4/4.jpg', 4),
(14, 'probleme/4/5.jpg', 4),
(15, 'probleme/1/0.jpg', 1),
(16, 'probleme/1/1.jpg', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `probleme`
--

INSERT INTO `probleme` (`Id`, `Description`, `Regle`, `Rouler`, `IdCourse`, `IdAdresse`, `IdTypeProbleme`) VALUES
(1, 'crash avec camion et une camionette', 1, 0, 1, 9, 5),
(2, 'autre accident', 1, 1, 1, 3, 4),
(3, 'accident', 0, 1, 2, 3, 4),
(4, ' Entretient périodique  ', 1, 0, 3, 4, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tarification`
--

INSERT INTO `tarification` (`Id`, `PrixAuKilometre`, `Date`, `PlaqueVehicule`) VALUES
(1, 1, '2023-11-26 21:39:14', '2avh069'),
(2, 2, '2023-11-26 21:44:59', '2avh069'),
(3, 1.5, '2023-11-26 22:13:11', '2avh069'),
(4, 1, '2023-11-26 22:53:25', '1ahe302'),
(5, 1, '2023-11-26 22:53:34', '1csx987'),
(6, 42, '2023-11-26 23:04:44', '1ahe302'),
(7, 3, '2023-11-26 23:06:39', '1ahe302'),
(8, 1.5, '2023-11-27 07:28:16', '2avh069'),
(9, 2, '2023-11-27 07:30:44', '2avh069'),
(10, 10, '2023-11-27 09:12:09', '1yme000'),
(11, 1.37, '2023-11-27 17:14:52', NULL),
(15, 50, '2023-11-28 08:25:40', 'Aacb998'),
(16, 6, '2023-12-01 14:45:36', '2avh069'),
(17, 10, '2023-12-01 15:46:06', '1ahe302'),
(18, 2, '2023-12-01 15:46:32', NULL),
(19, 4, '2023-12-02 11:23:46', NULL),
(20, 4, '2023-12-02 11:25:00', NULL),
(21, 4, '2023-12-02 11:25:02', NULL),
(22, 4, '2023-12-02 11:25:03', NULL),
(23, 4, '2023-12-02 11:25:03', NULL),
(24, 7, '2023-12-02 11:32:17', '2avh069'),
(25, 7.1, '2023-12-02 11:33:59', '2avh069'),
(26, 20, '2023-12-12 21:54:03', NULL),
(28, 666, '2023-12-14 15:59:24', 'T-AUT-001'),
(29, 667, '2023-12-14 15:59:28', 'T-AUT-001'),
(30, 668, '2023-12-14 15:59:33', 'T-AUT-001'),
(31, 300, '2023-12-14 16:10:08', 'T-AUT-002'),
(32, 5, '2023-12-15 14:42:26', '2avh069');

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
(4, 'Essence Hybrirde'),
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typepersonne`
--

INSERT INTO `typepersonne` (`Id`, `NomTitre`) VALUES
(1, 'Client'),
(2, 'Chauffeur'),
(3, 'Admin'),
(4, 'Banni'),
(5, 'Attente'),
(6, 'Autonome');

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
(1, 'Entretient'),
(2, 'Degat leger carrosserie'),
(3, 'Degat lourd carrosserie'),
(4, 'Accident leger'),
(5, 'perte totale');

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
('1ahe302', 'skoda', 'fabia', 'beige', 2011, 1, 200000, 4, '0'),
('1csx987', 'volkwagen', 'polo 6', 'grise', 2012, 1, 130000, 4, 'Non'),
('1yme000', 'volkwagen', 'golf', 'noir', 2019, 1, 30000, 4, 'Non'),
('2avh069', 'peugeot', '208', 'rouge', 2017, 5, 113501, 4, 'PMR'),
('Aacb998', 'memee', 'mee', '?', 99, 1, 66550, 50, 'Non'),
('T-AUT-001', 'Tesla du futur', 'MAGIQUE', 'peu importe', 546, 5, 153, 100, 'PMR'),
('T-AUT-002', 'Tesla du futur', 'MAGIQUE2', 'gris', 4564665, 5, 48456465, 5, 'PMR');

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
