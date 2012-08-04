<?php




/* @var $installer Uar_Custom_Model_Entity_Setup */
$installer = $this;

/* @var $setup Mage_Eav_Model_Entity_Setup */
$setup = new Mage_Catalog_Model_Resource_Setup('core_setup');

$installer->startSetup();

$setup->addAttribute('catalog_product', 'special_shipping', array(
    'group'                         => 'General',
    'input'                         => 'select',
    'type'                          => 'int',
    'label'                         => 'Special Shipping',
    'backend'                       => '',
    'source'                        => 'eav/entity_attribute_source_boolean',
    'visible'                       => 1,
    'required'                      => 0,
    'user_defined'                  => 1,
    'searchable'                    => 1,
    'filterable'                    => 0,
    'comparable'                    => 1,
    'visible_on_front'              => 1,
    'visible_in_advanced_search'    => 0,
    'is_html_allowed_on_front'      => 0,
    'global'                        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'apply_to'                      => 'simple',
    'is_configurable'               => 0,
));

$installer->endSetup();