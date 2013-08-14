--
-- Структура таблицы `wow_talent_icons`
--

DROP TABLE IF EXISTS `wow_talent_icons`;
CREATE TABLE IF NOT EXISTS `wow_talent_icons` (
  `class` int(11) NOT NULL,
  `spec` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `name_de` text NOT NULL,
  `name_en` text NOT NULL,
  `name_es` text NOT NULL,
  `name_fr` text NOT NULL,
  `name_ru` text NOT NULL,
  PRIMARY KEY (`class`,`spec`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `wow_talent_icons`
--

INSERT INTO `wow_talent_icons` (`class`, `spec`, `icon`, `name_de`, `name_en`, `name_es`, `name_fr`, `name_ru`) VALUES
(6, 0, 'spell_deathknight_bloodpresence', 'Blut', 'Blood', 'Sangre', 'Sang', 'Кровь'),
(6, 2, 'spell_deathknight_unholypresence', 'Unheilig', 'Unholy', 'Profano', 'Impie', 'Нечестивость'),
(6, 1, 'spell_deathknight_frostpresence', 'Frost', 'Frost', 'Escarcha', 'Givre', 'Лед'),
(5, 0, 'spell_holy_wordfortitude', 'Disziplin', 'Discipline', 'Disciplina', 'Discipline', 'Послушание'),
(5, 2, 'spell_shadow_shadowwordpain', 'Schatten', 'Shadow', 'Sombra', 'Ombre', 'Тьма'),
(5, 1, 'spell_holy_guardianspirit', 'Heilig', 'Holy', 'Sagrado', 'Sacr&#233;', 'Свет'),
(1, 1, 'ability_warrior_innerrage', 'Furor', 'Fury', 'Furia', 'Fureur', 'Неистовство'),
(1, 2, 'inv_shield_06', 'Schutz', 'Protection', 'Protecci&#243;n', 'Protection', 'Защита'),
(1, 0, 'ability_rogue_eviscerate', 'Waffen', 'Arms', 'Armas', 'Armes', 'Оружие'),
(2, 0, 'spell_holy_holybolt', 'Heilig', 'Holy', 'Sagrado', 'Sacr&#233;', 'Свет'),
(2, 1, 'spell_holy_devotionaura', 'Schutz', 'Protection', 'Protecci&#243;n', 'Protection', 'Защита'),
(2, 2, 'spell_holy_auraoflight', 'Vergeltung', 'Retribution', 'Reprensi&#243;n', 'Vindicte', 'Воздаяние'),
(3, 0, 'ability_hunter_beasttaming', 'Tierherrschaft', 'Beast mastery', 'Bestias', 'Ma&#238;trise des b&#234;tes', 'Чувство зверя'),
(3, 1, 'ability_marksmanship', 'Treffsicherheit', 'Marksmanship', 'Punter&#237;a', 'Pr&#233;cision', 'Стрельба'),
(3, 2, 'ability_hunter_swiftstrike', '&#220;berleben', 'Survival', 'Supervivencia', 'Survie', 'Выживание'),
(4, 0, 'ability_rogue_eviscerate', 'Meucheln', 'Assassination', 'Asesinato', 'Assassinat', 'Ликвидация'),
(4, 1, 'ability_backstab', 'Kampf', 'Combat', 'Combate', 'Combat', 'Бой'),
(4, 2, 'ability_stealth', 'T&#228;uschung', 'Subletly', 'Sutileza', 'Finesse', 'Скрытность'),
(7, 0, 'spell_nature_lightning', 'Elementar', 'Elemental', 'Elemental', 'El&#233;mentaire', 'Стихии'),
(7, 1, 'spell_nature_lightningshield', 'Verst&#228;rk.', 'Enhancement', 'Mejora', 'Am&#233;lioration', 'Совершенствование'),
(7, 2, 'spell_nature_magicimmunity', 'Wiederherst.', 'Restoration', 'Restauraci&#243;n', 'Restauration', 'Исцеление'),
(8, 0, 'spell_holy_magicalsentry', 'Arkan', 'Arcane', 'Arcano', 'Arcane', 'Тайная магия'),
(8, 1, 'spell_fire_firebolt02', 'Feuer', 'Fire', 'Fuego', 'Feu', 'Огонь'),
(8, 2, 'spell_frost_frostbolt02', 'Frost', 'Frost', 'Escarcha', 'Givre', 'Лед'),
(9, 0, 'spell_shadow_deathcoil', 'Gebrechen', 'Affliction', 'Aflicci&#243;n', 'Affliction', 'Колдовство'),
(9, 1, 'spell_shadow_metamorphosis', 'D&#228;monologie', 'Demonology', 'Demonolog&#237;a', 'D&#233;monologie', 'Демонология'),
(9, 2, 'spell_shadow_rainoffire', 'Zerst&#246;rung', 'Destruction', 'Destrucci&#243;n', 'Destruction', 'Разрушение'),
(11, 0, 'spell_nature_starfall', 'Gleichgewicht', 'Balance', 'Equilibrio', 'Equilibre', 'Баланс'),
(11, 1, 'ability_racial_bearform', 'Wilder Kampf', 'Feral Combat', 'Combate feral', 'Combat farouche', 'Сила зверя'),
(11, 2, 'spell_nature_healingtouch', 'Wiederherst.', 'Restoration', 'Restauraci&#243;n', 'Restauration', 'Исцеление');
