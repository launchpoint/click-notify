CREATE TABLE IF NOT EXISTS `notifier_preferences` (
  `id` int(11) NOT NULL auto_increment,
  `notification_template_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL COMMENT 'boolean',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `notification_template_id` (`notification_template_id`,`name`,`is_enabled`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;