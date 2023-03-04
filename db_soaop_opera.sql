-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Erstellungszeit: 05. Okt 2022 um 11:21
-- Server-Version: 5.7.31
-- PHP-Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `soap_opera`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `adresse`
--

DROP TABLE IF EXISTS `adresse`;
CREATE TABLE IF NOT EXISTS `adresse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_rue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `adresse`
--

INSERT INTO `adresse` (`id`, `numero_rue`, `code_postal`, `rue`, `ville`, `pays`) VALUES
(13, '6', '4700', 'Bla', 'Eupen', 'BE'),
(15, '40', '4700', 'Bla', 'Eupen', 'BE'),
(17, '67', '4728', 'Aachener Straße', 'Hergenrath', 'BE'),
(18, '15', '4700', 'Bla', 'Eupen', 'BE'),
(19, '400', '4700', 'Bla', 'Eupen', 'BE'),
(20, '6', '47000', 'Bla', 'Aachen', 'DE'),
(29, '600', '4700', 'Bla', 'Eupen', 'BE'),
(30, '123', '4700', 'Bla', 'Eupen', 'BE'),
(31, '100', '4700', 'Bla', 'Eupen', 'BE'),
(32, '50', '4700', 'Bla', 'Eupen', 'BE'),
(34, '700', '4700', 'Bla', 'Eupen', 'BE'),
(35, '750', '4700', 'Bla', 'Eupen', 'BE'),
(36, '12', '52600', 'Blu', 'Aachen', 'DE'),
(37, '13', '52600', 'Blu', 'Aachen', 'DE'),
(38, '12', '52600', 'blu', 'Aachen', 'DE'),
(39, '218', '52064', 'Jakobstrasse', 'Aachen', 'DE'),
(40, '2a', '4720', 'Kirchplatz', 'Kelmis', 'BE'),
(41, '1', '4720', 'Schützenstraße', 'Kelmis', 'BE'),
(42, '5', '4700', 'Bla', 'Eupen', 'BE'),
(43, '10', '47000', 'Blu', 'Eupen', 'BE'),
(44, '200', '4700', 'Blu', 'Eupen', 'BE'),
(45, '5', '4700', 'Blu', 'Eupen', 'BE');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant_hors_tva` double NOT NULL,
  `en_avant` tinyint(1) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_ventes` int(11) NOT NULL,
  `taux_tva` double NOT NULL,
  `odeur_id` int(11) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66BCF5E72D` (`categorie_id`),
  KEY `IDX_23A0E66222D80EB` (`odeur_id`),
  KEY `IDX_23A0E66139DF194` (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `article`
--

INSERT INTO `article` (`id`, `montant_hors_tva`, `en_avant`, `categorie_id`, `nom_backend`, `nombre_ventes`, `taux_tva`, `odeur_id`, `date_creation`, `promotion_id`) VALUES
(1, 983, 1, 4, 'Rise & Shine', 508, 0.21, 2, '2022-05-02 11:12:00', 8),
(2, 983, 1, 4, 'Leave-In', 12, 0.21, 3, '2022-04-30 18:13:00', NULL),
(3, 496, 1, 1, 'I am', 54, 0.21, 2, '2022-04-25 19:13:00', NULL),
(4, 496, 1, 1, 'Fresh Coriander', 37, 0.21, 3, '2022-04-26 18:13:00', NULL),
(5, 900, 1, 2, 'Wash & Joy', 42, 0.21, 2, '2022-04-25 20:14:00', NULL),
(6, 900, 1, 2, 'Brush & Joy', 19, 0.21, NULL, '2022-04-26 22:14:00', NULL),
(7, 562, 1, 3, 'Refresh Creme', 59, 0.21, 2, '2022-04-27 20:15:00', NULL),
(8, 645, 1, 3, 'Refresh Roll-On', 16, 0.21, 2, '2022-04-28 19:15:00', NULL),
(9, 661, 1, 6, 'Seifenigel', 16, 0.21, NULL, '2022-04-18 11:19:00', NULL),
(10, 372, 1, 6, 'Scrubby', 19, 0.21, NULL, '2022-04-25 00:16:00', NULL),
(11, 496, 1, 5, 'I am Kerze', 66, 0.21, 2, '2022-04-25 18:21:00', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article_beurre`
--

DROP TABLE IF EXISTS `article_beurre`;
CREATE TABLE IF NOT EXISTS `article_beurre` (
  `article_id` int(11) NOT NULL,
  `beurre_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`beurre_id`),
  KEY `IDX_E4AE027C7294869C` (`article_id`),
  KEY `IDX_E4AE027CE2C7E8A9` (`beurre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `article_beurre`
--

INSERT INTO `article_beurre` (`article_id`, `beurre_id`) VALUES
(3, 1),
(4, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article_huile`
--

DROP TABLE IF EXISTS `article_huile`;
CREATE TABLE IF NOT EXISTS `article_huile` (
  `article_id` int(11) NOT NULL,
  `huile_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`huile_id`),
  KEY `IDX_F7A0A8FD7294869C` (`article_id`),
  KEY `IDX_F7A0A8FD3EBD4426` (`huile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `article_huile`
--

INSERT INTO `article_huile` (`article_id`, `huile_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 4),
(3, 7),
(4, 1),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(5, 7),
(6, 7),
(7, 4),
(11, 4),
(11, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article_huile_essentiel`
--

DROP TABLE IF EXISTS `article_huile_essentiel`;
CREATE TABLE IF NOT EXISTS `article_huile_essentiel` (
  `article_id` int(11) NOT NULL,
  `huile_essentiel_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`huile_essentiel_id`),
  KEY `IDX_728ACBAB7294869C` (`article_id`),
  KEY `IDX_728ACBAB55CA86AD` (`huile_essentiel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `article_huile_essentiel`
--

INSERT INTO `article_huile_essentiel` (`article_id`, `huile_essentiel_id`) VALUES
(1, 1),
(7, 2),
(8, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `article_ingredient_supplementaire`
--

DROP TABLE IF EXISTS `article_ingredient_supplementaire`;
CREATE TABLE IF NOT EXISTS `article_ingredient_supplementaire` (
  `article_id` int(11) NOT NULL,
  `ingredient_supplementaire_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`ingredient_supplementaire_id`),
  KEY `IDX_3042176B7294869C` (`article_id`),
  KEY `IDX_3042176B491BCAD2` (`ingredient_supplementaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `article_ingredient_supplementaire`
--

INSERT INTO `article_ingredient_supplementaire` (`article_id`, `ingredient_supplementaire_id`) VALUES
(1, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(4, 8),
(4, 10),
(4, 11),
(5, 3),
(5, 5),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17),
(5, 18),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 14),
(6, 15),
(6, 16),
(6, 17),
(6, 18),
(7, 19),
(7, 20),
(7, 21),
(8, 1),
(8, 3),
(8, 14),
(8, 15),
(8, 22),
(9, 23),
(10, 24),
(11, 19);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beurre`
--

DROP TABLE IF EXISTS `beurre`;
CREATE TABLE IF NOT EXISTS `beurre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `beurre`
--

INSERT INTO `beurre` (`id`, `nom_backend`) VALUES
(1, 'Mangobutter'),
(2, 'Sheabutter');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `statut_menu` tinyint(1) NOT NULL,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_497DD634139DF194` (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `categorie`
--

INSERT INTO `categorie` (`id`, `statut_menu`, `nom_backend`, `promotion_id`, `couleur`) VALUES
(1, 1, 'Seife', 5, '#00ffee'),
(2, 1, 'Duschgel / Shampoo', NULL, '#37ff00'),
(3, 1, 'Deodorant', NULL, '#002aff'),
(4, 1, 'Pflege', NULL, '#fbff00'),
(5, 1, 'Kerzen', NULL, '#ae00ff'),
(6, 1, 'Zubehör', NULL, '#ff7300');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date_commentaire` datetime NOT NULL,
  `publication` tinyint(1) NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BC7294869C` (`article_id`),
  KEY `IDX_67F068BCFB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `commentaire`
--

INSERT INTO `commentaire` (`id`, `article_id`, `utilisateur_id`, `date_commentaire`, `publication`, `contenu`) VALUES
(2, 1, 25, '2022-08-20 09:31:22', 1, 'Hello Julia du bist geil!'),
(3, 1, 22, '2022-06-20 15:49:44', 1, 'Article superbe'),
(4, 1, 25, '2022-06-20 16:08:34', 1, 'This is great!'),
(5, 1, 22, '2022-06-29 09:40:40', 1, 'JuliaTest'),
(6, 7, 22, '2022-07-10 11:31:28', 1, 'Toller Artikel!'),
(8, 2, 25, '2022-07-28 15:42:24', 1, 'Hello 23'),
(9, 1, 25, '2022-09-08 11:17:59', 1, 'Great stuff test ');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `detail_commande_article`
--

DROP TABLE IF EXISTS `detail_commande_article`;
CREATE TABLE IF NOT EXISTS `detail_commande_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `facture_id` int(11) NOT NULL,
  `montant_total` double NOT NULL,
  `article_id` int(11) NOT NULL,
  `montant_total_hors_tva` double NOT NULL,
  `montant_tva` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D68E2DEA7F2DEE08` (`facture_id`),
  KEY `IDX_D68E2DEA7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `detail_commande_article`
--

INSERT INTO `detail_commande_article` (`id`, `quantite`, `facture_id`, `montant_total`, `article_id`, `montant_total_hors_tva`, `montant_tva`) VALUES
(45, 1, 113, 600, 11, 496, 104),
(46, 1, 114, 951, 1, 786, 165),
(47, 1, 115, 600, 11, 496, 104),
(48, 1, 116, 600, 11, 496, 104),
(49, 1, 117, 600, 11, 496, 104),
(50, 1, 118, 600, 11, 496, 104),
(51, 1, 119, 951, 1, 786, 165),
(52, 1, 120, 1189, 2, 983, 206),
(53, 1, 121, 600, 11, 496, 104),
(54, 3, 122, 1800, 11, 1488, 312),
(55, 1, 123, 600, 11, 496, 104),
(56, 1, 124, 680, 7, 562, 118),
(60, 2, 127, 1902, 1, 1572, 330),
(61, 1, 128, 951, 1, 786, 165),
(62, 1, 129, 951, 1, 786, 165),
(63, 1, 130, 600, 11, 496, 104),
(64, 1, 131, 600, 11, 496, 104);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220415121951', '2022-04-15 12:21:03', 355),
('DoctrineMigrations\\Version20220415122858', '2022-04-15 12:30:07', 115),
('DoctrineMigrations\\Version20220415123111', '2022-04-15 12:31:51', 146),
('DoctrineMigrations\\Version20220415123502', '2022-04-15 12:36:00', 260),
('DoctrineMigrations\\Version20220415124622', '2022-04-15 12:47:12', 281),
('DoctrineMigrations\\Version20220415125056', '2022-04-15 12:51:22', 142),
('DoctrineMigrations\\Version20220415125245', '2022-04-15 12:53:36', 258),
('DoctrineMigrations\\Version20220415130253', '2022-04-15 13:03:46', 298),
('DoctrineMigrations\\Version20220415130925', '2022-04-15 13:09:59', 80),
('DoctrineMigrations\\Version20220415132000', '2022-04-15 13:21:38', 411),
('DoctrineMigrations\\Version20220415132800', '2022-04-15 13:28:37', 285),
('DoctrineMigrations\\Version20220415133308', '2022-04-15 13:33:54', 286),
('DoctrineMigrations\\Version20220415133631', '2022-04-15 13:37:11', 95),
('DoctrineMigrations\\Version20220415133948', '2022-04-15 13:40:02', 162),
('DoctrineMigrations\\Version20220415134305', '2022-04-15 13:44:07', 438),
('DoctrineMigrations\\Version20220415135041', '2022-04-15 13:51:15', 151),
('DoctrineMigrations\\Version20220415140300', '2022-04-15 14:03:56', 220),
('DoctrineMigrations\\Version20220415140959', '2022-04-15 14:10:32', 143),
('DoctrineMigrations\\Version20220415141212', '2022-04-15 14:12:46', 199),
('DoctrineMigrations\\Version20220416114757', '2022-04-16 11:48:28', 340),
('DoctrineMigrations\\Version20220416115813', '2022-04-16 12:00:13', 407),
('DoctrineMigrations\\Version20220416120533', '2022-04-16 12:06:10', 286),
('DoctrineMigrations\\Version20220416121051', '2022-04-16 12:11:29', 249),
('DoctrineMigrations\\Version20220416121342', '2022-04-16 12:14:08', 89),
('DoctrineMigrations\\Version20220416121555', '2022-04-16 12:18:26', 251),
('DoctrineMigrations\\Version20220416121848', '2022-04-16 12:19:26', 263),
('DoctrineMigrations\\Version20220416122054', '2022-04-16 12:21:21', 230),
('DoctrineMigrations\\Version20220416122241', '2022-04-16 12:25:57', 264),
('DoctrineMigrations\\Version20220416122657', '2022-04-16 12:27:50', 252),
('DoctrineMigrations\\Version20220416123054', '2022-04-16 12:31:26', 267),
('DoctrineMigrations\\Version20220416125114', '2022-04-16 12:51:58', 92),
('DoctrineMigrations\\Version20220416125605', '2022-04-16 12:57:46', 363),
('DoctrineMigrations\\Version20220416125857', '2022-04-16 12:59:23', 104),
('DoctrineMigrations\\Version20220416130046', '2022-04-16 13:01:10', 253),
('DoctrineMigrations\\Version20220416131346', '2022-04-16 13:14:39', 225),
('DoctrineMigrations\\Version20220417111250', '2022-04-17 11:14:54', 2265),
('DoctrineMigrations\\Version20220417111810', '2022-04-17 11:19:19', 252),
('DoctrineMigrations\\Version20220417112627', '2022-04-17 11:35:02', 1681),
('DoctrineMigrations\\Version20220417113522', '2022-04-17 11:35:58', 150),
('DoctrineMigrations\\Version20220417113835', '2022-04-17 11:39:17', 231),
('DoctrineMigrations\\Version20220417114037', '2022-04-17 11:41:04', 151),
('DoctrineMigrations\\Version20220417114519', '2022-04-17 11:45:52', 125),
('DoctrineMigrations\\Version20220417115350', '2022-04-17 11:54:23', 126),
('DoctrineMigrations\\Version20220417115842', '2022-04-17 11:59:08', 163),
('DoctrineMigrations\\Version20220417120209', '2022-04-17 12:02:42', 122),
('DoctrineMigrations\\Version20220417120612', '2022-04-17 12:06:41', 104),
('DoctrineMigrations\\Version20220417121406', '2022-04-17 12:14:36', 149),
('DoctrineMigrations\\Version20220417121614', '2022-04-17 12:16:42', 157),
('DoctrineMigrations\\Version20220417122535', '2022-04-17 12:26:22', 134),
('DoctrineMigrations\\Version20220417123020', '2022-04-17 12:30:47', 161),
('DoctrineMigrations\\Version20220417123135', '2022-04-17 12:32:11', 142),
('DoctrineMigrations\\Version20220417123633', '2022-04-17 12:38:41', 132),
('DoctrineMigrations\\Version20220417123845', '2022-04-17 12:39:14', 107),
('DoctrineMigrations\\Version20220417124111', '2022-04-17 12:41:33', 119),
('DoctrineMigrations\\Version20220417124637', '2022-04-17 12:47:44', 96),
('DoctrineMigrations\\Version20220417124856', '2022-04-17 12:49:23', 223),
('DoctrineMigrations\\Version20220417125209', '2022-04-17 12:52:37', 117),
('DoctrineMigrations\\Version20220417125340', '2022-04-17 12:55:41', 242),
('DoctrineMigrations\\Version20220417125644', '2022-04-17 12:57:11', 110),
('DoctrineMigrations\\Version20220417125808', '2022-04-17 12:58:51', 295),
('DoctrineMigrations\\Version20220417130111', '2022-04-17 13:01:33', 101),
('DoctrineMigrations\\Version20220417130234', '2022-04-17 13:03:06', 234),
('DoctrineMigrations\\Version20220417130447', '2022-04-17 13:05:25', 99),
('DoctrineMigrations\\Version20220417130618', '2022-04-17 13:06:46', 257),
('DoctrineMigrations\\Version20220417133502', '2022-04-17 13:35:23', 248),
('DoctrineMigrations\\Version20220417133727', '2022-04-17 13:37:46', 225),
('DoctrineMigrations\\Version20220417133952', '2022-04-17 13:40:13', 213),
('DoctrineMigrations\\Version20220417134204', '2022-04-17 13:42:23', 277),
('DoctrineMigrations\\Version20220417134446', '2022-04-17 13:45:11', 246),
('DoctrineMigrations\\Version20220420091937', '2022-04-20 09:20:46', 196),
('DoctrineMigrations\\Version20220421112101', '2022-04-21 11:21:49', 119),
('DoctrineMigrations\\Version20220421114503', '2022-04-21 11:45:45', 116),
('DoctrineMigrations\\Version20220421120813', '2022-04-21 12:09:07', 115),
('DoctrineMigrations\\Version20220421120948', '2022-04-21 12:10:29', 133),
('DoctrineMigrations\\Version20220421132252', '2022-04-21 13:23:34', 185),
('DoctrineMigrations\\Version20220422131854', '2022-04-22 13:19:17', 129),
('DoctrineMigrations\\Version20220422134128', '2022-04-22 13:42:14', 362),
('DoctrineMigrations\\Version20220423075915', '2022-04-23 08:00:34', 1095),
('DoctrineMigrations\\Version20220430081633', '2022-04-30 08:17:31', 756),
('DoctrineMigrations\\Version20220430090800', '2022-04-30 09:08:43', 237),
('DoctrineMigrations\\Version20220430094208', '2022-04-30 09:46:19', 275),
('DoctrineMigrations\\Version20220503160805', '2022-05-03 16:09:01', 291),
('DoctrineMigrations\\Version20220504105121', '2022-05-04 10:52:08', 974),
('DoctrineMigrations\\Version20220527081128', '2022-05-27 08:12:25', 477),
('DoctrineMigrations\\Version20220527103153', '2022-05-27 10:32:44', 674),
('DoctrineMigrations\\Version20220527105656', '2022-05-27 10:58:41', 333),
('DoctrineMigrations\\Version20220601084746', '2022-06-01 08:48:32', 803),
('DoctrineMigrations\\Version20220601085159', '2022-06-01 08:52:10', 245),
('DoctrineMigrations\\Version20220601090138', '2022-06-01 09:02:26', 317),
('DoctrineMigrations\\Version20220601091222', '2022-06-01 09:21:26', 320),
('DoctrineMigrations\\Version20220603161758', '2022-06-03 16:18:10', 1589),
('DoctrineMigrations\\Version20220619122754', '2022-06-19 12:28:37', 394),
('DoctrineMigrations\\Version20220620151312', '2022-06-20 15:14:01', 1241),
('DoctrineMigrations\\Version20220625115746', '2022-06-25 11:58:07', 506),
('DoctrineMigrations\\Version20220625135021', '2022-06-25 13:51:36', 402),
('DoctrineMigrations\\Version20220707143715', '2022-07-07 14:38:00', 446),
('DoctrineMigrations\\Version20220710095342', '2022-07-10 09:54:28', 344),
('DoctrineMigrations\\Version20220724084626', '2022-07-24 08:47:19', 1422),
('DoctrineMigrations\\Version20220724091820', '2022-07-24 09:18:50', 196),
('DoctrineMigrations\\Version20220731122838', '2022-07-31 12:29:41', 381),
('DoctrineMigrations\\Version20220804144825', '2022-08-04 14:49:42', 705),
('DoctrineMigrations\\Version20220804145258', '2022-08-04 14:53:32', 341),
('DoctrineMigrations\\Version20220804150551', '2022-08-04 15:07:05', 405),
('DoctrineMigrations\\Version20220807142916', '2022-08-07 14:32:24', 1004),
('DoctrineMigrations\\Version20220811143855', '2022-08-11 14:39:41', 560),
('DoctrineMigrations\\Version20220811152627', '2022-08-11 15:27:12', 267),
('DoctrineMigrations\\Version20220820122131', '2022-08-20 12:22:08', 422),
('DoctrineMigrations\\Version20220828125242', '2022-08-28 12:53:23', 1067),
('DoctrineMigrations\\Version20220830065719', '2022-08-30 06:58:02', 1362),
('DoctrineMigrations\\Version20220830091036', '2022-08-30 09:11:19', 223),
('DoctrineMigrations\\Version20220831090540', '2022-08-31 09:06:39', 376),
('DoctrineMigrations\\Version20220831101320', '2022-08-31 10:13:57', 2388),
('DoctrineMigrations\\Version20220831101722', '2022-08-31 10:17:52', 1768),
('DoctrineMigrations\\Version20220831101919', '2022-08-31 10:20:01', 197),
('DoctrineMigrations\\Version20220831102107', '2022-08-31 10:21:40', 210),
('DoctrineMigrations\\Version20220831102340', '2022-08-31 10:24:20', 219),
('DoctrineMigrations\\Version20220831102456', '2022-08-31 10:25:26', 196),
('DoctrineMigrations\\Version20220831102609', '2022-08-31 10:28:12', 155),
('DoctrineMigrations\\Version20220831102821', '2022-08-31 10:28:48', 137),
('DoctrineMigrations\\Version20220831102916', '2022-08-31 10:29:47', 145),
('DoctrineMigrations\\Version20220831104546', '2022-08-31 10:46:07', 526),
('DoctrineMigrations\\Version20220913215900', '2022-09-13 21:59:56', 1044);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
CREATE TABLE IF NOT EXISTS `evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `nombre_etoiles` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1323A5757294869C` (`article_id`),
  KEY `IDX_1323A575FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `evaluation`
--

INSERT INTO `evaluation` (`id`, `article_id`, `nombre_etoiles`, `utilisateur_id`) VALUES
(8, 1, 0, 22),
(10, 6, 2, 25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) NOT NULL,
  `date_facture` datetime NOT NULL,
  `statut_paiement` tinyint(1) NOT NULL,
  `montant_total` double NOT NULL,
  `montant_total_tva` double NOT NULL,
  `montant_total_hors_tva` double NOT NULL,
  `statut_livraison` tinyint(1) NOT NULL,
  `document_pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FE866410FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `facture`
--

INSERT INTO `facture` (`id`, `utilisateur_id`, `date_facture`, `statut_paiement`, `montant_total`, `montant_total_tva`, `montant_total_hors_tva`, `statut_livraison`, `document_pdf`, `updated_at`) VALUES
(113, 25, '2022-08-20 13:46:39', 1, 1290, 224, 1066, 0, 'facture-113.pdf', NULL),
(114, 25, '2022-08-21 09:07:58', 1, 1641, 285, 1356, 0, 'facture-114.pdf', NULL),
(115, 25, '2022-08-21 09:12:46', 1, 1290, 224, 1066, 0, 'facture-115.pdf', NULL),
(116, 25, '2022-08-21 09:29:08', 1, 1290, 224, 1066, 0, NULL, NULL),
(117, 25, '2022-08-21 09:30:14', 1, 1290, 224, 1066, 0, 'facture-117.pdf', NULL),
(118, 25, '2022-08-21 09:38:29', 1, 1290, 224, 1066, 0, 'facture-118.pdf', NULL),
(119, 25, '2022-08-21 09:41:25', 1, 1641, 285, 1356, 0, 'facture-119.pdf', NULL),
(120, 25, '2022-08-21 09:43:05', 1, 1879, 326, 1553, 0, 'facture-120.pdf', NULL),
(121, 25, '2022-08-21 09:53:35', 1, 1290, 224, 1066, 0, 'facture-121.pdf', NULL),
(122, 25, '2022-08-21 09:56:46', 1, 2490, 432, 2058, 0, 'facture-122.pdf', NULL),
(123, 25, '2022-08-21 10:01:41', 1, 1290, 224, 1066, 0, 'facture-123.pdf', NULL),
(124, 25, '2022-08-21 10:10:12', 1, 1370, 238, 1132, 0, 'facture-124.pdf', NULL),
(127, 25, '2022-08-30 09:04:33', 1, 2592, 450, 2142, 0, 'facture-127.pdf', NULL),
(128, 25, '2022-09-10 09:05:46', 1, 1641, 285, 1356, 0, 'facture-128.pdf', NULL),
(129, 25, '2022-09-13 12:16:18', 1, 1641, 285, 1356, 0, 'facture-129.pdf', NULL),
(130, 25, '2022-09-17 16:16:19', 1, 1290, 224, 1066, 0, 'facture-130.pdf', NULL),
(131, 25, '2022-09-17 16:16:44', 1, 1290, 224, 1066, 0, 'facture-131.pdf', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `huile`
--

DROP TABLE IF EXISTS `huile`;
CREATE TABLE IF NOT EXISTS `huile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `huile`
--

INSERT INTO `huile` (`id`, `nom_backend`) VALUES
(1, 'Mandelöl'),
(2, 'Rizinusöl'),
(3, 'Broccolisamenöl'),
(4, 'Kokosöl'),
(5, 'Babassuöl'),
(6, 'Macadamianussöl'),
(7, 'Parfumöl');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `huile_essentiel`
--

DROP TABLE IF EXISTS `huile_essentiel`;
CREATE TABLE IF NOT EXISTS `huile_essentiel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `huile_essentiel`
--

INSERT INTO `huile_essentiel` (`id`, `nom_backend`) VALUES
(1, 'Ätherisches Lavendelöl'),
(2, 'Ätherisches Limettenöl');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `point_de_vente_id` int(11) DEFAULT NULL,
  `position_image_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `cover_list_article` tinyint(1) NOT NULL,
  `cover_detail_article` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FBCF5E72D` (`categorie_id`),
  KEY `IDX_C53D045F7294869C` (`article_id`),
  KEY `IDX_C53D045F198277DA` (`position_image_id`),
  KEY `IDX_C53D045F3F95E273` (`point_de_vente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `image`
--

INSERT INTO `image` (`id`, `nom`, `categorie_id`, `article_id`, `point_de_vente_id`, `position_image_id`, `updated_at`, `cover_list_article`, `cover_detail_article`) VALUES
(30, '626cfe5589d57928284846.jpg', NULL, 1, NULL, NULL, '2022-04-30 09:16:05', 1, 0),
(31, '626cfe98f27e2232727493.jpg', NULL, 1, NULL, NULL, '2022-04-30 09:17:13', 0, 1),
(32, '626cfebeceeb9389350041.jpg', NULL, 2, NULL, NULL, '2022-04-30 09:17:50', 1, 0),
(33, '626cfee39598a597603267.jpg', NULL, 2, NULL, NULL, '2022-04-30 09:18:27', 0, 1),
(34, '626cff0619c5c830908751.jpg', NULL, 3, NULL, NULL, '2022-04-30 09:19:02', 1, 0),
(35, '626cff25ceb44421013448.jpg', NULL, 3, NULL, NULL, '2022-04-30 09:19:33', 0, 1),
(36, '626cff4c4ff86448967908.jpg', NULL, 4, NULL, NULL, '2022-04-30 09:20:12', 1, 0),
(37, '626cff667b37b965692977.jpg', NULL, 4, NULL, NULL, '2022-04-30 09:20:38', 0, 1),
(38, '626cff87910f3705221059.jpg', NULL, 5, NULL, NULL, '2022-04-30 09:21:11', 1, 0),
(39, '626cffa484133540976869.jpg', NULL, 5, NULL, NULL, '2022-04-30 09:21:40', 0, 1),
(40, '626cffdbbf66f776430069.jpg', NULL, 6, NULL, NULL, '2022-04-30 09:22:35', 1, 0),
(41, '626cfffb87460675728498.jpg', NULL, 6, NULL, NULL, '2022-04-30 09:23:07', 0, 1),
(42, '626d0018ab0ec183838435.jpg', NULL, 7, NULL, NULL, '2022-04-30 09:23:36', 1, 0),
(43, '626d003782cce205799467.jpg', NULL, 7, NULL, NULL, '2022-04-30 09:24:07', 0, 1),
(44, '626d00746db15431179742.jpg', NULL, 8, NULL, NULL, '2022-04-30 09:25:08', 1, 0),
(45, '626d009e984e0581384189.jpg', NULL, 8, NULL, NULL, '2022-04-30 09:25:50', 0, 1),
(46, '626d00c021d8f453566779.jpg', NULL, 9, NULL, NULL, '2022-04-30 09:26:24', 1, 0),
(47, '626d00df8bbb3826198912.jpg', NULL, 9, NULL, NULL, '2022-04-30 09:26:55', 0, 1),
(48, '626d010628cca251878521.jpg', NULL, 10, NULL, NULL, '2022-04-30 09:27:34', 1, 0),
(49, '626d0129ce7da635427669.jpg', NULL, 10, NULL, NULL, '2022-04-30 09:28:09', 0, 1),
(50, '626d015472d46162473439.jpg', NULL, 11, NULL, NULL, '2022-04-30 09:28:52', 1, 0),
(51, '626d018384365236518931.jpg', NULL, 11, NULL, NULL, '2022-04-30 09:29:39', 0, 1),
(54, '62a985aa42720784683162.png', 1, NULL, NULL, NULL, '2022-06-15 07:09:30', 0, 0),
(55, '62a985d01448e438154694.png', 2, NULL, NULL, NULL, '2022-06-15 07:10:08', 0, 0),
(56, '62a985ea553de863274758.png', 3, NULL, NULL, NULL, '2022-06-15 07:10:34', 0, 0),
(57, '62a98603ddcef265476896.png', 4, NULL, NULL, NULL, '2022-06-15 07:10:59', 0, 0),
(58, '62a9861dac7da194463512.png', 5, NULL, NULL, NULL, '2022-06-15 07:11:25', 0, 0),
(59, '62a986368d94d864059795.png', 6, NULL, NULL, NULL, '2022-06-15 07:11:50', 0, 0),
(60, '62f6660cdb59b531630344.jpg', NULL, NULL, NULL, 1, '2022-08-12 14:39:08', 0, 0),
(61, '62f666465f2b8920718324.jpg', NULL, NULL, NULL, 1, '2022-08-12 14:40:06', 0, 0),
(62, '62f6665f3ac85961986500.jpg', NULL, NULL, NULL, 1, '2022-08-12 14:40:31', 0, 0),
(63, '630b69c90193f696772208.jpg', NULL, NULL, 1, NULL, '2022-08-28 13:12:41', 0, 0),
(64, '630b69e1d2077900821508.jpg', NULL, NULL, 3, NULL, '2022-08-28 13:13:05', 0, 0),
(65, '630b6a0b05f54204198767.jpg', NULL, NULL, 2, NULL, '2022-08-28 13:13:47', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredient_supplementaire`
--

DROP TABLE IF EXISTS `ingredient_supplementaire`;
CREATE TABLE IF NOT EXISTS `ingredient_supplementaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `ingredient_supplementaire`
--

INSERT INTO `ingredient_supplementaire` (`id`, `nom_backend`) VALUES
(1, 'Vitamin E'),
(2, 'Rosmarinhydrolat'),
(3, 'Nerolihydrolat'),
(4, 'Kamillenhydrolat'),
(5, 'Aloe Vera Gel'),
(6, 'Titandioxid'),
(7, 'Ultramarin blau'),
(8, 'Natriumhydroxid'),
(9, 'Schafsmilchpulver'),
(10, 'Pearl Lemon yellow'),
(11, 'Eisenoxid grün'),
(12, 'Salbeihydrolat'),
(13, 'Rosenhydrolat'),
(14, 'Hamamelishydrolat'),
(15, 'Xanthan'),
(16, 'Squalane'),
(17, 'Lamesoft'),
(18, 'Kokosglucosid'),
(19, 'Bienenwachs'),
(20, 'Maisstärke'),
(21, 'Natron'),
(22, 'Salbeiextrakt'),
(23, 'Silikon'),
(24, 'Sisal');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_langue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `langue`
--

INSERT INTO `langue` (`id`, `langue`, `code_langue`) VALUES
(1, 'Deutsch', 'de'),
(2, 'Français', 'fr'),
(3, 'English', 'en');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `livraison`
--

DROP TABLE IF EXISTS `livraison`;
CREATE TABLE IF NOT EXISTS `livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant_hors_tva` int(11) NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux_tva` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `livraison`
--

INSERT INTO `livraison` (`id`, `montant_hors_tva`, `pays`, `taux_tva`) VALUES
(3, 570, 'BE', 0.21),
(4, 645, 'DE', 0.21);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_newsletter` datetime NOT NULL,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `newsletter_categories_id` int(11) NOT NULL,
  `statut_envoie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7E8585C815A4A5BD` (`newsletter_categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `newsletter`
--

INSERT INTO `newsletter` (`id`, `date_newsletter`, `nom_backend`, `newsletter_categories_id`, `statut_envoie`) VALUES
(2, '2022-06-03 16:29:13', 'Newsletter1', 2, 1),
(3, '2022-06-06 08:20:56', 'Newsletter2', 1, 1),
(4, '2022-06-11 13:49:25', 'newsletter3', 1, 1),
(5, '2022-06-11 14:17:43', 'Newsletter 4', 1, 1),
(6, '2022-06-29 09:16:01', 'NewsletterTest', 2, 1),
(7, '2022-07-10 11:41:30', 'NewsletterTESTMESSAGE', 1, 1),
(8, '2022-08-20 13:04:07', 'NewsletterEmailPDF', 1, 1),
(12, '2022-08-31 09:07:58', 'newsletterCancel', 1, 1),
(13, '2022-08-31 09:13:20', 'Cancel', 2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `newsletter_categorie`
--

DROP TABLE IF EXISTS `newsletter_categorie`;
CREATE TABLE IF NOT EXISTS `newsletter_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `newsletter_categorie`
--

INSERT INTO `newsletter_categorie` (`id`, `nom_backend`, `couleur`) VALUES
(1, 'Veranstaltungen', '#1fea41'),
(2, 'Artikel', '#0db1e7');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `odeur`
--

DROP TABLE IF EXISTS `odeur`;
CREATE TABLE IF NOT EXISTS `odeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `odeur`
--

INSERT INTO `odeur` (`id`, `nom_backend`) VALUES
(1, 'Lavendel'),
(2, 'Salbei / Zitrone'),
(3, 'Limette / Koriander'),
(4, 'Limette');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `philosophie`
--

DROP TABLE IF EXISTS `philosophie`;
CREATE TABLE IF NOT EXISTS `philosophie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `philosophie` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6F27F9522AADBACD` (`langue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `philosophie`
--

INSERT INTO `philosophie` (`id`, `langue_id`, `philosophie`) VALUES
(1, 1, '<div>Wir sind Sarah &amp; Julia Nicht nur unsere enge Freundschaft verbindet uns, sondern auch die Leidenschaft für Selbstgemachtes. Wir wollten für unsere Haut &amp; Haare ein neues Produkt entwickeln, welches nicht nur umweltfreundlich &amp; nachhaltig ist, sondern auch die natürliche Regeneration der Haut und Haare fördert.&nbsp;<br><br>Nach langer Tüftelei und vielen Versuchen sind wir nun unglaublich stolz euch unsere Produkte vorstellen zu dürfen. Wir wollen UNSER Geheimnis für natürlich schöne Haut &amp; Haare mit euch teilen. Wir benutzen eine Auswahl hochwertiger Blütenwasser, native Pflanzenöle, Kräuter und auch ätherische Öle, die allesamt dabei helfen, das natürliche Gleichgewicht der Haut &amp; auch der Haare wiederherzustellen.&nbsp;<br><br>Unser Versprechen : Alle Produkte sind nachhaltig, umweltfreundlich, selbstgemacht und zertifiziert. Die meisten Produkte sind vegan und auch dementsprechend gekennzeichnet.</div>'),
(2, 2, '<div>Nous sommes Sarah et Julia. Non seulement notre amitié nous unit, mais aussi la passion pour l’artisanat. Nous voulions développer pour notre peau et nos cheveux un nouveau produit qui soit non seulement durable et respectueux de l’environnement, mais qui favorise également la régénération naturelle de la peau et des cheveux.&nbsp;<br><br>Après de nombreuses tentatives et beaucoup d’efforts, nous sommes maintenant fiers de vous présenter nos produits. Nous voulons partager NOTRE secret pour une belle peau et des beaux cheveux avec des produits naturels. Nous utilisons une sélection d’eau florale de qualité supérieure, d’huiles végétales vierges, d’herbes aromatiques et aussi d’huiles essentielles qui aident toutes à rétablir l’équilibre naturel de la peau et des cheveux.<br><br>Notre promesse : tous les produits sont durables, respectueux de l’environnement, artisanaux et certifiés. La plupart des produits sont vegan et étiquetés en conséquence</div>'),
(3, 3, '<div>We are Sarah &amp; Julia Not only our close friendship connects us, but also the passion for homemade things. We wanted to develop a new product for our skin and hair that is not only environmentally friendly and sustainable, but also promotes the natural regeneration of skin and hair.&nbsp;<br><br>After a long time of tinkering and trying, we are now incredibly proud to be able to present our products to you. We want to share OUR secret for naturally beautiful skin &amp; hair with you. We use a selection of high-quality floral water, native plant oils, herbs and essential oils, all of which help to restore the natural balance of the skin and hair.<br>&nbsp;<br>Our promise: All products are sustainable, environmentally friendly, homemade and certified. Most products are vegan and labeled accordingly.</div>');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `point_de_vente`
--

DROP TABLE IF EXISTS `point_de_vente`;
CREATE TABLE IF NOT EXISTS `point_de_vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adresse_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C9182F7B4DE7DC5C` (`adresse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `point_de_vente`
--

INSERT INTO `point_de_vente` (`id`, `adresse_id`, `nom`, `latitude`, `longitude`) VALUES
(1, 39, 'Auguste im Bade', '6.07479', '50.77021'),
(2, 40, 'Tourist Info Büro Kelmis', '6.014271', '50.715844'),
(3, 41, 'Kelmiser Wochenmarkt', '6.010546', '50.715932');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `position_image`
--

DROP TABLE IF EXISTS `position_image`;
CREATE TABLE IF NOT EXISTS `position_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `position_image`
--

INSERT INTO `position_image` (`id`, `position`) VALUES
(1, 'Slider Philosophie');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `pourcentage` double NOT NULL,
  `nom_backend` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `promotion`
--

INSERT INTO `promotion` (`id`, `date_start`, `date_end`, `pourcentage`, `nom_backend`) VALUES
(5, '2022-09-01 13:01:00', '2022-10-31 13:01:00', 0.1, 'PromotionCatSeife'),
(8, '2022-09-01 00:01:00', '2022-10-31 00:01:00', 0.15, 'Promo Rise');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_article`
--

DROP TABLE IF EXISTS `traduction_article`;
CREATE TABLE IF NOT EXISTS `traduction_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C05A2162AADBACD` (`langue_id`),
  KEY `IDX_3C05A2167294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_article`
--

INSERT INTO `traduction_article` (`id`, `nom`, `description`, `langue_id`, `article_id`, `slogan`) VALUES
(1, 'Rise & Shine', '<div>Für eine absolut reine und weiche Gesichtshaut sorgt eine Mischung aus hochwertigem Mandel- und Rizinusöl. Nicht nur die natürliche antioxidative Wirkung des Vitamin E ist für unser Reinigungsöl von Vorteil, sondern auch seine zellschützende Funktion. Die Hautzellen werden durch ein paar Tropfen des ätherischen Lavendelöls zum Wachstum angeregt.</div>', 1, 1, 'Die einzige Gesichtspflege, die ihr braucht'),
(2, 'Rise & Shine', '<div>Un mélange d\'huile d\'amande et de ricin de haute qualité assure une peau du visage absolument pure et douce. Notre huile démaquillante bénéficie non seulement de l\'effet antioxydant naturel de la vitamine E, mais également de sa fonction protectrice des cellules. La croissance des cellules de la peau est stimulée par quelques gouttes d\'huile essentielle de lavande.</div>', 2, 1, 'Le seul produit votre visage ont besoin'),
(4, 'Rise & Shine', '<div>Best quality almond and castor oil will help you to have an absolute clean and smooth face. The vitamin E does not only have antioxidant effects but also a cell-protecting function. Only a few drops of the lavender essential oil stimulates the skin cells to grow.</div>', 3, 1, 'The only care your face needs'),
(5, 'Leave-in', '<div>Notre huile capillaire \"Leave in\" contient l\'huile de graines de brocoli. Ceci est particulièrement adapté aux cheveux abîmés et indisciplinés. Ensemble avec le romarin et l\'aloe vera contenus, il protège les cheveux et leur donne de la brillance.</div>', 2, 2, 'Baume pour cheveux abîmés'),
(6, 'Leave-in', '<div>Our „Leave-In“ hairoil contains the absolute miracle cure broccoli seed oil. The oil is particularly suitable for damaged and unruly hair. Together with rosmary flower water and aloe vera gel it protects your hair mildly and makes it shine.</div>', 3, 2, 'Balm for damaged hair'),
(7, 'I am', '<div>Die \"I Am\" Körperseife hat einen Überfettungsgrad von 8% und ist daher für alle Hauttypen geeignet. Das enthaltene Mandelöl pflegt die Haut auf eine milde Art &amp; Weise. Die Mangobutter zieht besonders tief in die Haut ein und spendet Feuchtigkeit. Wir verwenden Schafsmilchpulver wegen des hohen Proteingehalts und als natürlichen Weichmacher. Ein Schuss Rizinusöl fördert die Kollagenbildung. Der Duft dieser Seife ist eine herbe Mischung aus Salbei, Holznoten, Zitrone und Ambra.</div>', 1, 3, 'Seife mit natürlichem Weichmacher Schafsmilch'),
(8, 'I am', '<div>Le savon corporel \"I Am\" contient 8% de surgras et convient donc à tout types de peau. L\'huile d\'amande contenue prend soin de la peau de manière très douce. La beurre de mangue pénètre profondément dans la peau et l\'hydrate en même temps. Nous utilisons du lait de brebis en poudre pour sa haute teneur en protéines et comme adoucissant naturel. L\'huile de ricin favorise la formation de collagène. Le Parfum est un accord élégant de la sauge, des notes de bois, du citron et de l\'ambre.</div>', 2, 3, 'Savon avec un émollient naturel'),
(9, 'I am', '<div>The „I Am“ bodysoap is made with a degree of overgreasing of 8 %, will mean it’s suitable for all skintypes. It contains almond oil wich nurses the skin. The mango butter is particularly deeply absorbed into the skin and provides moisture. We use sheep’s milk because of ist high proteinlevel and for its known effect as natural softener. A small amount of castor oil stimulates the formation of collagen. The herbal smell come from sage, wood notes, lemon and amber.</div>', 3, 3, 'Soap with a natural emollient'),
(10, 'Fresh Coriander', '<div>Unser Bestseller, die Fresh Coriander Körperseife. Ihr frischer Limette Koriander Duft ist einzigartig. Auch ihr auffälliges Design ist ein Hingucker. Ebenso das Rezept lässt nicht zu Wünschen übrig. Sheabutter, Macadamianussöl, sowie Babassuöl sind nur die Spitze des Eisbergs. Mit einer Überfettung von 13 % ist diese Körperseife besonders für trockene Haut geeignet. Wenn Sie sich beim Duschen oder Baden mit dieser Seife waschen, werden Sie keine Feuchtigkeitslotionen mehr benötigen. Aber, probieren Sie es selbst.</div>', 1, 4, 'Der \"Allrounder\" für jeden Hauttyp'),
(11, 'Fresh Coriander', '<div>Une de nos meilleures ventes, le savon corporel \"Fresh Coriander\". Son parfum frais de coriandre-citron est unique ainsi que le design. La recette ne laisse rien à désirer: La beutte de karité, l\'huile de noix de macadamia et l\'huile de noix de coco ne sont que la pointe de l\'iceberg. Avec un surgraissage de 13%, ce savon corporel est bien adapté aux besoins d\'une peau sèche. Si vous vous lavez avec ce savon, vous n\'aurez plus besoin de lotions hydratantes.</div>', 2, 4, 'Le « polyvalent » pour chaque type de peau'),
(12, 'Fresh Coriander', '<div>Our bestseller „fresh coriander“ bodysoap has an unique scent. Also ist design is a highlight, The recipe has all you could wish for: Shea butter, macadamia nut oil, babassu oil and a few more. The overgreasing degree of 13 % makes it especially suitable for dry skin. Through the usage of this soap, you won’t need any lotions anymore.</div>', 3, 4, 'The \"all-rounder\" for every skin type'),
(13, 'Wash & Joy', '<div>Als Basis für das Duschgel nutzen wir ein Zuckertensid. Dies ist eine sehr milde Substanz mit hohem Reinigungsvermögen, außerdem hilft es bei der Schaumbildung. Veredelt wird das Produkt mit einer Auswahl von Hydrolaten. So nutzen wir zum Beispiel sehr gerne das Orangenblütenwasser. Es wirkt beruhigend und fördert die Regeneration der Haut. Auf das Salbeihydrolat greifen wir ebenfalls gern zurück, da es eine antibakterielle Wirkung hat. Als Rückfetter nutzen wir Lamesoft. Für die persönliche Note des Gels bieten wir eine Vielzahl von Düften an, zwischen denen ihr auswählen könnt.</div>', 1, 5, 'Das Duschgel voller Blütenwasser'),
(14, 'Wash & Joy', '<div>Nous utilisons un tensioactif sucré comme base pour le gel douche. C\'est une subctance très douce avec un pouvoir nettoyant élevé, elle aide également à faire mousser. Le produit est affiné avec une sélection d\'hydrolats. Par example l\'eau de fleur d\'oranger, qui a un effet calmant et qui favorise la régéneration de la peau. L\'hydrolat de sauge contenue a un effet antibactérien. Comme hydratant on a choisi le Lamesoft. Pour une touche personnelle à votre gel douche, vous pouvez choisir votre parfum préféré.</div>', 2, 5, 'Le gel douche gorgé d\'eau florale'),
(15, 'Wash & Joy', '<div>The base for our shower gel is a natural sugar surfactant. It’s a mild substance with high cleaning capacity and it also helps with foaming. The product is refined with a selection of flower water. For example, we like to use the orange blossom water. It has a soothing effect and encourages the regeneration of the skin. We also like to use sage flower water as it has an antibacterial effect. We use lamesoft as a moisturizer. For the personal touch of the gel, we offer a variety of fragrances that you can choose from.</div>', 3, 5, 'The shower gel made out of flower water'),
(16, 'Brush & Joy', '<div>Als Basis für unser Shampoo nutzen einen auf Zucker und Kokosöl basierenden Emulgator. Wir fügen verschiedene Hydrolate, also Blütenwasser, sowie Aloe Vera hinzu. Als natürlichen Weichmacher nutzen wir das auf Oliven basierende Squalan, welches einen Conditioner überflüssig macht. Ihr könnt euer Shampoo durch Auswahl eines persönlichen Duftes personalisieren.</div>', 1, 6, 'Das Highlight für die Haare'),
(17, 'Brush & Joy', '<div>Nous utilisons un émulsifiant à base de sucre et d\'huile de coco comme base de notre shampoing. Nous ajoutons des hydrolats (eau floral) ainsi que de l\'aloe vera. Comme emollient naturel, nous utilisons du squalane à base d\'olive, ce qui rend superflu l\'après-shampoing. Vous pouvez personnaliser votre shampoing en choisissant un parfum personnel. Convient à tous les types de cheveux.</div>', 2, 6, '???'),
(18, 'Brush & Joy', '<div>As basis for our shampoo we use an emulsifier based on sugar and coconut oil. We add different flower water, as well as aloe vera. As a natural softener we use olive-based squalane which replaces a chemical conditioner. You can personalize your shampoo by choosing a personal fragrance.</div>', 3, 6, 'The highlight for every hair'),
(19, 'Refresh Creme', '<div>Die Refresh Deocreme verdankt ihre Wirkung unter anderem dem Natron und Kokosöl. Das ätherische Limettenöl hat neben dem frischen Duft eine desinfizierende, schweißhemmende &amp; erfrischende Wirkung. Durch das enthaltene Natron, welches antibakterielle Eigenschaften hat, wird der Schweiß absorbiert und der Geruch neutralisiert. Das Kokosöl bewirkt eine lindernde und kühlende Hautpflege, schützt außerdem vor Hautreizungen z.B. nach der Rasur. Unser Deo ist zuverlässig, pflegend und verstopft dabei nicht die Poren.</div>', 1, 7, 'Das feste Deodorant das auf allen Ebenen überzeugt'),
(20, 'Refresh Creme', '<div>La crème déodorant Refresh gagne ses effets entre autre du bicarbonate et de l\'huile de coco. L\'huile essentielle du citron vert ne donne pas juste son parfum mais acte aussi anti transpirent, désinfectant et rafraîchissant. L\'huile de coco soigné et calme la peaux et donne une aire fraîche. Aussi elle réduit les irritations après rasage. Notre déodorant est efficace, soignant et ne n\'encombre pas les pores. Application: Repartez une quantité de la taille d\'un pois sous vos aisselle. Séchez bien votre peaux avant l\'utilisation après un bain ou une douche.</div>', 2, 7, 'Le déodorant qui convainc'),
(21, 'Refresh Creme', '<div>The great effect of the Refresh Deodorant Cream is causedby baking soda and coconut oil, among just a few other things. In addition to the fresh fragrance, the essential lime oil has a disinfecting, sweat-inhibiting &amp; refreshing effect. Through the contained baking soda, which has antibacterial properties, the sweat is absorbed and the smell neutralized. The coconut oil provides a soothing and cooling skin care, also protects against skin irritation e.B. after shaving. Our deodorant is reliable, nourishing and keeps your pores free.</div>', 3, 7, 'The deodorant that convinces'),
(22, 'Refresh Roll-On', '<div>Eins unserer beliebtesten Produkte ist ohne Frage der Roll-on. Basierend u.a. auf Blütenwasser der Orange, versetzt mit hochwertigem Salbei-Extrakt und ätherischem Limettenöl gehören unangenehme Gerüche unter den Achseln der Vergangenheit an.</div>', 1, 8, '????'),
(23, 'Refresh Roll-On', '<div>L\'un de nos produits le plus populaire est sans contredit le Roll-on. À base d\'eau de fleur d\'oranger, mélangée à un extrait de sauge de haute qualité et à de l\'huile essentielle de citron vert, les odeurs désagréables sous les aisselles appartiennent au passé.</div>', 2, 8, '????'),
(24, 'Refresh Roll-On', '<div>One of our most popular products is without question the roll-on. Based on orange blossom flower water and mixed with high-quality sage extract and essential lime oil, unpleasant odors under your armpits are a thing of the past.</div>', 3, 8, '????'),
(25, 'Seifenigel', '<div>Handgemacht, regional, spülmaschinenfest und einfach nur praktisch sind unsere Seifenigel.</div>', 1, 9, 'Der waschbare Untersatz'),
(26, 'Seifenigel', '<div>Nos port savons sont artisanal, régional, lavable au lave-vaisselle et simplement pratiques</div>', 2, 9, 'La base lavable'),
(27, 'Seifenigel', '<div>Handmade, regional, dishwasher safe and simply practical are our soapnigles.</div>', 3, 9, 'The washable base'),
(28, 'Scrubby', '<div>Seifensäckchen aus Sisal, Holz und Baumwolle, 100% nachhaltig. Feste Seifen in das Säckchen füllen, dann unter der Dusche einseifen und von dem Peeling Effekt profitieren.Ausserdem können durch dieses einfache Utensil auch kleinste Seifenreste verwendet werden.</div>', 1, 10, 'Der Waschhandschuh mit Peelingeffekt'),
(29, 'Scrubby', '<div>Lavettes savon fait de sisal, bois et cotton. 100% durable.Placez nos savons durs dans nos lavettes et savonnez vous sous votre douche pour profiter de leur effet peeling.En plus vous sauriez profitez jusqu\'au dernier bout de nos savons.</div>', 2, 10, 'Le gant de toilette effet peeling'),
(30, 'Scrubby', '<div>Soap bags made of sisal, wood and cotton, 100% sustainable. Put solid soaps into the bag, then soap in the shower and benefit from the peeling effect. Great sideeffect: even the smallest soap left-overs can be used through this simple utensil.</div>', 3, 10, 'The wash mitt with peeling effect'),
(31, 'I am Kerze', '<div>Damit ihr nie auf euren Lieblingsduft verzichten müsst, gibt es ihn nun auch als Kerze.&nbsp;</div>', 1, 11, 'Die Kerze mit eurem Lieblingsduft'),
(32, 'I am Kerze', '<div>blabla fancais</div>', 2, 11, 'La bougie avec votre odeur préféré'),
(33, 'I am Kerze', '<div>So that you never have to be without your favorite fragrance, it is now also available as a candle.</div>', 3, 11, 'The candle with your favorite scent'),
(37, 'Leave-in', '<div>Unser \"Leave in\" Haaröl enthält das Wundermittel Brokkolisamenöl. Dies ist besonders für strapaziertes und widerspenstiges Haar geeignet. Zusammen mit dem enthaltenen Rosmarin und Aloe Vera legt es sich schützend um das Haar und verleiht ihm Glanz.</div>', 1, 2, 'Balsam für strapazierte Spitzen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_beurre`
--

DROP TABLE IF EXISTS `traduction_beurre`;
CREATE TABLE IF NOT EXISTS `traduction_beurre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `beurre_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DFB23E1B2AADBACD` (`langue_id`),
  KEY `IDX_DFB23E1BE2C7E8A9` (`beurre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_beurre`
--

INSERT INTO `traduction_beurre` (`id`, `langue_id`, `beurre_id`, `nom`) VALUES
(1, 1, 1, 'Mangobutter'),
(2, 2, 1, 'Beurre de mangue'),
(3, 3, 1, 'mango butter'),
(4, 1, 2, 'Sheabutter'),
(5, 2, 2, 'Beurre de karité'),
(6, 3, 2, 'Shea Butter');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_categorie`
--

DROP TABLE IF EXISTS `traduction_categorie`;
CREATE TABLE IF NOT EXISTS `traduction_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9227E3E2AADBACD` (`langue_id`),
  KEY `IDX_B9227E3EBCF5E72D` (`categorie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_categorie`
--

INSERT INTO `traduction_categorie` (`id`, `nom`, `description`, `langue_id`, `categorie_id`) VALUES
(1, 'Seife', '<div>Unsere Seifen stellen wir nur mit feinsten Zutaten her. Sie halten lange und erzeugen keinen Abfall.</div><div>Verschiedene Rezepturen, frische Düfte und tolle Designs – überzeugt euch selbst.</div>', 1, 1),
(2, 'Savon', '<div>Nous&nbsp; fabriquons nos savons qu\'avec les meilleurs ingrédients. Ils durent longtemps et ne génèrent aucun déchet.</div><div>Différentes recettes, odeurs frais et superbes designs - voyez par vous-même.</div>', 2, 1),
(3, 'Soap', '<div>We only make our soaps with the finest ingredients. They last a long time and generate no waste.</div><div>Different recipes, fresh scents and great designs - see for yourself.</div>', 3, 1),
(4, 'Duschgel / Shampoo', '<div>Die Basis für Shampoo und auch Duschgel bilden unsere Blütenwasser. Zusammen mit tollen Wirkstoffen wie Aloe Vera und Vitamin E ist jede Dusche eine reine Wohltat für die Haare und den Körper.</div>', 1, 2),
(5, 'Gel douche / Shampoing', '<div>Notre eau florale constitue la base du shampoing et du gel douche. Associé à d\'excellents ingrédients actifs tels que l\'aloe vera et la vitamine E, chaque douche est un pur régal pour les cheveux et le corps.</div>', 2, 2),
(6, 'Shower gel / shampoo', '<div>Our floral water forms the basis for shampoo and shower gel. Together with ingredients such as aloe vera and vitamin E, every shower is a pure treat for the hair and the body.</div>', 3, 2),
(7, 'Deodorant', '<div>Deodorant Lorem DE</div>', 1, 3),
(8, 'Déodorant', '<div>Déodorant Lorem FR</div>', 2, 3),
(9, 'Deodorant', '<div>Deodorant Lorem EN</div>', 3, 3),
(10, 'Pflege', '<div>Unsere Pflegeprodukte unterstreichen eure Schönheit, und zwar langfristig. Mit Hilfe von hochwertigen ätherischen Ölen, Blütenwasser, nativen Pflanzenölen und Kräutern wird das natürliche Gleichgewicht von Haut und Haaren wiederhergestellt und die Regeneration gefördert.</div>', 1, 4),
(11, 'Soin', '<div>Nos produits de soins soulignent votre beauté. Avec l\'aide d\'huiles essentielles de haute qualité, d\'eau florale, d\'huiles végétales indigènes et d\'herbes, l\'équilibre naturel de la peau et des cheveux est restauré et la régénération est encouragé.</div>', 2, 4),
(12, 'Care', '<div>Our treatments highlight your beauty, over the long term. With the help of high quality essential oils, floral water, native vegetable oils and herbs, the natural balance of skin and hair is restored and regeneration is supported.</div>', 3, 4),
(13, 'Kerzen', '<div>Damit ihr eure Lieblingsdüfte nicht nur in der Dusche genießen könnt, gibt es sie auch als Kerze.</div>', 1, 5),
(14, 'Bougies', '<div>Pour que vous puissiez non seulement profiter de vos parfums préférés sous la douche, ils sont également disponibles sous forme de bougies.</div>', 2, 5),
(15, 'Candles', '<div>So that you can not only enjoy your favorite scents in the shower, they are also available as candles.</div>', 3, 5),
(16, 'Zubehör', '<div>Alles, was ihr für die Benutzung der Seifen und Pflegeprodukte benötigt.</div>', 1, 6),
(17, 'Accessoires', '<div>Tout le nécessaire pour utiliser les savons et produits de soins.</div>', 2, 6),
(18, 'Accesories', '<div>Everything you need to use the soaps and care products.</div>', 3, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_huile`
--

DROP TABLE IF EXISTS `traduction_huile`;
CREATE TABLE IF NOT EXISTS `traduction_huile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `huile_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_85BC07DD2AADBACD` (`langue_id`),
  KEY `IDX_85BC07DD3EBD4426` (`huile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_huile`
--

INSERT INTO `traduction_huile` (`id`, `langue_id`, `huile_id`, `nom`) VALUES
(1, 1, 1, 'Mandelöl'),
(2, 2, 1, 'Huile d\'amande'),
(3, 3, 1, 'Almond oil'),
(4, 1, 2, 'Rizinusöl'),
(5, 2, 2, 'Huile de castor'),
(6, 3, 2, 'Castor oil'),
(7, 1, 3, 'Broccolisamenöl'),
(8, 2, 3, 'Huile de graines de brocoli'),
(9, 3, 3, 'broccoli seed oil'),
(10, 1, 4, 'Kokosöl'),
(11, 2, 4, 'Huile de noix de coco'),
(12, 3, 4, 'coconut oil'),
(13, 1, 5, 'Babassuöl'),
(14, 2, 5, 'huile de babassu'),
(15, 3, 5, 'babassu oil'),
(16, 1, 6, 'Macadamianussöl'),
(17, 2, 6, 'huile de noix de macadamia'),
(18, 3, 6, 'macadamia nut oil'),
(19, 1, 7, 'Parfümöl'),
(20, 2, 7, 'huile de parfum'),
(21, 3, 7, 'perfume oil');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_huile_essentiel`
--

DROP TABLE IF EXISTS `traduction_huile_essentiel`;
CREATE TABLE IF NOT EXISTS `traduction_huile_essentiel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `huile_essentiel_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_562960202AADBACD` (`langue_id`),
  KEY `IDX_5629602055CA86AD` (`huile_essentiel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_huile_essentiel`
--

INSERT INTO `traduction_huile_essentiel` (`id`, `langue_id`, `huile_essentiel_id`, `nom`) VALUES
(1, 1, 1, 'Ätherisches Lavendelöl'),
(2, 2, 1, 'huile essentielle de lavande'),
(3, 3, 1, 'Lavender essential oil'),
(4, 1, 2, 'Ätherisches Limettenöl'),
(5, 2, 2, 'huile essentielle de citron vert'),
(6, 3, 2, 'lime essential oil');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_ingredient_supplementaire`
--

DROP TABLE IF EXISTS `traduction_ingredient_supplementaire`;
CREATE TABLE IF NOT EXISTS `traduction_ingredient_supplementaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `ingredient_supplementaire_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5766044C2AADBACD` (`langue_id`),
  KEY `IDX_5766044C491BCAD2` (`ingredient_supplementaire_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_ingredient_supplementaire`
--

INSERT INTO `traduction_ingredient_supplementaire` (`id`, `langue_id`, `ingredient_supplementaire_id`, `nom`) VALUES
(1, 1, 1, 'Vitamin E'),
(2, 2, 1, 'Vitamine E'),
(3, 3, 1, 'Vitamine E'),
(4, 1, 2, 'Rosmarinhydrolat'),
(5, 2, 2, 'hydrolat de romarin'),
(6, 3, 2, 'rosemary flower water'),
(7, 1, 3, 'Nerolihydrolat'),
(8, 2, 3, 'hydrolat de néroli'),
(9, 3, 3, 'neroli flower water'),
(10, 1, 4, 'Kamillenhydrolat'),
(11, 2, 4, 'hydrolat de camomille'),
(12, 3, 4, 'chamomile flower water'),
(13, 1, 5, 'Aloe Vera Gel'),
(14, 2, 5, 'Gel d\'aloe vera'),
(15, 3, 5, 'Aloe vera gel'),
(16, 1, 6, 'Titandioxid'),
(17, 2, 6, 'dioxyde de titane'),
(18, 3, 6, 'titanium dioxide'),
(19, 1, 7, 'Ultramarin blau'),
(20, 2, 7, 'bleu outremer'),
(21, 3, 7, 'ultramarine blue'),
(22, 1, 8, 'Natriumhydroxid'),
(23, 2, 8, 'hydroxyde de sodium'),
(24, 3, 8, 'sodium hydroxide'),
(25, 1, 9, 'Schafsmilchpulver'),
(26, 2, 9, 'poudre de lait de brebis'),
(27, 3, 9, 'sheep\'s milk powder'),
(28, 1, 10, 'Pearl Lemon yellow'),
(29, 2, 10, 'Jaune citron nacré'),
(30, 3, 10, 'Pearl lemon yellow'),
(31, 1, 11, 'Eisenoxid grün'),
(32, 2, 11, 'oxyde de fer vert'),
(33, 3, 11, 'green iron oxide'),
(34, 1, 12, 'Salbeihydrolat'),
(35, 2, 12, 'hydrolat de sauge'),
(36, 3, 12, 'sage flower water'),
(37, 1, 13, 'Rosenhydrolat'),
(38, 2, 13, 'hydrolat de rose'),
(39, 3, 13, 'rose flower water'),
(40, 1, 14, 'Hamamelishydrolat'),
(41, 2, 14, 'hydrolat d\'hamamélis'),
(42, 3, 14, 'hamamelis flower water'),
(43, 1, 15, 'Xanthan'),
(44, 2, 15, 'xanthane'),
(45, 3, 15, 'xanthan'),
(46, 1, 16, 'Squalane'),
(47, 2, 16, 'squalanes'),
(48, 3, 16, 'squalanes'),
(49, 1, 17, 'Lamesoft'),
(50, 2, 17, 'boiteux'),
(51, 3, 17, 'lamesoft'),
(52, 1, 18, 'Kokosglucosid'),
(53, 2, 18, 'glucoside de coco'),
(54, 3, 18, 'coco glycoside'),
(55, 1, 19, 'Bienenwachs'),
(56, 2, 19, 'cire d\'abeille'),
(57, 3, 19, 'beeswax'),
(58, 1, 20, 'Maisstärke'),
(59, 2, 20, 'fécule de maïs'),
(60, 3, 20, 'cornstarch'),
(61, 1, 21, 'Natron'),
(62, 2, 21, 'bicarbonate de soude'),
(63, 3, 21, 'baking soda'),
(64, 1, 22, 'Salbeiextrakt'),
(65, 2, 22, 'extrait de sauge'),
(66, 3, 22, 'sage extract'),
(67, 1, 23, 'Silikon'),
(68, 2, 23, 'Silicone'),
(69, 3, 23, 'Silicone'),
(70, 1, 24, 'Sisal'),
(71, 2, 24, 'Sisal'),
(72, 3, 24, 'Sisal');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_newsletter`
--

DROP TABLE IF EXISTS `traduction_newsletter`;
CREATE TABLE IF NOT EXISTS `traduction_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue_id` int(11) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `document_pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9EA0337E2AADBACD` (`langue_id`),
  KEY `IDX_9EA0337E22DB1917` (`newsletter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_newsletter`
--

INSERT INTO `traduction_newsletter` (`id`, `titre`, `description`, `langue_id`, `newsletter_id`, `document_pdf`, `updated_at`) VALUES
(4, 'Newsletter1', 'Newsletter1 in deutsch', 1, 2, NULL, NULL),
(5, 'Newsletter1', 'Newsletter1 en francais', 2, 2, NULL, NULL),
(6, 'Newsletter1', 'Newsletter1 in english', 3, 2, NULL, NULL),
(7, 'Newsletter2', '<div>Newsletter2 in deutsch</div>', 1, 3, '62ebf0e5161a0329168233.pdf', '2022-08-04 16:16:37'),
(8, 'Newsletter2', 'Newsletter2 en francais', 2, 3, '629db98016e8b833901079.pdf', '2022-06-06 08:23:28'),
(9, 'newsletter3', '<div>Das ist der Newsletter in deutsch</div>', 1, 4, '62a49de2dcdb9236029237.pdf', '2022-06-11 13:51:30'),
(10, 'newsletter3', '<div>Le newsletter en francais</div>', 2, 4, '62a49e089ac1f585405860.pdf', '2022-06-11 13:52:08'),
(11, 'newsletter3', '<div>The newsletter in eglish</div>', 3, 4, '62a49e555e2c2289760371.pdf', '2022-06-11 13:53:25'),
(12, 'Newsletter 4', '<div>Newsletter in deutsch</div>', 1, 2, '62a4a42eb31d8020831258.pdf', '2022-06-11 14:18:22'),
(13, 'Newsletter4', '<div>Newsletter in deutsch</div>', 1, 5, NULL, NULL),
(14, 'Newsletter 4', '<div>Newsletter en francais</div>', 2, 5, NULL, NULL),
(15, 'newsletter 4', '<div>Newsletter in english</div>', 3, 5, NULL, NULL),
(16, 'Test', '<div>Testdeutsch</div>', 1, 6, NULL, NULL),
(17, 'Test', '<div>Testfran</div>', 2, 6, NULL, NULL),
(18, 'Test', '<div>Testenglisch</div>', 3, 6, NULL, NULL),
(19, 'NewsletterTESTMESSAGEDEUSTCH', '<div>TEXT DEUTSCH</div>', 1, 7, NULL, NULL),
(20, 'NewsletterTESTMESSAFEFRANZ', '<div>TEXTFRANZ</div>', 2, 7, NULL, NULL),
(21, 'NewsletterTESTMESSAGEENG', '<div>TEXT ENG</div>', 3, 7, NULL, NULL),
(22, 'PDFDE', '<div>Hallo</div>', 1, 8, '6300dbf5805d5368923236.pdf', '2022-08-20 13:04:53'),
(23, 'PDFFR', '<div>Salut</div>', 2, 8, NULL, NULL),
(24, 'PDFEN', '<div>Hello</div>', 3, 8, '6300dc3eeea05928864263.pdf', '2022-08-20 13:06:06'),
(34, 'Newsletter löschen', '<div>Text mit Löschen</div>', 1, 12, NULL, NULL),
(35, 'Newsletter supprimer', '<div>text supprimer</div>', 2, 12, NULL, NULL),
(36, 'Newsletter cancle', '<div>cancel text</div>', 3, 12, NULL, NULL),
(37, 'test', '<div>Test</div>', 1, 13, NULL, NULL),
(38, 'Test', '<div>Test</div>', 2, 13, NULL, NULL),
(39, 'Test', '<div>Test</div>', 3, 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_newsletter_categorie`
--

DROP TABLE IF EXISTS `traduction_newsletter_categorie`;
CREATE TABLE IF NOT EXISTS `traduction_newsletter_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `newsletter_categories_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EE67D4F82AADBACD` (`langue_id`),
  KEY `IDX_EE67D4F815A4A5BD` (`newsletter_categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_newsletter_categorie`
--

INSERT INTO `traduction_newsletter_categorie` (`id`, `langue_id`, `nom`, `newsletter_categories_id`) VALUES
(1, 1, 'Veranstaltungen', 1),
(2, 2, 'Événements', 1),
(3, 3, 'Events', 1),
(4, 1, 'Artikel', 2),
(5, 2, 'Articles', 2),
(6, 3, 'Articles', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_odeur`
--

DROP TABLE IF EXISTS `traduction_odeur`;
CREATE TABLE IF NOT EXISTS `traduction_odeur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `odeur_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CEF03E8C2AADBACD` (`langue_id`),
  KEY `IDX_CEF03E8C222D80EB` (`odeur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_odeur`
--

INSERT INTO `traduction_odeur` (`id`, `langue_id`, `odeur_id`, `nom`) VALUES
(1, 1, 1, 'Lavendel'),
(2, 2, 1, 'Lavende'),
(3, 3, 1, 'Lavender'),
(4, 1, 2, 'Salbei / Zitrone'),
(5, 2, 2, 'Sauge / citron'),
(6, 3, 2, 'Sage / lemon'),
(7, 1, 3, 'Limette / Koriander'),
(8, 2, 3, 'Citron vert / coriandre'),
(9, 3, 3, 'Lime / coriander'),
(10, 1, 4, 'Limette'),
(11, 2, 4, 'citron vert'),
(12, 3, 4, 'lime');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_point_de_vente`
--

DROP TABLE IF EXISTS `traduction_point_de_vente`;
CREATE TABLE IF NOT EXISTS `traduction_point_de_vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `langue_id` int(11) NOT NULL,
  `point_de_vente_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_782B8E002AADBACD` (`langue_id`),
  KEY `IDX_782B8E003F95E273` (`point_de_vente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_point_de_vente`
--

INSERT INTO `traduction_point_de_vente` (`id`, `langue_id`, `point_de_vente_id`, `description`) VALUES
(1, 1, 1, '<div>In diesem kleinen, feinen Geschäft im Aachener Jakobsviertel findest Du ausschließlich unverpackte, plastik- und chemikalienfreie Produkte zur natürlichen Körperpflege.&nbsp;</div>'),
(2, 2, 1, '<div>Dans cette petite boutique raffinée d\'Aix-la-Chapelle, vous ne trouverez que des produits non emballés, sans plastique, sans chimiques pour les soins corporels naturels.</div>'),
(3, 3, 1, '<div>In this small, fine shop in Aachen you will only find unpackaged, plastic and chemical-free products for natural body care.</div><div>&nbsp;</div>'),
(4, 1, 2, '<div>Neben nützlichen Informationen sind im Tourist Büro außerdem regionale Produkte erhältlich.</div>'),
(5, 2, 2, '<div>En plus des informations utiles, des produits régionaux sont également disponibles à l\'office de tourisme.</div><div>&nbsp;</div>'),
(6, 3, 2, '<div>In addition to useful information, regional products are also available at the tourist office.</div>'),
(7, 1, 3, '<div>Kelmiser Wochenmarkt<br>Jeden Donnerstag von 8 bis 12 Uhr</div>'),
(8, 2, 3, '<div>Marché hebdomadaire de la calamine&nbsp;<br>Chaque jeudi de 08 à 12 heures</div>'),
(9, 3, 3, '<div>Weekly market in Kelmis<br>Every thursday from 08 to 12 o\'clock</div>');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `traduction_promotion`
--

DROP TABLE IF EXISTS `traduction_promotion`;
CREATE TABLE IF NOT EXISTS `traduction_promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `langue_id` int(11) NOT NULL,
  `promotion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3142D5DB2AADBACD` (`langue_id`),
  KEY `IDX_3142D5DB139DF194` (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `traduction_promotion`
--

INSERT INTO `traduction_promotion` (`id`, `titre`, `description`, `langue_id`, `promotion_id`) VALUES
(1, 'Promotion savon', 'Promotion savon', 2, 5),
(2, 'Promotion Seife', 'Promotion Seife', 1, 5),
(3, 'Promotion Soap', 'Promotion Soap', 3, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` datetime NOT NULL,
  `date_inscription` datetime NOT NULL,
  `inscription_valide` tinyint(1) NOT NULL,
  `inscription_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_home_id` int(11) NOT NULL,
  `adresse_deliver_id` int(11) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `nom_entreprise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_tva` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1D1C63B3E7927C74` (`email`),
  KEY `IDX_1D1C63B386D37703` (`adresse_home_id`),
  KEY `IDX_1D1C63B3F9AA6F6` (`adresse_deliver_id`),
  KEY `IDX_1D1C63B32AADBACD` (`langue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `date_naissance`, `date_inscription`, `inscription_valide`, `inscription_token`, `adresse_home_id`, `adresse_deliver_id`, `langue_id`, `nom_entreprise`, `numero_tva`) VALUES
(9, 'alain@hot1.com', '[\"ROLE_USER\"]', '$2y$13$s/VfjvgBaj0zuCQcVMrk4.VuRRsnxH0A3tdUD/AsoDtSo9NjZkeY.', 'Niessen', 'Alain', '1902-01-01 00:00:00', '2022-05-09 16:20:02', 0, 'uU5LtDCaGAudOA-1z7qy1nyMPwqXmwJBO_hDp2hUb-w', 13, 13, 1, NULL, NULL),
(13, 'alain@hot5.com', '[\"ROLE_USER\"]', '$2y$13$RjdQgee/6LKiMsriTPyAxOnQOEv50ffNJUjqfLqHDgw.Tk1.e2WX6', 'Niessen', 'Nathalie2', '1902-01-01 00:00:00', '2022-05-09 16:24:29', 0, 'hS8lH6b_LUqzJW9WQUerlL_LaUvI7winkwxAgF9DDjA', 15, 13, 1, NULL, NULL),
(16, 'utilisateur1@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$gSl/EvtIdaLhWKu5QVGd0eY3ADqJhXy2AO2S28y2JsDDqVmgtmf12', 'Niessen', 'Peter', '1902-01-01 00:00:00', '2022-05-10 15:20:36', 1, NULL, 13, 15, 1, NULL, NULL),
(17, 'utilisateur2@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$zD5arfofQtkQGNIx1wgmtuOrTRxN6ogDhBQfli7fSijlVm6NFN4qq', 'Niessen', 'Magalie', '1902-01-01 00:00:00', '2022-05-10 15:30:28', 1, NULL, 13, 15, 1, NULL, NULL),
(18, 'julialeohoelscher@hotmail.com', '[\"ROLE_USER\"]', '$2y$13$9NWi26fssgnitrlQDd3vreQYguhyk9c7Pqo9R68qAP2fEiGCaZtdG', 'Hölscher', 'Julia', '1992-09-11 00:00:00', '2022-05-11 09:53:23', 0, 'Vk6Om-LRV0Ua24V9UnzhZe4Rah36eqOjhyN05Qo_8gY', 17, 17, 1, NULL, NULL),
(19, 'user12@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$vHnE3zp7QVf92p4XNdJAxOC39i92aefNCqoMTMsKz4E6OnuU4lSJS', 'Bla', 'Blu', '1902-01-01 00:00:00', '2022-05-11 09:56:41', 1, NULL, 13, 18, 1, NULL, NULL),
(22, 'adminSuper@super.be', '{\"1\": \"ROLE_SUPER_ADMIN\"}', '$2y$13$0TVMjldPAKb8LRXTn0MCU.WnKzbEVar.5AhiVQT6Squc1fWTX7QaO', 'Test', 'Superadmin', '1980-06-22 13:22:00', '2022-05-18 00:00:00', 1, NULL, 13, 18, 2, NULL, NULL),
(23, 'adminFinance@finance.be', '[\"ROLE_USER\", \"ROLE_FINANCE_ADMIN\"]', '$2y$13$4z7bmWIKXeF3dN/AR754Wea0rM0jG7mAetiS01tv4vu.OLJRfUS/C', 'Test', 'FinanceAdmin', '2000-02-22 18:00:00', '2022-05-18 09:00:00', 1, NULL, 13, NULL, 1, NULL, NULL),
(25, 'alainniessen2@gmail.com', '[\"ROLE_USER\"]', '$2y$13$zg4q8E6gXxzTqyh2U2tvaOHF7TCf03JNH6ZeKpdH2rsyO9GGDASuG', 'TestModiTest', 'Julia', '1920-01-01 00:00:00', '2022-05-25 09:38:06', 1, NULL, 45, 31, 3, NULL, NULL),
(28, 'utilisateur5@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$NkOA0jQGN.VOrPSEWjdYju37wPTP5xo809tUFRx6aaWpSDLwDl6YS', 'niessen', 'lop', '1902-01-01 00:00:00', '2022-06-03 15:58:26', 1, NULL, 13, 20, 1, NULL, NULL),
(30, 'utilisateur7@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$3Z8iPdEfnlcM2/DCaNejBOvassoYsk24c2m4ChOCG.4./ww2N6a.W', 'Bla', 'Blu', '1902-01-01 00:00:00', '2022-06-03 16:21:06', 1, NULL, 13, 15, 1, NULL, NULL),
(31, 'utilisateur8@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$hH3I94RtdBITT.MtbIGiiOy2LwKqLZ8AEHarJ1UWunoBi5/o89.1S', 'Bla', 'Lo', '1902-01-01 00:00:00', '2022-06-03 16:23:32', 0, 'QAq70n7eM7v4jCiuDmmkigkoH3c9zhvjj3RaQd7N7FM', 13, 20, 1, NULL, NULL),
(32, 'utilisateur10@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$Hb4K2GLukNFyzQG6gFUETeNys/fwNM/JWY2JrBQWIvCvyj0iOxVB2', 'Test', 'Al', '1902-01-01 00:00:00', '2022-06-11 13:55:01', 1, NULL, 13, 15, 3, NULL, NULL),
(34, 'utilisateur12@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$Dd.ny6GRNJCzRXOAh5gWZOletZRR4z4lCoPad.olQQz9HqC8iGeZ6', 'Niess', 'Al', '1902-01-01 00:00:00', '2022-07-13 11:50:06', 1, NULL, 13, 15, 2, NULL, NULL),
(37, 'utilisateur14@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$lAHg2JcRrb3lp2CTzpeMceF19dQnfUMUeqZ/x93idp/hMX6JODGVi', 'Test', 'Alain', '1902-01-01 00:00:00', '2022-07-13 14:39:11', 1, NULL, 30, 32, 1, NULL, NULL),
(38, 'utilisateur15@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$BW5z3ChnAv31pjkIqM2JQezKistG9nh/z9cD/N/AaS9yoz1YZX8PK', 'Niessen', 'Helmute', '1917-01-01 00:00:00', '2022-07-14 16:31:53', 1, NULL, 35, 29, 2, NULL, NULL),
(42, 'utilisateur20@trash-mail.com', '[\"ROLE_USER\"]', '$2y$13$MyxbFJe2X0EsapGTAj1SF.JS2JDuc.AUic7Mmp/qVqoXdJqcqXh7C', 'Niessen', 'Emil', '1902-01-01 00:00:00', '2022-09-05 06:57:30', 0, 'ORi2BCRW0kDKqdAF365iBbArxYqUjWmYFwSpsEJ2q78', 43, 44, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `utilisateur_article`
--

DROP TABLE IF EXISTS `utilisateur_article`;
CREATE TABLE IF NOT EXISTS `utilisateur_article` (
  `utilisateur_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`utilisateur_id`,`article_id`),
  KEY `IDX_7831F9F4FB88E14F` (`utilisateur_id`),
  KEY `IDX_7831F9F47294869C` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `utilisateur_article`
--

INSERT INTO `utilisateur_article` (`utilisateur_id`, `article_id`) VALUES
(25, 6),
(25, 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `utilisateur_newsletter_categorie`
--

DROP TABLE IF EXISTS `utilisateur_newsletter_categorie`;
CREATE TABLE IF NOT EXISTS `utilisateur_newsletter_categorie` (
  `utilisateur_id` int(11) NOT NULL,
  `newsletter_categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`utilisateur_id`,`newsletter_categorie_id`),
  KEY `IDX_62A9FFBCFB88E14F` (`utilisateur_id`),
  KEY `IDX_62A9FFBCB718D653` (`newsletter_categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `utilisateur_newsletter_categorie`
--

INSERT INTO `utilisateur_newsletter_categorie` (`utilisateur_id`, `newsletter_categorie_id`) VALUES
(25, 2),
(30, 1),
(30, 2),
(31, 1),
(32, 1),
(32, 2),
(34, 2),
(37, 1),
(37, 2),
(42, 1);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_23A0E66222D80EB` FOREIGN KEY (`odeur_id`) REFERENCES `odeur` (`id`),
  ADD CONSTRAINT `FK_23A0E66BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `article_beurre`
--
ALTER TABLE `article_beurre`
  ADD CONSTRAINT `FK_E4AE027C7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E4AE027CE2C7E8A9` FOREIGN KEY (`beurre_id`) REFERENCES `beurre` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `article_huile`
--
ALTER TABLE `article_huile`
  ADD CONSTRAINT `FK_F7A0A8FD3EBD4426` FOREIGN KEY (`huile_id`) REFERENCES `huile` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F7A0A8FD7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `article_huile_essentiel`
--
ALTER TABLE `article_huile_essentiel`
  ADD CONSTRAINT `FK_728ACBAB55CA86AD` FOREIGN KEY (`huile_essentiel_id`) REFERENCES `huile_essentiel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_728ACBAB7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `article_ingredient_supplementaire`
--
ALTER TABLE `article_ingredient_supplementaire`
  ADD CONSTRAINT `FK_3042176B491BCAD2` FOREIGN KEY (`ingredient_supplementaire_id`) REFERENCES `ingredient_supplementaire` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3042176B7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `FK_497DD634139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`);

--
-- Constraints der Tabelle `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_67F068BCFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `detail_commande_article`
--
ALTER TABLE `detail_commande_article`
  ADD CONSTRAINT `FK_D68E2DEA7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D68E2DEA7F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `FK_1323A5757294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1323A575FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `FK_FE866410FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F198277DA` FOREIGN KEY (`position_image_id`) REFERENCES `position_image` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C53D045F3F95E273` FOREIGN KEY (`point_de_vente_id`) REFERENCES `point_de_vente` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C53D045F7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C53D045FBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `FK_7E8585C815A4A5BD` FOREIGN KEY (`newsletter_categories_id`) REFERENCES `newsletter_categorie` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `philosophie`
--
ALTER TABLE `philosophie`
  ADD CONSTRAINT `FK_6F27F9522AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `point_de_vente`
--
ALTER TABLE `point_de_vente`
  ADD CONSTRAINT `FK_C9182F7B4DE7DC5C` FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`id`);

--
-- Constraints der Tabelle `traduction_article`
--
ALTER TABLE `traduction_article`
  ADD CONSTRAINT `FK_3C05A2162AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3C05A2167294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_beurre`
--
ALTER TABLE `traduction_beurre`
  ADD CONSTRAINT `FK_DFB23E1B2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DFB23E1BE2C7E8A9` FOREIGN KEY (`beurre_id`) REFERENCES `beurre` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_categorie`
--
ALTER TABLE `traduction_categorie`
  ADD CONSTRAINT `FK_B9227E3E2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B9227E3EBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_huile`
--
ALTER TABLE `traduction_huile`
  ADD CONSTRAINT `FK_85BC07DD2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_85BC07DD3EBD4426` FOREIGN KEY (`huile_id`) REFERENCES `huile` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_huile_essentiel`
--
ALTER TABLE `traduction_huile_essentiel`
  ADD CONSTRAINT `FK_562960202AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5629602055CA86AD` FOREIGN KEY (`huile_essentiel_id`) REFERENCES `huile_essentiel` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_ingredient_supplementaire`
--
ALTER TABLE `traduction_ingredient_supplementaire`
  ADD CONSTRAINT `FK_5766044C2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5766044C491BCAD2` FOREIGN KEY (`ingredient_supplementaire_id`) REFERENCES `ingredient_supplementaire` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_newsletter`
--
ALTER TABLE `traduction_newsletter`
  ADD CONSTRAINT `FK_9EA0337E22DB1917` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletter` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9EA0337E2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_newsletter_categorie`
--
ALTER TABLE `traduction_newsletter_categorie`
  ADD CONSTRAINT `FK_EE67D4F815A4A5BD` FOREIGN KEY (`newsletter_categories_id`) REFERENCES `newsletter_categorie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EE67D4F82AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_odeur`
--
ALTER TABLE `traduction_odeur`
  ADD CONSTRAINT `FK_CEF03E8C222D80EB` FOREIGN KEY (`odeur_id`) REFERENCES `odeur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CEF03E8C2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_point_de_vente`
--
ALTER TABLE `traduction_point_de_vente`
  ADD CONSTRAINT `FK_782B8E002AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_782B8E003F95E273` FOREIGN KEY (`point_de_vente_id`) REFERENCES `point_de_vente` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `traduction_promotion`
--
ALTER TABLE `traduction_promotion`
  ADD CONSTRAINT `FK_3142D5DB139DF194` FOREIGN KEY (`promotion_id`) REFERENCES `promotion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3142D5DB2AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_1D1C63B32AADBACD` FOREIGN KEY (`langue_id`) REFERENCES `langue` (`id`),
  ADD CONSTRAINT `FK_1D1C63B386D37703` FOREIGN KEY (`adresse_home_id`) REFERENCES `adresse` (`id`),
  ADD CONSTRAINT `FK_1D1C63B3F9AA6F6` FOREIGN KEY (`adresse_deliver_id`) REFERENCES `adresse` (`id`);

--
-- Constraints der Tabelle `utilisateur_article`
--
ALTER TABLE `utilisateur_article`
  ADD CONSTRAINT `FK_7831F9F47294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7831F9F4FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `utilisateur_newsletter_categorie`
--
ALTER TABLE `utilisateur_newsletter_categorie`
  ADD CONSTRAINT `FK_62A9FFBCB718D653` FOREIGN KEY (`newsletter_categorie_id`) REFERENCES `newsletter_categorie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_62A9FFBCFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
