<?php

class Produweb_Brands_Block_Adminhtml_Brand_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{

	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		$this->initForm();
	}

	public function initForm()
	{
		$form = new Varien_Data_Form();
		$block = $this->getLayout()->createBlock('brands/adminhtml_brand_form_renderer_fieldset_element');
		Varien_Data_Form::setFieldsetElementRenderer($block);
		$form->setHtmlIdPrefix('_brand');
		$form->setFieldNameSuffix('brand');

		$brand = Mage::registry('current_brand');

		/** @var $brandForm Mage_Customer_Model_Form */
		$brandForm = Mage::getModel('brands/form');
		$brandForm->setEntity($brand)
			->setFormCode('brands_brand')
			->initDefaultValues();

		//Zend_Debug::dump($brandForm); die();

		$fieldset = $form->addFieldset('base_fieldset', array(
			'legend' => Mage::helper('brands')->__('Brand Information')
		));

		$attributes = $brandForm->getAttributes();

		$disableAutoGroupChangeAttributeName = 'disable_auto_group_change';
		$this->_setFieldset($attributes, $fieldset, array($disableAutoGroupChangeAttributeName));
		$form->setValues($brand->getData());
		$form->setDataObject($brand);
		$this->setForm($form);
		return $this;
	}
}