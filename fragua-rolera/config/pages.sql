SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dir` varchar(111) DEFAULT NULL,
  `file` varchar(111) DEFAULT NULL,
  `box_parent` varchar(111) DEFAULT NULL,
  `box` varchar(111) DEFAULT NULL,
  `box_weight` varchar(111) DEFAULT '0',
  `box_width` varchar(111) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

insert into `pages` values('21','/fragua-rolera/views/_shared/templates/','materialize.phtml',null,'plantilla-materialize',null,null),
 ('22','/fragua-rolera/views/_shared/templates/','materialize.phtml','plantilla-materialize','cabecera','1',null),
 ('17','/fragua-rolera/views/_shared/templates/','materialize.phtml','cuerpo-materialize','script-materialize','10',null),
 ('25','/fragua-rolera/views/_shared/templates/','materialize.phtml','cuerpo','javascript-materialize','10',null),
 ('23','/fragua-rolera/views/_shared/templates/','materialize.phtml','plantilla-materialize','cuerpo','2',null),
 ('24','/fragua-rolera/views/_shared/templates/','materialize.phtml','cabecera','estilos-materialize','1',null),
 ('107','/fragua-rolera/views/_shared/templates/','__LOL__default.phtml','cabecera','estilos-materialize',null,null),
 ('108','/fragua-rolera/views/_shared/templates/','__LOL__default.phtml','cuerpo','javascript-materialize',null,null),
 ('105','/fragua-rolera/views/_shared/templates/','__LOL__default.phtml','plantilla-materialize','cabecera',null,null),
 ('106','/fragua-rolera/views/_shared/templates/','__LOL__default.phtml','plantilla-materialize','cuerpo',null,null),
 ('89','/fragua-rolera/views/_shared/templates/','__OLD__default.phtml','','plantilla-materialize','',''),
 ('88','/fragua-rolera/views/_shared/templates/','__OLD__default.phtml','plantilla-materialize','cabecera','',''),
 ('87','/fragua-rolera/views/_shared/templates/','__OLD__default.phtml','plantilla-materialize','cuerpo','',''),
 ('86','/fragua-rolera/views/_shared/templates/','__OLD__default.phtml','cabecera','estilos-materialize','',''),
 ('85','/fragua-rolera/views/_shared/templates/','__OLD__default.phtml','cuerpo','javascript-materialize','',''),
 ('109','/fragua-rolera/views/_shared/templates/','logo.phtml','','plantilla-materialize-basica','',''),
 ('100','/fragua-rolera/views/_shared/templates/','__LOL__default.phtml',null,'plantilla-materialize',null,null);

SET FOREIGN_KEY_CHECKS = 1;
