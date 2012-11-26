<?php

class Produweb_Navigate_Model_Resource_Menu_Item extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init('navigate/menu_item', 'item_id');
	}
}