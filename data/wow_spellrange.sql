DROP TABLE IF EXISTS `wow_spellrange`;
CREATE TABLE IF NOT EXISTS `wow_spellrange` (
  `rangeID` int(10) unsigned NOT NULL,
  `rangeMin` float NOT NULL,
  `rangeMax` float NOT NULL,
  `name_loc0` varchar(40) NOT NULL,
  PRIMARY KEY (`rangeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Дамп данных таблицы `wow_spellrange`
--

INSERT INTO `wow_spellrange` (`rangeID`, `rangeMin`, `rangeMax`, `name_loc0`) VALUES
(1, 0, 0, 'Self Only\r'),
(2, 0, 5, 'Combat Range\r'),
(3, 0, 20, 'Short Range\r'),
(4, 0, 30, 'Medium Range\r'),
(5, 0, 40, 'Long Range\r'),
(6, 0, 100, 'Vision Range\r'),
(7, 0, 10, 'Very Short Range\r'),
(8, 10, 20, 'Short Range\r'),
(9, 10, 30, 'Medium Range\r'),
(10, 10, 40, 'Long Range\r'),
(11, 0, 15, 'Shorter Range\r'),
(12, 0, 5, 'Interact Range\r'),
(13, 0, 50000, 'Anywhere\r'),
(14, 0, 60, 'Extra Long Range\r'),
(34, 0, 25, 'Medium-Short Range\r'),
(35, 0, 35, 'Medium-Long Range\r'),
(36, 0, 45, 'Longer Range\r'),
(37, 0, 50, 'Extended Range\r'),
(38, 10, 25, 'Extra Medium Range\r'),
(54, 5, 30, 'Geoff Monster Shoot\r'),
(74, 8, 30, 'Ranged Weapon\r'),
(94, 8, 40, 'Sting\r'),
(95, 8, 25, 'Charge\r'),
(96, 0, 2, 'Trap\r'),
(114, 8, 35, 'Hunter Range\r'),
(134, 0, 80, 'Tower 80\r'),
(135, 0, 100, 'Tower 100\r'),
(136, 30, 80, 'Artillery Range\r');
