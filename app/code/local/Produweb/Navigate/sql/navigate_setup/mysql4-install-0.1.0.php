<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jona
 * Date: 26/11/12
 * Time: 0:13
 * To change this template use File | Settings | File Templates.
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('navigate_menu')};
CREATE TABLE {$this->getTable('navigate_menu')} (
  `menu_id` int(11) unsigned NOT NULL auto_increment,
  `store_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_at`datetime NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- DROP TABLE IF EXISTS {$this->getTable('navigate_menu_item')};
CREATE TABLE {$this->getTable('navigate_menu_item')} (
  `item_id` int(11) unsigned NOT NULL auto_increment,
  `menu_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `type_menu` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_at`datetime NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();