DROP TABLE IF EXISTS resource;
CREATE TABLE IF NOT EXISTS resource (
  resource varchar(50) NOT NULL,
  version varchar(50) NOT NULL,
  description text NOT NULL,
  PRIMARY KEY (resource)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
