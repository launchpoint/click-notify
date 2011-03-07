CREATE TABLE IF NOT EXISTS `notification_templates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `is_public` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `tag` (`tag`),
  KEY `is_public` (`is_public`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `notification_template_variables` (
  `id` int(11) NOT NULL auto_increment,
  `notification_template_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `php` varchar(500) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `notification_template_id` (`notification_template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
