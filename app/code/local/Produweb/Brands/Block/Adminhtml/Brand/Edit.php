<?php

class Produweb_Brands_Block_Adminhtml_Brand_Edit extends Mage_Adminhtml_Block_Widget
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('brands/brand/edit.phtml');
		$this->setId('brand_edit');
	}

	public function getBrand()
	{
		return Mage::registry('current_brand');
	}

	protected function _prepareLayout()
	{
			$this->setChild('back_button',
				$this->getLayout()->createBlock('adminhtml/widget_button')
					->setData(array(
					'label'     => Mage::helper('brands')->__('Back'),
					'onclick'   => 'setLocation(\''.$this->getUrl('*/*/', array('store'=>$this->getRequest()->getParam('store', 0))).'\')',
					'class' => 'back'
				))
			);


			$this->setChild('reset_button',
				$this->getLayout()->createBlock('adminhtml/widget_button')
					->setData(array(
					'label'     => Mage::helper('brands')->__('Reset'),
					'onclick'   => 'setLocation(\''.$this->getUrl('*/*/*', array('_current'=>true)).'\')'
				))
			);

			$this->setChild('save_button',
				$this->getLayout()->createBlock('adminhtml/widget_button')
					->setData(array(
					'label'     => Mage::helper('brands')->__('Save'),
					'onclick'   => 'brand_edit_form.submit()',
					'class' => 'save'
				))
			);


			$this->setChild('delete_button',
				$this->getLayout()->createBlock('adminhtml/widget_button')
					->setData(array(
					'label'     => Mage::helper('brands')->__('Delete'),
					'onclick'   => 'confirmSetLocation(\''.Mage::helper('brands')->__('Are you sure?').'\', \''.$this->getDeleteUrl().'\')',
					'class'  => 'delete'
				))
			);

		return parent::_prepareLayout();
	}

	public function getBackButtonHtml()
	{
		return $this->getChildHtml('back_button');
	}

	public function getCancelButtonHtml()
	{
		return $this->getChildHtml('reset_button');
	}

	public function getSaveButtonHtml()
	{
		return $this->getChildHtml('save_button');
	}

	public function getDeleteButtonHtml()
	{
		return $this->getChildHtml('delete_button');
	}

	public function getValidationUrl()
	{
		return $this->getUrl('*/*/validate', array('_current'=>true));
	}

	public function getSaveUrl()
	{
		return $this->getUrl('*/*/save', array('_current'=>true, 'back'=>null));
	}

	public function getBrandId()
	{
		return $this->getBrand()->getId();
	}

	public function getDeleteUrl()
	{
		return $this->getUrl('*/*/delete', array('_current'=>true));
	}

	public function getHeader()
	{
		$header = '';
		if ($this->getBrand()->getId()) {
			$header = $this->escapeHtml($this->getBrand()->getTitle());
		}
		else {
			$header = Mage::helper('brands')->__('New Brand');
		}

		return $header;
	}

	public function getSelectedTabId()
	{
		return addslashes(htmlspecialchars($this->getRequest()->getParam('tab')));
	}
}