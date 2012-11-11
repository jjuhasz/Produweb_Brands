<?php

class Produweb_Brands_Model_Resource_Brand extends Produweb_Brands_Model_Resource_Abstract
{
    public function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('brands_brand');
        $this->setConnection(
            $resource->getConnection('brands_read'),
            $resource->getConnection('brands_write')
        );
    }
}
