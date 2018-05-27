CREATE TABLE alergenos (
  id int(11) NOT NULL auto_increment,
  nombre varchar(250) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE ingredientes (
  id int(11) NOT NULL auto_increment,
  nombre varchar(250) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE platos (
  id int(11) NOT NULL auto_increment,
  nombre varchar(250) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE ingredientes_alergenos (
  id_ingrediente int(11) NOT NULL DEFAULT '0',
  id_alergeno int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id_ingrediente,id_alergeno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE platos_ingredientes (
  id_plato int(11) NOT NULL DEFAULT '0',
  id_ingrediente int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (id_plato,id_ingrediente)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;