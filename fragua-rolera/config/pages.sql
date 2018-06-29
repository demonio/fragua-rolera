SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pages_id` varchar(111) DEFAULT NULL,
  `boxes_id` varchar(111) DEFAULT NULL,
  `dir` varchar(111) DEFAULT NULL,
  `file` varchar(111) DEFAULT NULL,
  `box_weight` varchar(111) DEFAULT '0',
  `box_width` varchar(111) DEFAULT 's12',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;

insert into `pages` values('138',null,'20','/fragua-rolera/views/index/','index.phtml','0',null),
 ('139',null,'21','/fragua-rolera/views/index/','index.phtml','1',null),
 ('137',null,'20','/fragua-rolera/views/index/','index.phtml','0',null);

SET FOREIGN_KEY_CHECKS = 1;
