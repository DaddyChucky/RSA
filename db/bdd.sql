-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 20 mai 2020 à 16:49
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP : 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `id12508942_math`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `ID` int(11) NOT NULL,
  `registered` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`ID`, `registered`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `dico`
--

CREATE TABLE `dico` (
  `ID` int(11) NOT NULL,
  `lettre` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `dico`
--

INSERT INTO `dico` (`ID`, `lettre`) VALUES
(2, 'b'),
(3, 'c'),
(4, 'd'),
(5, 'e'),
(6, 'f'),
(7, 'g'),
(8, 'h'),
(9, 'i'),
(10, 'j'),
(11, 'k'),
(12, 'l'),
(13, 'm'),
(14, 'n'),
(15, 'o'),
(16, 'p'),
(17, 'q'),
(18, 'r'),
(19, 's'),
(20, 't'),
(21, 'u'),
(22, 'v'),
(23, 'w'),
(24, 'x'),
(25, 'y'),
(26, 'z'),
(27, 'A'),
(28, 'B'),
(29, 'C'),
(30, 'D'),
(31, 'E'),
(32, 'F'),
(33, 'G'),
(34, 'H'),
(35, 'I'),
(36, 'J'),
(37, 'K'),
(38, 'L'),
(39, 'M'),
(40, 'N'),
(41, 'O'),
(42, 'P'),
(43, 'Q'),
(44, 'R'),
(45, 'S'),
(46, 'T'),
(47, 'U'),
(48, 'V'),
(49, 'W'),
(50, 'X'),
(51, 'Y'),
(52, 'Z'),
(53, '!'),
(54, '@'),
(55, '#'),
(56, '$'),
(57, '%'),
(58, '^'),
(59, '&'),
(60, '*'),
(61, '('),
(62, ')'),
(63, '-'),
(64, '+'),
(65, '='),
(66, '_'),
(67, '`'),
(68, ';'),
(69, ':'),
(70, '\''),
(71, '|'),
(72, '\\'),
(73, '/'),
(74, 'é'),
(75, 'É'),
(76, 'è'),
(77, 'È'),
(78, 'à'),
(79, 'À'),
(80, 'ï'),
(81, 'Ï'),
(82, 'î'),
(83, 'Î'),
(84, 'ô'),
(85, 'Ô'),
(86, 'ö'),
(87, 'Ö'),
(88, '0'),
(89, '1'),
(90, '2'),
(91, '3'),
(92, '4'),
(93, '5'),
(94, '6'),
(95, '7'),
(96, '8'),
(97, '9'),
(98, 'a');

-- --------------------------------------------------------

--
-- Structure de la table `list`
--

CREATE TABLE `list` (
  `ID` int(11) NOT NULL,
  `letter` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL DEFAULT 'aucune',
  `E` bigint(255) NOT NULL DEFAULT 0,
  `n` bigint(255) NOT NULL DEFAULT 0,
  `p` bigint(255) NOT NULL DEFAULT 0,
  `q` bigint(255) NOT NULL DEFAULT 0,
  `A` bigint(255) NOT NULL DEFAULT 0,
  `D` double NOT NULL DEFAULT 0,
  `C` bigint(255) NOT NULL DEFAULT 0,
  `M` int(255) NOT NULL DEFAULT 0,
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `dico`
--
ALTER TABLE `dico`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `dico`
--
ALTER TABLE `dico`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT pour la table `list`
--
ALTER TABLE `list`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1341;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
