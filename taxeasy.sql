-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 nov. 2023 à 15:17
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Paye` tinyint(1) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`Id`, `Nom`) VALUES
(1, 'Reservée'),
(2, 'Chauffeur en route'),
(3, 'En cours'),
(4, 'Annulé par client'),
(5, 'Annulé par chauffeur'),
(6, 'Terminé');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personne`
--

INSERT INTO `personne` (`Id`, `Nom`, `Prenom`, `Email`, `Mdp`, `NumeroDeTelephone`, `IdStatus`) VALUES
(6, 'test', 'test', 'test.test@test.test', '$2y$10$lHHfwPjCkspNTqID9LGfWuT5Tt8DCpDuFOdBdnveSFOZ0MW48NzSy', 479739695, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `typemajoration`
--

DROP TABLE IF EXISTS `typemajoration`;
CREATE TABLE IF NOT EXISTS `typemajoration` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` int(11) NOT NULL,
  `Coefficient` float NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `Annee` date NOT NULL,
  `Carburant` varchar(30) NOT NULL,
  `Kilometrage` int(11) NOT NULL,
  `PlaceDisponible` int(11) NOT NULL,
  `PMR` tinyint(1) NOT NULL,
  PRIMARY KEY (`PlaqueVoiture`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
