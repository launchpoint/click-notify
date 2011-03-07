
CREATE TABLE IF NOT EXISTS `notification_template_groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`,`weight`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

alter table notification_templates
  add notification_template_group_id int(11) default null,
  add is_active_default int(11) default 1;