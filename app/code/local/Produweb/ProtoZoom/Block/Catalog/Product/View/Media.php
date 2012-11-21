<?php

class Produweb_ProtoZoom_Block_Catalog_Product_View_Media extends Mage_Catalog_Block_Product_View_Media
{
	protected function _beforeToHtml()
	{
		parent::_beforeToHtml();
		$this->setTemplate('protozoom/catalog/product/view/media.phtml');
	}
}