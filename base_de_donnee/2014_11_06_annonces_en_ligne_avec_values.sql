-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Jeu 06 Novembre 2014 à 10:34
-- Version du serveur :  5.5.34
-- Version de PHP :  5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `annonces_en_ligne`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `id_annonce` int(4) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `date_debut` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  `photos` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(4) NOT NULL,
  `id_categorie` int(4) NOT NULL,
  PRIMARY KEY (`id_annonce`),
  KEY `id_user` (`id_user`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Contenu de la table `annonces`
--

INSERT INTO `annonces` (`id_annonce`, `titre`, `text`, `date_debut`, `active`, `photos`, `id_user`, `id_categorie`) VALUES
(1, 'voiture a vendre', 'je vend ma voiture', '2014-09-18', 1, 1, 2, 1),
(2, 'moto a vendre', 'je vend ma moto', '2014-09-18', 1, 1, 2, 2),
(5, 'ordinateur à vendre', 'test', '2014-09-21', 1, 1, 2, 3),
(6, 'un_titre', 'du_texte de l''annonce', '2014-10-07', 1, 0, 15, 1),
(7, 'titre', 'textu', '2014-10-07', 1, 0, 12, 2),
(8, 'test 3', 'test 3', '2014-10-08', 1, 0, 15, 1),
(26, 'test', 'test', '2014-10-08', 1, 1, 3, 3),
(35, 'sadf', 'adsf', '2014-10-08', 1, 0, 15, 1),
(37, 'dsaf', 'asdf', '2014-10-08', 1, 0, 15, 1),
(38, 'sdaf', 'adsf', '2014-10-08', 1, 0, 15, 1),
(39, 'asdf', 'adsf', '2014-10-08', 1, 0, 15, 1),
(44, 'asdf', 'asdf', '2014-10-08', 1, 0, 15, 1),
(47, 'mein car', 'mein car', '2014-10-08', 1, 0, 2, 8),
(61, 'maison a vendre', 'je vend ma maison mais je n''ai pas de photos', '2014-10-09', 1, 0, 2, 9),
(62, 'musée a vendre ', 'je vend mon musée', '2014-10-09', 1, 1, 2, 9),
(63, 'cedric a vendre', 'il est cool', '2014-10-14', 1, 1, 15, 5),
(64, 'antonio a vendre', 'fgjkgbdsjhgh', '2014-10-14', 1, 0, 15, 9),
(65, 'Verre a vendre', 'Je vend un verre', '2014-10-15', 1, 0, 17, 9),
(66, 'demo', 'demo pour la classe', '2014-10-30', 1, 0, 2, 10),
(67, 'demo 2', 'demo pour la classe avec photos', '2014-10-30', 1, 1, 2, 10),
(68, 'ordi a vendre', 'je vend un ordinateur', '2014-10-31', 1, 0, 2, 3),
(69, 'bus a vendre', 'je vend mon bus blanc parce que je m''en sert plus', '2014-10-31', 1, 0, 15, 11),
(70, 'test texte', '**\r\n * jQuery-csv (jQuery Plugin)\r\n * version: 0.71 (2012-11-19)\r\n *\r\n * This document is licensed as free software under the terms of the\r\n * MIT License: http://www.opensource.org/licenses/mit-license.php\r\n *\r\n * Acknowledgements:\r\n * The original design and influence to implement this library as a jquery\r\n * plugin is influenced by jquery-json (http://code.google.com/p/jquery-json/).\r\n * If you''re looking to use native JSON.Stringify but want additional backwards\r\n * compatibility for browsers that don''t support it, I highly recommend you\r\n * check it out.\r\n *\r\n * A special thanks goes out to rwk@acm.org for providing a lot of valuable\r\n * feedback to the project including the core for the new FSM\r\n * (Finite State Machine) parsers. If you''re looking for a stable TSV parser\r\n * be sure to take a look at jquery-tsv (http://code.google.com/p/jquery-tsv/).', '2014-11-04', 1, 0, 2, 11);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(4) NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`) VALUES
(1, 'UNKNOW'),
(2, 'moto'),
(3, 'informatique'),
(4, 'Téléphonie'),
(5, 'Train'),
(8, 'voiture'),
(9, 'immobilier'),
(10, 'demo'),
(11, 'Bus');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id_favoris` int(4) NOT NULL AUTO_INCREMENT,
  `id_user` int(4) NOT NULL,
  `id_annonce` int(4) NOT NULL,
  PRIMARY KEY (`id_favoris`),
  KEY `id_user` (`id_user`),
  KEY `id_annonce` (`id_annonce`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `favoris`
--

INSERT INTO `favoris` (`id_favoris`, `id_user`, `id_annonce`) VALUES
(2, 2, 2),
(3, 15, 5),
(4, 9, 2),
(5, 15, 2),
(6, 15, 1),
(7, 15, 2),
(8, 15, 1),
(9, 2, 5),
(11, 2, 37),
(12, 2, 62),
(13, 17, 64),
(15, 2, 67),
(19, 18, 68),
(21, 2, 70),
(23, 15, 70);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(4) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `pseudo`, `mdp`, `mail`) VALUES
(1, 'admin', 'admin', 'admin@admin.ch'),
(2, 'moiap13', 'secret', 'moiap13@gmail.com'),
(3, 'antonio', '12345', ''),
(4, 'test', 'test', ''),
(5, 'sorcier', 'sorcier', ''),
(6, 'james', 'bond', ''),
(8, 'Bruno', 'l''portoss', ''),
(9, 'Ta', 'Dar', ''),
(10, 'ton', 'Dar', ''),
(11, 'jordan', 'tronco', ''),
(12, 'bruno', 'l''portoss', ''),
(13, 'sebastien', 'jossi', ''),
(15, 'cathy', '211110', ''),
(16, 'lunedo', 'lune', 'lunedo@la_lune.cosmos'),
(17, 'Laura', 'trucaubol', 'laura.neubauer1@gmail.com'),
(18, 'demo', 'DEMO', 'demo@demo.com'),
(19, 'Cathy.Z', 'secret', 'catherine.zosso@gmail.com'),
(20, 'Sandra1997', 'demander', 'pikichina@gmail.com');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `annonces_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`id_annonce`) REFERENCES `annonces` (`id_annonce`);
