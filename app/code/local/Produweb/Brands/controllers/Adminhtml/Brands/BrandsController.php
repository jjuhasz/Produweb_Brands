<?php

require_once("Mage/Adminhtml/Controller/Action.php");

class Produweb_Brands_Adminhtml_Brands_BrandsController extends Mage_Adminhtml_Controller_Action
{

    protected function _construct()
    {
    }

	protected function _initBrand()
	{
		$this->_title($this->__('Brands'))
			->_title($this->__('Manage Brands'));

		$brandId  = (int) $this->getRequest()->getParam('id');
		$brand    = Mage::getModel('brands/brand')->setStoreId($this->getRequest()->getParam('store', 0));


		$brand->setData('_edit_mode', true);
		if ($brandId) {
			try {
				$brand->load($brandId);
			} catch (Exception $e) {
				Mage::logException($e);
			}
		}
		$brand->setStoreId($this->getRequest()->getParam('store', 0));

		Mage::register('current_brand', $brand);
		Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
		return $brand;
	}

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('brands/manage_brands');
        $this->renderLayout();
    }

	public function editAction()
	{
		$brandId  = (int) $this->getRequest()->getParam('id');
		$brand = $this->_initBrand();

		if ($brandId && !$brand->getId()) {
			$this->_getSession()->addError(Mage::helper('brands')->__('This brand no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}

		$this->_title($brand->getTitle());


		$this->loadLayout();

		$this->_setActiveMenu('brands/manage_brands');

		if (!Mage::app()->isSingleStoreMode() && ($switchBlock = $this->getLayout()->getBlock('store_switcher'))) {
			$switchBlock->setDefaultStoreName($this->__('Default Values'))
				->setWebsiteIds($brand->getWebsiteIds())
				->setSwitchUrl(
				$this->getUrl('*/*/*', array('_current'=>true, 'active_tab'=>null, 'tab' => null, 'store'=>null))
			);
		}

		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

		$this->renderLayout();
	}

	public function saveAction()
	{
		$data = $this->getRequest()->getPost();
		$storeId = $this->getRequest()->getParam('store', 0);
		if ($data) {
			$redirectBack = $this->getRequest()->getParam('back', false);
			$this->_initBrand();

			$brand = Mage::registry('current_brand');

			//Zend_Debug::dump($brand); die();


			$brandForm = Mage::getModel('brands/form');
			$brandForm->setEntity($brand)
				->setFormCode('brands_brand');

			$formData = $brandForm->extractData($this->getRequest(), 'brand');
			$errors = $brandForm->validateData($formData);
			if ($errors !== true) {
				foreach ($errors as $error) {
					$this->_getSession()->addError($error);
				}
				$this->_getSession()->setBrandData($data);
				$this->getResponse()->setRedirect($this->getUrl('*/brands_brands/edit', array('id' => $brand->getId())));
				return;
			}

			$brand->setStoreId($storeId)->addData($formData);

			if ($useDefaults = $this->getRequest()->getPost('use_default')) {
				foreach ($useDefaults as $attributeCode) {
					$brand->setStoreId($storeId)->setData($attributeCode, false);
				}
			}

			//Zend_Debug::dump($storeId);
			//Zend_Debug::dump($brand->getData());

			//die();
			$brand->setStoreId($storeId)->save();

			$this->getResponse()->setRedirect($this->getUrl('*/brands_brands/index'));

		}
	}


}