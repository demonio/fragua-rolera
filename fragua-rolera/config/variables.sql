SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `variables`;

CREATE TABLE `variables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pages_id` int(11) DEFAULT NULL,
  `k` varchar(111) DEFAULT NULL,
  `v` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;

insert into `variables` values('105','190','ruta_de_la_imagen','/img/logo_negro.jpg'),
 ('70','187','tipo_de_encabezado','1'),
 ('69','187','alineamiento','center'),
 ('68','187','ancho_de_caja','s12'),
 ('94','188','texto_del_encabezado','Telegram:'),
 ('93','188','tipo_de_encabezado','2'),
 ('92','188','alineamiento','right'),
 ('102','189','ancho_de_la_imagen','128'),
 ('101','189','ruta_de_la_imagen','/img/telegram.png'),
 ('99','189','ancho_de_caja','s12 m6 l6'),
 ('106','190','ancho_de_la_imagen',''),
 ('104','190','alineamiento','center'),
 ('71','187','texto_del_encabezado','Próximamente...'),
 ('91','188','ancho_de_caja','s12 m6 l6'),
 ('54','185','Ruta_del_enlace','LOL'),
 ('103','190','ancho_de_caja','s12'),
 ('100','189','alineamiento','left'),
 ('107','191','ancho_de_caja','s12'),
 ('108','191','alineamiento','center'),
 ('109','191','tipo_de_encabezado','2'),
 ('110','191','texto_del_encabezado','Telegram:'),
 ('111','191','ruta_de_la_imagen','/img/telegram.png'),
 ('112','191','ancho_de_la_imagen','128'),
 ('118','202','controlador_padre_nombre','App'),
 ('117','202','controlador_nombre','Dados'),
 ('119','203','controlador_nombre','Dados'),
 ('120','203','controlador_padre_nombre','App'),
 ('121','204','ancho_de_caja','s12'),
 ('122','204','alineamiento','left'),
 ('123','204','tipo_de_encabezado','1'),
 ('124','204','texto_del_encabezado','Dados'),
 ('125','205','controlador_nombre','App');

SET FOREIGN_KEY_CHECKS = 1;
