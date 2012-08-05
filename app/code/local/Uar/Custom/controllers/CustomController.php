<?php

class Uar_Custom_CustomController
    extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function selectAction()
    {
        $_product_id = $this->getRequest()->getParam('product_id');

        $_product_model = Mage::getModel('catalog/product');
        $_product_model->load($_product_id);
        $_qty = 1;

        $cart = Mage::getSingleton('checkout/cart');
        $cart->addProduct($_product_model, array('qty' => $_qty));
        $cart->save();

        Mage::getSingleton('checkout/session')->setCartWasUpdated(true);

        $this->getResponse()->setBody(
            Mage::helper('core')->jsonEncode((array('response'=>'CLARO')))
        );
    }
}