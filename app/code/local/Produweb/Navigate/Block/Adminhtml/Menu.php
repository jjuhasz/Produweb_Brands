<?php

class Produweb_Navigate_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Widget_Container
{
	/**
	 * Set template
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('navigate/menu.phtml');
	}

	/**
	 * Prepare button and grid
	 */
	protected function _prepareLayout()
	{
		$this->_addButton('add_new', array(
			'label'   => Mage::helper('brands')->__('Add Menu'),
			'onclick' => "setLocation('{$this->getUrl('*/*/new')}')",
			'class'   => 'add'
		));

		$this->setChild('grid', $this->getLayout()->createBlock('navigate/adminhtml_menu_grid', 'menu.grid'));
		return parent::_prepareLayout();
	}
	/**
	 * Render grid
	 *
	 * @return string
	 */
	public function getGridHtml()
	{
		return $this->getChildHtml('grid');
	}

	/**
	 * Check whether it is single store mode
	 *
	 * @return bool
	 */
	public function isSingleStoreMode()
	{
		if (!Mage::app()->isSingleStoreMode()) {
			return false;
		}
		return true;
	}
}