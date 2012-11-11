<?php

class Produweb_Brands_Model_Resource_Brand_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('brands/brand');
    }
}