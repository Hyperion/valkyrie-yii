DROP TABLE IF EXISTS admin_access;
CREATE TABLE IF NOT EXISTS admin_access (
  user_id int(11) NOT NULL,
  ip int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;