<?php

class Uar_Custom_Block_List
    extends Mage_Catalog_Block_Product_Abstract
{
    protected $_items;

    protected function _prepareLayout()
    {
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->setTitle(Mage::helper('custom')->__('Special Shipping Products List'));
        }
        return parent::_prepareLayout();
    }

    public function getItems()
    {
        if (is_null($this->_items)) {
            $this->_items = Mage::getModel('catalog/product')
                ->getCollection()
                    ->addAttributeToFilter('type_id',array('eq'=>'virtual'))
                    ->addAttributeToSelect('name')
                    ->addAttributeToSelect('short_description')
                    ->load();
        }

        return $this->_items;
    }
}
