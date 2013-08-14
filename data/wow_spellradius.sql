DROP TABLE IF EXISTS `wow_spellradius`;
CREATE TABLE IF NOT EXISTS `wow_spellradius` (
  `radiusID` smallint(5) unsigned NOT NULL,
  `radiusBase` float NOT NULL,
  PRIMARY KEY (`radiusID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Дамп данных таблицы `wow_spellradius`
--

INSERT INTO `wow_spellradius` (`radiusID`, `radiusBase`) VALUES
(7, 2),
(8, 5),
(9, 20),
(10, 30),
(11, 45),
(12, 100),
(13, 10),
(14, 8),
(15, 3),
(16, 1),
(17, 13),
(18, 15),
(19, 18),
(20, 25),
(21, 35),
(22, 200),
(23, 40),
(24, 65),
(25, 70),
(26, 4),
(27, 50),
(28, 50000),
(29, 6),
(31, 80);
