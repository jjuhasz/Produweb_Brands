<?php

class Produweb_Brands_Model_Entity_Setup extends Mage_Eav_Model_Entity_Setup
{
    public function getDefaultEntities()
    {
        return array(
            'brands_brand' => array(
                'entity_model' => 'brands/brand',
                'attribute_model' => '',
                'table' => 'brands/brand',
                'attributes' => array(
                    'title' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Titre',
                        'input' => '',
                        'class' => '',
                        'source' => '',
                        'global' => 0, // store scope == 0 // global scope == 1 // website scope == 2
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'unique'            => false,
                    ),
                    'description' => array(
                        'type' => 'text',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'Description',
                        'input' => '',
                        'class' => '',
                        'source' => '',
                        'global' => 0, // store scope == 0 // global scope == 1 // website scope == 2
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'unique'            => false,
                    ),
                    'slug' => array(
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => 'SLUG Key',
                        'input' => '',
                        'class' => '',
                        'source' => '',
                        'global' => 0, // store scope == 0 // global scope == 1 // website scope == 2
                        'visible' => true,
                        'required' => true,
                        'user_defined' => true,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'unique'            => false,
                    )
                )
            )
        );
    }
}