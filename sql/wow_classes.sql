-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2011 at 11:49 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shadez_wowarmory`
--

-- --------------------------------------------------------

--
-- Table structure for table `armory_classes`
--

DROP TABLE IF EXISTS `wow_classes`;
CREATE TABLE IF NOT EXISTS `wow_classes` (
  `id` smallint(1) NOT NULL,
  `name_de` text NOT NULL,
  `name_en` text NOT NULL,
  `name_es` text NOT NULL,
  `name_fr` text NOT NULL,
  `name_ru` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Character classes table';

--
-- Dumping data for table `armory_classes`
--

INSERT INTO `wow_classes` (`id`, `name_de`, `name_en`, `name_es`, `name_fr`, `name_ru`) VALUES
(1, 'Krieger', 'Warrior', 'Guerrero', 'Guerrier', 'Воин'),
(2, 'Paladin', 'Paladin', 'Palad&#237;n', 'Paladin', 'Паладин'),
(3, 'J&#228;ger', 'Hunter', 'Cazador', 'Chasseur', 'Охотник'),
(4, 'Schurke', 'Rogue', 'P&#237;caro', 'Voleur', 'Разбойник'),
(5, 'Priester', 'Priest', 'Sacerdote', 'Pr&#234;tre', 'Жрец'),
(6, 'Todesritter', 'Death Knight', 'Caballero de la Muerte', 'Chevalier de la mort', 'Рыцарь смерти'),
(7, 'Schamane', 'Shaman', 'Cham&#225;n', 'Chaman', 'Шаман'),
(8, 'Magier', 'Mage', 'Mago', 'Mage', 'Маг'),
(9, 'Hexenmeister', 'Warlock', 'Brujo', 'D&#233;moniste', 'Чернокнижник'),
(11, 'Druide', 'Druid', 'Druida', 'Druide', 'Друид');
