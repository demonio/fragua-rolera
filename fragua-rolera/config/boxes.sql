SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `boxes`;

CREATE TABLE `boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(111) DEFAULT NULL,
  `name` varchar(111) DEFAULT NULL,
  `code` longtext,
  `target` varchar(111) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

insert into `boxes` values('3','plantilla-materialize','Plantilla Materialize','<!DOCTYPE html>\r\n<html>\r\n	{$boxes}\r\n</html>','db'),
 ('10','cabecera','Cabecera','<head>\r\n	{$boxes}\r\n	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n</head>','db'),
 ('13','estilos-materialize','Estilos Materialize','<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">\r\n\r\n<link type=\"text/css\" rel=\"stylesheet\" href=\"/css/materialize.min.css\"  media=\"screen,projection\">','db'),
 ('11','cuerpo','Cuerpo','<body>\r\n	{$boxes}\r\n</body>','db'),
 ('12','javascript-materialize','Javascript Materialize','<script src=\"/javascript/materialize.min.js\"></script>','db'),
 ('16','plantilla-materialize-basica','Plantilla Materialize Básica','<!DOCTYPE html>\r\n<html>\r\n    <head>\r\n        <link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">\r\n        <link type=\"text/css\" rel=\"stylesheet\" href=\"/css/materialize.min.css\"  media=\"screen,projection\"/>\r\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>\r\n        <title><?=$title?></title>\r\n    </head>\r\n    <body>\r\n        <?php View::content(); ?> \r\n        <script type=\"text/javascript\" src=\"/javascript/materialize.min.js\"></script>\r\n    </body>\r\n</html>','db');

SET FOREIGN_KEY_CHECKS = 1;
