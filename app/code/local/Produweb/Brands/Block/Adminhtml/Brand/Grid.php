<?php

class Produweb_Brands_Block_Adminhtml_Brand_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('brandGrid');
      $this->setDefaultSort('entity_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setVarNameFilter('brand_filter');

  }

  protected function _getStore()
  {
      $storeId = (int) $this->getRequest()->getParam('store', 0);
      return Mage::app()->getStore($storeId);
  }

  protected function _prepareCollection()
  {
      $store = $this->_getStore();
      $collection = Mage::getModel('brands/brand')->getCollection()
          ->addAttributeToSelect('*');

      if ($store->getId()) {
         // $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
          //$collection->addStoreFilter($store);
      }

      $this->setCollection($collection);

      parent::_prepareCollection();
      return $this;

  }

  protected function _prepareColumns()
  {
      $this->addColumn('entity_id',
          array(
              'header'=> Mage::helper('brands')->__('ID'),
              'width' => '50px',
              'type'  => 'number',
              'index' => 'entity_id',
          ));
      $this->addColumn('title',
          array(
              'header'=> Mage::helper('brands')->__('Title'),
              'index' => 'title',
          ));

      $this->addColumn('slug',
          array(
              'header'=> Mage::helper('brands')->__('Slug'),
              'index' => 'slug',
          ));


      $this->addColumn('action',
          array(
              'header'    => Mage::helper('brands')->__('Action'),
              'width'     => '50px',
              'type'      => 'action',
              'getter'     => 'getId',
              'actions'   => array(
                  array(
                      'caption' => Mage::helper('brands')->__('Edit'),
                      'url'     => array(
                          'base'=>'*/*/edit',
                          'params'=>array('store'=>$this->getRequest()->getParam('store'))
                      ),
                      'field'   => 'id'
                  )
              ),
              'filter'    => false,
              'sortable'  => false,
              'index'     => 'stores',
          ));

      return parent::_prepareColumns();
  }

  protected function _prepareMassaction()
  {
      $this->setMassactionIdField('entity_id');
      $this->getMassactionBlock()->setFormFieldName('brand');

      $this->getMassactionBlock()->addItem('delete', array(
          'label'=> Mage::helper('brands')->__('Delete'),
          'url'  => $this->getUrl('*/*/massDelete'),
          'confirm' => Mage::helper('brands')->__('Are you sure?')
      ));


      Mage::dispatchEvent('adminhtml_catalog_product_grid_prepare_massaction', array('block' => $this));
      return $this;
  }

	public function getGridUrl()
	{
    	return $this->getUrl('*/*/grid', array('_current'=>true));
	}

	public function getRowUrl($row)
	{
		return  $this->getUrl('*/*/edit', array(
        	'store'=>$this->getRequest()->getParam('store'),
        	'id'=>$row->getId())
    	);
	}
}

