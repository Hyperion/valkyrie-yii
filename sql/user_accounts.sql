-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 05 2011 г., 22:01
-- Версия сервера: 5.1.56
-- Версия PHP: 5.3.6-6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `valkyrie`
--

-- --------------------------------------------------------

--
-- Структура таблицы `wow_user_accounts`
--

CREATE TABLE IF NOT EXISTS `user_accounts` (
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  UNIQUE KEY `account_id` (`account_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
