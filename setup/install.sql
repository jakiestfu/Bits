-- Create syntax for 'bits'

DROP TABLE IF EXISTS `bits`;
CREATE TABLE `bits` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `slug` varchar(25) default NULL,
  `version` int(11) default NULL,
  `public` tinyint(1) default NULL,
  `javascript` text,
  `html` text,
  `css` text,
  `meta` text,
  `created` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
