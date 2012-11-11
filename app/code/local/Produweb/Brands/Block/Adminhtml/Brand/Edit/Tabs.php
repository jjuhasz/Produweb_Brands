<?php

class Produweb_Brands_Block_Adminhtml_Brand_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	protected $_attributeTabBlock = 'adminhtml/catalog_product_edit_tab_attributes';

	public function __construct()
	{
		parent::__construct();
		$this->setId('brand_info_tabs');
		$this->setDestElementId('brand_edit_form');
		$this->setTitle(Mage::helper('brands')->__('Brand Information'));
	}

	protected function _prepareLayout()
	{
		//$brand = $this->getBrand();

			$this->addTab('general', array(
				'label'     => Mage::helper('brands')->__('General'),
				'content'   => $this->_translateHtml($this->getLayout()
					->createBlock('brands/adminhtml_brand_edit_tab_general')->toHtml()),
			));


		return parent::_prepareLayout();
	}

	public function getProduct()
	{
		if (!($this->getData('brand') instanceof Produweb_Brands_Model_Brand)) {
			$this->setData('brand', Mage::registry('current_brand'));
		}
		return $this->getData('brand');
	}

	/**
	 * Translate html content
	 *
	 * @param string $html
	 * @return string
	 */
	protected function _translateHtml($html)
	{
		Mage::getSingleton('core/translate_inline')->processResponseBody($html);
		return $html;
	}
}