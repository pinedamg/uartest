<?php

class Uar_Custom_Model_Observer
{
    /**
     * @name isSpecialShipping
     * @access public
     * @param type $_observer
     * @return mixed
     */
    public function isSpecialShipping($_observer)
    {
        $_event = $_observer->getEvent();
        $_cart = $_observer->getCart();
        $_items = $_cart->getItems();
        $_product = null;

        foreach ($_items as $_item) {
            $_product = $_item->getProduct()->load();
            if ($_product->getSpecialShipping()) {
                break;
            }
            return;
        }

        $_msg = 'Special Shipping found for product '.$_product->getName();

        Mage::getSingleton('core/session')->addNotice($_msg);
    }
}