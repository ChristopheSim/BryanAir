-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 30 nov. 2017 à 07:59
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bryanair`
--

-- --------------------------------------------------------

--
-- Structure de la table `airport`
--

DROP TABLE IF EXISTS `airport`;
CREATE TABLE IF NOT EXISTS `airport` (
  `IATA` varchar(3) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`IATA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `airport`
--

INSERT INTO `airport` (`IATA`, `name`) VALUES
('BRK', 'Baraki'),
('CRL', 'Charleroi'),
('UTL', 'Torremolinos');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `ID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `flights`
--

DROP TABLE IF EXISTS `flights`;
CREATE TABLE IF NOT EXISTS `flights` (
  `number` int(4) UNSIGNED NOT NULL,
  `departure` varchar(3) NOT NULL,
  `arrival` varchar(3) NOT NULL,
  `seats` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`number`),
  KEY `departure` (`departure`),
  KEY `arrival` (`arrival`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `flights`
--

INSERT INTO `flights` (`number`, `departure`, `arrival`, `seats`) VALUES
(3657, 'CRL', 'UTL', 150),
(3658, 'UTL', 'CRL', 150),
(9678, 'CRL', 'BRK', 150),
(9679, 'BRK', 'CRL', 150);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client` int(6) UNSIGNED NOT NULL,
  `flight` int(4) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `client` (`client`),
  KEY `flight` (`flight`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `arrival` FOREIGN KEY (`arrival`) REFERENCES `airport` (`IATA`),
  ADD CONSTRAINT `departure` FOREIGN KEY (`departure`) REFERENCES `airport` (`IATA`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `client` FOREIGN KEY (`client`) REFERENCES `clients` (`ID`),
  ADD CONSTRAINT `flight` FOREIGN KEY (`flight`) REFERENCES `flights` (`number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
