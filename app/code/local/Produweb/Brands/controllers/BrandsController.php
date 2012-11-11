<?php

class Produweb_Brands_BrandsController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $model = Mage::getModel('brands/brand');
        $model->load(1);
        Zend_Debug::dump($model);
        die('ok');
    }

    public function setupAction()
    {
        for($i=0;$i<10;$i++) {
            $weblog2 = Mage::getModel('brands/brand');
            $weblog2->setTitle('This is a test '.$i);
            $weblog2->setDescription('This is a description '.$i);
            $weblog2->setSlug('slug'.$i);
            $weblog2->save();
        }
    }
}