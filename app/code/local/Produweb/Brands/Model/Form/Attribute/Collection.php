<?php

class Produweb_Brands_Model_Form_Attribute_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
	protected function _construct()
	{
		$this->_init('brands/brand');
	}
}