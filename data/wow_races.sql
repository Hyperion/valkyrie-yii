--
-- Структура таблицы `wow_races`
--

DROP TABLE IF EXISTS `wow_races`;
CREATE TABLE IF NOT EXISTS `wow_races` (
  `id` bigint(20) NOT NULL,
  `name_de` text,
  `name_en` text,
  `name_es` text,
  `name_fr` text,
  `name_ru` text,
  `modeldata_1` varchar(50) NOT NULL,
  `modeldata_2` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `wow_races`
--

INSERT INTO `wow_races` (`id`, `name_de`, `name_en`, `name_es`, `name_fr`, `name_ru`, `modeldata_1`, `modeldata_2`) VALUES
(1, 'Mensch', 'Human', 'Humano', 'Humain', 'Человек', 'human', 'hu'),
(2, 'Orc', 'Orc', 'Orco', 'Orc', 'Орк', 'orc', 'or'),
(3, 'Zwerg', 'Dwarf', 'Enano', 'Nain', 'Дворф', 'dwarf', 'dw'),
(4, 'Nachtelf', 'Night Elf', 'Elfo de la noche', 'Elfe de la nuit', 'Ночной эльф', 'nightelf', 'ni'),
(5, 'Untoter', 'Undead', 'No-muerto', 'Mort-vivant', 'Нежить', 'scourge', 'sc'),
(6, 'Tauren', 'Tauren', 'Tauren', 'Tauren', 'Таурен', 'tauren', 'ta'),
(7, 'Gnom', 'Gnome', 'Gnomo', 'Gnome', 'Гном', 'gnome', 'gn'),
(8, 'Troll', 'Troll', 'Trol', 'Troll', 'Тролль', 'troll', 'tr'),
(10, 'Blutelf', 'Blood Elf', 'Elfa de sangre', 'Elfe de sang', 'Эльф крови', 'bloodelf', 'be'),
(11, 'Draenei', 'Draenei', 'Draenei', 'Draenei', 'Дреней', 'draenei', 'dr');