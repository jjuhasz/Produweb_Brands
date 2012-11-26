<?php

class Produweb_Navigate_Model_Resource_Menu_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	protected function _construct()
	{
		$this->_init('navigate/menu_item');
	}
}