-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 17 mars 2023 à 21:35
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `idec`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `idAdmin` int(11) NOT NULL,
  `nomComplet` text NOT NULL,
  `pseudo` text NOT NULL,
  `motDePasse` text NOT NULL,
  `secret` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`idAdmin`, `nomComplet`, `pseudo`, `motDePasse`, `secret`) VALUES
(1, 'Mohamed Fatehi ', 'admin', 'aq17b902e6ff1db9f560443f2048974fd7d386975b025', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `idAgent` int(11) NOT NULL,
  `nomComplet` text NOT NULL,
  `pseudo` text NOT NULL,
  `motDePasse` text NOT NULL,
  `secret` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`idAgent`, `nomComplet`, `pseudo`, `motDePasse`, `secret`) VALUES
(1, 'Ayman kuharou', 'agent', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d25', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d25'),
(2, 'Oussama kubia', 'agent', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d25', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2'),
(3, 'Hamid panashi', 'agent', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2'),
(4, 'nabil benha', 'agent', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2'),
(5, 'Mouad zaidi', 'agent', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2'),
(6, 'Mohamed bernousi', 'agent', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2', 'aq1a72ec489e40f952e51e7dfcbaa239a69c8e8a04d2');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `idClient` int(11) NOT NULL,
  `fullName` text NOT NULL,
  `email` text NOT NULL,
  `idZoneGeographique` int(11) NOT NULL,
  `adresse` text NOT NULL,
  `motDePasse` text NOT NULL,
  `secret` text NOT NULL,
  `difference` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`idClient`, `fullName`, `email`, `idZoneGeographique`, `adresse`, `motDePasse`, `secret`, `difference`) VALUES
(5, 'mohamed alhabib', 'mohamedfatehialhabib@gmail.com', 4, '48 rue mutapha elmanfalouti ', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '26a552ad89516677553ca4e640bdc29a7ec7163d16770873891677087389', NULL),
(6, 'Simo Fatt', 'simosins78@gmail.com', 6, 'anfa', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '8da9c55feb4d686820e711d31a691a28da17933116776906111677690611', NULL),
(7, 'Oussama', 'Oussamak@gmail.com', 3, 'Maarif', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '440821b2cb68217eb290b7907e17e5c38c77d4b016777679221677767922', NULL),
(8, 'hamid do', 'hamid@gmail.com', 1, 'Casablanca', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', 'db8750732e75312812612bce31bab6d31bc3389916779736151677973615', NULL),
(9, 'Youssef', 'youssef@gmail.com', 3, 'Mhanesh', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '65979449616c15df2bc5e4ccdef50b6a6b89a80416780601731678060173', NULL),
(10, 'Mohamed Fatehi ALhabib', 'mohamedfatehielhabib@gmail.com', 1, 'Mohamed', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '73949d5ec9c72fab674399c48258edd06323964a16781021461678102146', NULL),
(11, 'Amine safidine', 'amine@gmail.com', 2, 'maarif', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '506afdf50cf0d573bb7e853fc55da671119b1aaa16781031811678103181', NULL),
(12, 'Abdelali Fatehi', 'abdelalifatehi48@gmail.com', 1, '48 Rue mustapha El manfalouti', 'aq17b69957d822a37b1999123d94197b5e34cbd3ba825', '686ceaafc6389a35f8fcca94b992a115719c9d5616782110291678211029', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `consommation_annuelle`
--

CREATE TABLE `consommation_annuelle` (
  `idComsommation` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idZoneGeo` int(11) NOT NULL,
  `consommationAnnuelle` int(11) NOT NULL,
  `date_saisie` date NOT NULL,
  `difference` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consommation_annuelle`
--

INSERT INTO `consommation_annuelle` (`idComsommation`, `idClient`, `idZoneGeo`, `consommationAnnuelle`, `date_saisie`, `difference`) VALUES
(4, 5, 2, 3000, '2023-12-30', 0);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `idFacture` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `consommation` float NOT NULL,
  `dateFacture` date NOT NULL,
  `prixHT` float NOT NULL,
  `prixTTC` float NOT NULL,
  `adresseImg` text NOT NULL,
  `Etat` text NOT NULL DEFAULT 'nonPayée',
  `statut` text NOT NULL,
  `Année` year(4) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`idFacture`, `idClient`, `consommation`, `dateFacture`, `prixHT`, `prixTTC`, `adresseImg`, `Etat`, `statut`, `Année`) VALUES
(17, 5, 100, '2023-08-01', 91, 103.74, '../uploads/51677688003945791435.PNG', 'Payée', 'validée', 2023),
(45, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779745932139630005.PNG', 'Payée', 'validée', 2023),
(46, 8, 200, '2023-03-05', 202, 230.28, '../uploads/81677974658481527044.PNG', 'nonPayée', 'validée', 2023),
(47, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779747501073526899.PNG', 'nonPayée', 'validée', 2023),
(48, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779749631235348183.PNG', 'nonPayée', 'validée', 2023),
(49, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779751141021163854.PNG', 'nonPayée', 'validée', 2023),
(50, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779752031607877179.PNG', 'nonPayée', 'validée', 2023),
(51, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779752451347764127.PNG', 'nonPayée', 'validée', 2023),
(52, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779753041704082013.PNG', 'nonPayée', 'validée', 2023),
(53, 8, 200, '2023-03-05', 202, 230.28, '../uploads/816779757841525878845.PNG', 'nonPayée', 'validée', 2023),
(54, 8, 200, '2023-03-05', 202, 230.28, '../uploads/8167797648825244024.PNG', 'nonPayée', 'validée', 2023),
(55, 8, 200, '2023-03-05', 202, 230.28, '../uploads/81677976688713845914.PNG', 'nonPayée', 'validée', 2023),
(60, 11, 100, '2023-02-01', 91, 103.74, '../uploads/111678280629986560862.PNG', 'Payée', 'validée', 0000),
(2025, 11, 100, '2023-02-08', 91, 103.74, '../uploads/11167828182557663305.PNG', 'Payée', 'validée', 2023),
(2027, 11, 200, '2023-02-10', 202, 230.28, '../uploads/1116782902471272457995.PNG', 'nonPayée', 'validée', 2023),
(2028, 11, 200, '2023-02-16', 202, 230.28, '../uploads/1116782904351267871393.PNG', 'nonPayée', 'validée', 2023),
(2030, 11, 200, '2023-05-08', 202, 230.28, '../uploads/1116782913011462695287.PNG', 'nonPayée', 'validée', 2023),
(2036, 5, 200, '2023-06-08', 202, 230.28, '../uploads/51678293164768402787.PNG', 'Payée', 'validée', 2023),
(2042, 5, 500, '2023-09-08', 560, 638.4, '../uploads/51678293876933119032.PNG', 'Payée', 'validée', 2023),
(2043, 5, 200, '2023-07-07', 202, 230.28, '../uploads/516782939372053701738.PNG', 'Payée', 'validée', 2023),
(2044, 5, 500, '2023-10-07', 560, 638.4, '../uploads/51678294052731961504.PNG', 'Payée', 'validée', 2023),
(2045, 5, 200, '2023-11-03', 202, 230.28, '../uploads/516782941951545829885.PNG', 'Payée', 'validée', 2023),
(2046, 5, 200, '2023-01-07', 202, 230.28, '../uploads/516782942751422807481.PNG', 'Payée', 'validée', 2023),
(2047, 5, 200, '2023-02-16', 202, 230.28, '../uploads/51678294461266958412.PNG', 'Payée', 'validée', 2023),
(2048, 5, 200, '2023-12-08', 202, 230.28, '../uploads/51678295917362353072.PNG', 'Payée', 'validée', 2023),
(2049, 5, 400, '2023-05-08', 504, 574.56, '../uploads/51678295955801954163.PNG', 'Payée', 'validée', 2023),
(2050, 6, 200, '2023-05-09', 202, 230.28, '../uploads/616783198001119454133.PNG', 'Payée', 'validée', 2023),
(2051, 6, 500, '2023-02-09', 560, 638.4, '../uploads/616783198362093547104.PNG', 'nonPayée', 'validée', 2023),
(2052, 6, 200, '2023-01-09', 202, 230.28, '../uploads/61678320135166577589.PNG', 'Payée', 'validée', 2023),
(2058, 6, 450, '2023-05-09', 504, 574.56, '../uploads/616783608001530698926.png', 'nonPayée', 'validée', 2023),
(2059, 6, 500, '2023-06-09', 560, 638.4, '../uploads/61678360890129333641.PNG', 'nonPayée', 'validée', 2023),
(2060, 6, 500, '2023-02-09', 560, 638.4, '../uploads/61678360976167061029.png', 'nonPayée', 'validée', 2023),
(2061, 5, 200, '2023-03-09', 202, 230.28, '../uploads/51678370780857608168.png', 'Payée', 'validée', 2023),
(2062, 5, 450, '2023-04-09', 504, 574.56, '../uploads/516783708731340919248.PNG', 'nonPayée', 'nonValidée', 2023);

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `idReclamation` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `sujetReclamation` text NOT NULL,
  `reclamation` text NOT NULL,
  `reponse` text DEFAULT NULL,
  `dateReclamation` date NOT NULL DEFAULT current_timestamp(),
  `etat` text NOT NULL DEFAULT 'non_traitée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`idReclamation`, `idClient`, `sujetReclamation`, `reclamation`, `reponse`, `dateReclamation`, `etat`) VALUES
(2, 5, 'Demande de partenariat', 'ss', 'ssssssssssss', '2023-03-01', 'traitée'),
(4, 5, 'anfa', 'Aaaaa', 'Votre demande sera traitée prochainement, un agent viendra verifier d\'ici 24heure ', '2023-03-06', 'traitée'),
(5, 11, 'Fuite externe/interne', 'vbvvvvvvvvvvv', 'vvvvvvvvvvvvvv', '2023-03-08', 'traitée'),
(6, 5, 'Fuite externe/interne', 'Je veux une un technicien ', 'Ok ', '2023-03-08', 'traitée'),
(7, 5, 'Fuite externe/interne', 'xxx', 'xxxxxxxx', '2023-03-08', 'traitée'),
(8, 5, 'anfa', 'ww', NULL, '2023-03-08', 'non_traitée'),
(9, 6, 'anfa', 'HHAHAHAHAHAHIZDHIOADAOI', NULL, '2023-03-09', 'non_traitée'),
(10, 5, 'Fuite externe/interne', 'j\'xige un technicien ', 'un technicien viendra dans 24h ', '2023-03-09', 'traitée'),
(11, 5, 'Fuite externe/interne', 'hhh', NULL, '2023-03-09', 'non_traitée');

-- --------------------------------------------------------

--
-- Structure de la table `zonegeographique`
--

CREATE TABLE `zonegeographique` (
  `idZoneGeo` int(11) NOT NULL,
  `nomZoneGeo` text NOT NULL,
  `idAgent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `zonegeographique`
--

INSERT INTO `zonegeographique` (`idZoneGeo`, `nomZoneGeo`, `idAgent`) VALUES
(1, 'Maarif', 1),
(2, 'Anfa', 2),
(3, 'Beausejor', 3),
(4, 'Derb Sultan', 4),
(5, 'Derb Omar', 5),
(6, 'Oasis', 6);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`idAgent`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idClient`),
  ADD KEY `FK_ForeignKey6` (`idZoneGeographique`);

--
-- Index pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  ADD PRIMARY KEY (`idComsommation`),
  ADD KEY `FK_ForeignKey4` (`idClient`),
  ADD KEY `FK_ForeignKey5` (`idZoneGeo`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idFacture`),
  ADD KEY `FK_ForeignKey3` (`idClient`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`idReclamation`),
  ADD KEY `FK_ForeignKey2` (`idClient`);

--
-- Index pour la table `zonegeographique`
--
ALTER TABLE `zonegeographique`
  ADD PRIMARY KEY (`idZoneGeo`),
  ADD KEY `FK_ForeignKey` (`idAgent`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `idAgent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  MODIFY `idComsommation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `idFacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2063;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `idReclamation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `zonegeographique`
--
ALTER TABLE `zonegeographique`
  MODIFY `idZoneGeo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `FK_ForeignKey6` FOREIGN KEY (`idZoneGeographique`) REFERENCES `zonegeographique` (`idZoneGeo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  ADD CONSTRAINT `FK_ForeignKey4` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ForeignKey5` FOREIGN KEY (`idZoneGeo`) REFERENCES `zonegeographique` (`idZoneGeo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `FK_ForeignKey3` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_ForeignKey2` FOREIGN KEY (`idClient`) REFERENCES `clients` (`idClient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `zonegeographique`
--
ALTER TABLE `zonegeographique`
  ADD CONSTRAINT `FK_ForeignKey` FOREIGN KEY (`idAgent`) REFERENCES `agent` (`idAgent`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
