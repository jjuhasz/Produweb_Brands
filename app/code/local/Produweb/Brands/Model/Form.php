<?php

class Produweb_Brands_Model_Form extends Mage_Eav_Model_Form
{
	protected $_moduleName = 'brands';

	protected $_entityTypeCode = 'brands_brand';

	protected $_attributes = array();

	public function __construct()
	{
		$this->_attributes[] = Mage::getModel('eav/entity_attribute')->loadByCode('brands_brand', 'title');
		$this->_attributes[] = Mage::getModel('eav/entity_attribute')->loadByCode('brands_brand', 'description');
		$this->_attributes[] = Mage::getModel('eav/entity_attribute')->loadByCode('brands_brand', 'slug');
	}

	/*protected function _getFormAttributeCollection()
	{
		return parent::_getFormAttributeCollection()
			->addFieldToFilter('attribute_code', array('neq' => 'created_at'));
	}*/
}