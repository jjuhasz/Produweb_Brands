<?php

$installer = $this;

$installer->addEntityType('brands_brand', array(
    'entity_model' => 'brands/brand',
    'attribute_model' => '',
    'table' => 'brands/brand',
    'increment_model' => '',
    'increment_per_store' => '0'
));
