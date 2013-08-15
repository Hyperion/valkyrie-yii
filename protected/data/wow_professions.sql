DROP TABLE IF EXISTS `wow_professions`;
CREATE TABLE IF NOT EXISTS `wow_professions` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `name_de` text NOT NULL,
  `name_en` text NOT NULL,
  `name_es` text NOT NULL,
  `name_fr` text NOT NULL,
  `name_ru` text NOT NULL,
  `icon` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `wow_professions`
--

INSERT INTO `wow_professions` (`id`, `name_de`, `name_en`, `name_es`, `name_fr`, `name_ru`, `icon`) VALUES
(164, 'Schmieden', 'Blacksmithing', 'Herrer&#237;a', 'Forge', 'Кузнечное дело', 'trade_blacksmithing'),
(165, 'Lederverarbeitung', 'Leatherworking', 'Peleter&#237;a', 'Travail du cuir', 'Кожевничество', 'trade_leatherworking'),
(171, 'Alchimie', 'Alchemy', 'Alquimia', 'Alchimie', 'Алхимия', 'trade_alchemy'),
(182, 'Kr&#228;uterkunde', 'Herbalism', 'Herborister&#237;a', 'Herboristerie', 'Травничество', 'trade_herbalism'),
(186, 'Bergbau', 'Mining', 'Mineria', 'Minage', 'Горное дело', 'trade_mining'),
(197, 'Schneidern', 'Tailoring', 'Sastrer&#237;a', 'Couture', 'Портняжное дело', 'trade_tailoring'),
(202, 'Ingenieurskunst', 'Engineering', 'Ing&#233;ni&#233;rie', 'Ing&#233;ni&#233;rie', 'Инженерное дело', 'trade_engineering'),
(333, 'Verzaubern', 'Enchanting', 'Encantamiento', 'Enchantement', 'Наложение чар', 'trade_engraving'),
(393, 'K&#252;rschnerei', 'Skinning', 'Desollar', 'D&#233;pe&#231;age', 'Снятие шкур', 'inv_misc_pelt_wolf_01'),
(755, 'Juwelenschleifen', 'Jewelcrafting', 'Joyer&#237;a', 'Joaillerie', 'Ювелирное дело', 'trade_jewelcrafting'),
(773, 'Inschriftenkunde', 'Inscription', 'Inscripci&#243;n', 'Calligraphie', 'Начертание', 'trade_inscription');