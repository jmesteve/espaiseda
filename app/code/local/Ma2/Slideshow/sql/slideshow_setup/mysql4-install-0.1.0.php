<?php
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('ma2_slideshow')};
CREATE TABLE {$this->getTable('ma2_slideshow')} (
  `slideshow_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `category` varchar(255) NOT NULL default '',
  `slideshow_url` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `sortorder` int(11) NOT NULL default '0',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`slideshow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 