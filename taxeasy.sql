-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 26 nov. 2023 à 22:52
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
  PRIMARY KEY (`Id`),
  KEY `FK_Ville` (`Vile`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`Id`, `Numero`, `Rue`, `NomAdresse`, `Vile`) VALUES
(1, 40, 'debut', NULL, 'mons'),
(2, 60, 'fin', NULL, 'chaleroi'),
(3, 20, 'accident', NULL, 'mont de l\'enlcus');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`Id`),
  KEY `FK_IdAdresseDepart` (`IdAdresseDepart`),
  KEY `FK_IdAdresseFin` (`IdAdresseFin`),
  KEY `FK_IdMajoration` (`IdMajoration`),
  KEY `FK_IdTarification` (`IdTarification`),
  KEY `FK_IdChauffeur` (`IdChauffeur`),
  KEY `FK_IdClient` (`IdClient`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`Id`, `DateReservation`, `DistanceParcourue`, `IdClient`, `IdChauffeur`, `IdAdresseDepart`, `IdAdresseFin`, `IdTarification`, `IdMajoration`) VALUES
(1, '2023-11-26 23:26:04', 40, 7, 6, 1, 2, 7, 1),
(2, '2023-11-26 23:42:02', 60, 8, 6, 2, 3, 3, 1),
(3, '2023-11-26 23:43:56', 90, 7, 6, 1, 2, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`Id`, `Nom`) VALUES
(1, 'Reservée'),
(2, 'Chauffeur en route'),
(3, 'En cours'),
(4, 'Annulé par client'),
(5, 'Annulé par chauffeur'),
(6, 'Terminé'),
(7, 'Paye');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('chaleroi', 6000),
('mons', 7000),
('mont de l\'enlcus', 7750);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`Id`, `Nom`, `Prenom`, `Email`, `Mdp`, `NumeroDeTelephone`, `IdStatus`) VALUES
(6, 'test', 'test', 'test.test@test.test', '$2y$10$lHHfwPjCkspNTqID9LGfWuT5Tt8DCpDuFOdBdnveSFOZ0MW48NzSy', 479739695, 1),
(7, 'aa', 'aa', 'aa@aa.be', '$2y$10$.fvEITUNJfBwphA1.Oc/2O7ZNAdOAaByxUKaew1BLV3PVLPPge0aa', 0, 1),
(8, 'admin', 'admin2', 'admin@admin.be', '$2y$10$UqCLTVPPRuhWdxBvoKiCAeEcCpM/Cw3Ir81eaQnFyi.94DNhzMFjq', 0, 3);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `probleme`
--

INSERT INTO `probleme` (`Id`, `Description`, `Regle`, `Rouler`, `IdCourse`, `IdAdresse`, `IdTypeProbleme`) VALUES
(1, 'crash avec camion', 1, 0, 1, 3, 5),
(2, 'autre accident', 0, 1, 1, 3, 4),
(3, 'accident', 0, 1, 2, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `tarification`
--

DROP TABLE IF EXISTS `tarification`;
CREATE TABLE IF NOT EXISTS `tarification` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PrixAuKilometre` float NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PlaqueVehicule` varchar(12) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_Vehicule` (`PlaqueVehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
(7, 3, '2023-11-26 23:06:39', '1ahe302');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typemajoration`
--

INSERT INTO `typemajoration` (`Id`, `Nom`, `Coefficient`) VALUES
(1, 'normal', 1);

-- --------------------------------------------------------

--
-- Structure de la table `typepersonne`
--

DROP TABLE IF EXISTS `typepersonne`;
CREATE TABLE IF NOT EXISTS `typepersonne` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `NomTitre` varchar(12) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typepersonne`
--

INSERT INTO `typepersonne` (`Id`, `NomTitre`) VALUES
(1, 'Client'),
(2, 'Chauffeur'),
(3, 'Admin'),
(4, 'Banni');

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
(2, 'Dégât léger carrosserie'),
(3, 'Dégât lourd carrosserie'),
(4, 'Accident léger'),
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
('1csx987', 'volkwagen', 'polo 6', 'grise', 2012, 1, 130000, 4, '0'),
('1yme000', 'volkwagen', 'golf', 'noir', 2019, 1, 30000, 4, '0'),
('2avh069', 'peugeot', '208', 'rouge', 2017, 5, 113000, 4, 'PMR');

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
  ADD CONSTRAINT `FK_Vehicule` FOREIGN KEY (`PlaqueVehicule`) REFERENCES `vehicule` (`PlaqueVoiture`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_IdCarburan` FOREIGN KEY (`Carburant`) REFERENCES `typecarburant` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
