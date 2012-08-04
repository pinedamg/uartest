<?php

/* @var $installer Uar_Custom_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

Mage::app()->getStore()->setWebsiteId(1);

/** Add Category **/

$_parent_category = Mage::getModel('catalog/category')->load(2);

$_category = new Mage_Catalog_Model_Category();
$_category->setName('Sample Category')
    ->setIsActive(1)
    ->setIsAnchor(0)
    ->setPath($_parent_category->getPath());

$_category->save();
$_category_id = $_category->getId();

/** Add virtual and simple products **/

$_example_products = array(
    'virtual' => array(
        'name' => 'Special Shipping ',
        'sku' => 'skuspecialshipping',
        'description' => 'Description Special Shipping',
    ),
    'simple' => array(
        'name' => 'Simple Product',
        'sku' => 'skusimple',
        'description' => 'Description Simple Product',
    ),
);

foreach($_example_products as $_type => $_sample_product) {
    for($i=1; $i<4;$i++) {
        $data = array(
            'name'                      => $_sample_product['name'].$i,
            'sku'                       => $_sample_product['sku'].$i,
            'attribute_set_id'          => 4,
            'type_id'                   => $_type,
            'website_ids'               => array(1),
            'description'               => $_sample_product['description'].$i,
            'short_description'         => $_sample_product['description'].$i,
            'price'                     => '0',
            'tax_class_id'              => 0,
            'visibility'                => Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE,
            'status'                    => Mage_Catalog_Model_Product_Status::STATUS_ENABLED,
            'category_ids'              => array($_category_id),
            'is_scope_store'            => 0,
            'has_options'               => true,
            'required_options'          => true,
            'options_container'         => 'container2',
            'stock_data'                => array(
                'manage_stock'          => false,
                'is_in_stock'           => true,
                'use_config_manage_stock' => false
            ),
        );

        if ($_type == 'simple') {
            unset($data['use_config_manage_stock']);
            $data['visibility']             = Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH;
            $data['price']                  = rand(35,105);
            $data['special_shipping']       = true;
            $data['stock_data'] = array(
                'manage_stock'              => true,
                'is_in_stock'               => true,
                'qty'                       => rand(25, 75),
            );
        }

        $product = Mage::getModel('catalog/product');
        $product->setData($data)->save();
    }
}

$installer->endSetup();