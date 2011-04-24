CREATE TABLE  `text_settings` (
`id` INT NOT NULL AUTO_INCREMENT ,
`language` ENUM(  'en',  'ru' ) NOT NULL ,
`name` VARCHAR( 50 ) NOT NULL ,
`text` TEXT NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = MYISAM  DEFAULT CHARSET=utf8;