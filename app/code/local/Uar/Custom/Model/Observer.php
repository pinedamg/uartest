<?php

class Uar_Custom_Model_Observer
{
    public function isSpecialShipping($_observer)
    {
        $_event         = $_observer->getEvent();
        $_cart          = $_observer->getCart();
        $_msg           = '';
        $_helper        =  Mage::helper('custom');
        /*@var $_helper Uar_Custom_Helper_Data*/
        
        $_status = $_helper->verifyRelation($_cart);

        if ($_status == Uar_Custom_Helper_Data::REL_EMPTY
                || $_status == Uar_Custom_Helper_Data::REL_ONLY_VIRTUAL) {
            return;
        }

        if ($_status == Uar_Custom_Helper_Data::REL_ONLY_SIMPLES) {
            $_cart->getCheckoutSession()->unsMessages();
            $_msg = 'Special Shipping found, please select one Special Shipping Product '
                    .'<a href="#" onclick="special_shipping_popup.showCenter(true);">'
                    ."here</a>";
        }

        if ($_status == Uar_Custom_Helper_Data::REL_SIMPLES_VIRTUAL) {
            $_msg = 'If they choose a different Special Shipping,'
                    .' the first will removed and the new one will add to the cart '
                    .'<a href="#" onclick="special_shipping_popup.showCenter(true);">'
                    ."add other</a>";
        }

        $_cart->getCheckoutSession()->addUniqueMessages(
            Mage::getModel('core/message_notice', $_msg)
        );
    }

    public function removeSpecialShipping($_observer)
    {
        $_event         = $_observer->getEvent();
        $_cart          = $_observer->getCart();
        $_msg           = '';
        $_helper        =  Mage::helper('custom');
        /*@var $_helper Uar_Custom_Helper_Data*/
        
        $_status = $_helper->verifyRelation($_cart);

        if ($_status == Uar_Custom_Helper_Data::REL_EMPTY) {
            return;
        }

        if ($_status == Uar_Custom_Helper_Data::REL_ONLY_VIRTUAL) {
            $_items = $_cart->getItems();
            foreach ($_items as $_item_id => $_item) {
                $_product = $_item->getProduct();
                $_product->load($_product->getId());
                if ( $_product->isVirtual() ) {
                    $_cart->removeItem($_item_id);
                    $_cart->getCheckoutSession()->unsMessages();
                }
            }
        }
    }
    
    public function verifyOnlyOne($_observer)
    {
        $_event         = $_observer->getEvent();
        $_quote_item    = $_observer->getQuoteItem();
        $_product_item  = $_observer->getProduct();
        $_cart          = Mage::getSingleton('checkout/cart');
        $_helper        =  Mage::helper('custom');
        /*@var $_helper Uar_Custom_Helper_Data*/
        
        $_status = $_helper->verifyRelation($_cart);

        if ($_status == Uar_Custom_Helper_Data::REL_SIMPLES_VIRTUAL
                && $_product_item->isVirtual()) {

            $_items = $_cart->getItems();
            foreach ($_items as $_item_id => $_item) {
                $_product = $_item->getProduct();
                $_product->load($_product->getId());
                if ($_product->isVirtual() && $_product_item->getId()!=$_product->getId()) {
                    $_cart->removeItem($_item_id);
                }
            }
        }
    }
}