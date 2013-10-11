CREATE TABLE `command` (
  `id` bigint(20) NOT NULL auto_increment,
  `session_id` varchar(128) NOT NULL,
  `command` text NOT NULL,
  `processed` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE IF NOT EXISTS `online` (
  `session_id` varchar(128) NOT NULL,
  `last_update` int(11) NOT NULL,
  `name` varchar(32),
  PRIMARY KEY (`session_id`)
);

CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(128) NOT NULL,
  `message` text NOT NULL,
  `processed` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE  `message` ADD  `color` VARCHAR( 6 ) NOT NULL ;