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
        $_with_special = false;
        $_special_shipping = false;
        $_msg = '';

        foreach ($_items as $_item) {
            $_product = $_item->getProduct()->load();
            if ($_product->getSpecialShipping() && !$_with_special) {
                $_with_special = true;
                $_msg = 'Special Shipping found for '.$_product->getName()
                    .', please select one Special Shipping Product '
                    .'<a href="#" onclick="special_shipping_popup.showCenter(true);">'
                    ."here</a> </br>";
                continue;
            }
            if ($_product->isVirtual() && !$_special_shipping) {
                $_special_shipping = true;
                $_msg .= 'If they choose a different Special Shipping,'
                    .' the first will removed and the new one will add to the cart';
            }
        }

        if (!$_with_special && !$_special_shipping) {
            return;
        }

        Mage::getSingleton('core/session')->addNotice($_msg);
    }
}