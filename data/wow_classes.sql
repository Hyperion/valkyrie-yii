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
-- Дамп данных таблицы `wow_classes`
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