SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `variables`;

CREATE TABLE `variables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boxes_id` int(11) DEFAULT NULL,
  `k` varchar(111) DEFAULT NULL,
  `v` varchar(111) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

insert into `variables` values('6','16','title','Grupo creativo Fragua Rolera');

SET FOREIGN_KEY_CHECKS = 1;
