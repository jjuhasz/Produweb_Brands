<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jona
 * Date: 21/11/12
 * Time: 0:57
 * To change this template use File | Settings | File Templates.
 */ 
class Produweb_ProtoZoom_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getConfig($field, $group = "config", $section = "protozoom") {
		$storeId = Mage::app()->getStore()->getId();
		return Mage::getStoreConfig($section.'/'.$group.'/'.$field, $storeId);
	}
}