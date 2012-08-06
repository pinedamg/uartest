<?php

class Uar_Custom_Helper_Data
    extends Mage_Core_Helper_Abstract
{
    const REL_EMPTY = 0;
    const REL_ONLY_SIMPLES = 1;
    const REL_ONLY_VIRTUAL = 2;
    const REL_SIMPLES_VIRTUAL = 3;

    public function verifyRelation($_cart)
    {
        $_with_special  = false;
        $_special_shipp = false;
        $_items = $_cart->getItems();

        if (!(bool)count($_items)) {
            return self::REL_EMPTY;
        }

        foreach ($_items as $_item) {
            $_product = $_item->getProduct();
            $_product->load($_product->getId());

            if ($_product->getSpecialShipping() && !$_with_special) {
                $_with_special = true;
                continue;
            }

            if ($_product->isVirtual() && !$_special_shipp) {
                $_special_shipp = true;
                continue;
            }
        }

        switch (true) {
            case $_with_special && $_special_shipp:
                    return self::REL_SIMPLES_VIRTUAL;
                break;
            case $_with_special && !$_special_shipp:
                    return self::REL_ONLY_SIMPLES;
                break;
            case !$_with_special && $_special_shipp:
                    return self::REL_ONLY_VIRTUAL;
                break;
            default:
                    return self::REL_EMPTY;
                break;
        }
    }
}