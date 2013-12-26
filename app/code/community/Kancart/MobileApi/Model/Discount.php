<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Kancart_MobileApi_Model_Discount extends Mage_SalesRule_Model_Quote_Discount {

    public function collect(Mage_Sales_Model_Quote_Address $address) {
        $address->setDiscountAmount(0);
        $address->setSubtotalWithDiscount(0);
        $address->setBaseDiscountAmount(0);
        $address->setBaseSubtotalWithDiscount(0);

        parent::collect($address);
        if ($address->getAddressType() == Mage_Sales_Model_Quote_Address::TYPE_BILLING) {
            return $this;
        }

        $totalDiscountAmount = $this->getRequest()->getParam('discount_amount');
        if ($totalDiscountAmount && !is_numeric($totalDiscountAmount)) {
            $totalDiscountAmount = $address->getBaseSubtotal() * floatval($totalDiscountAmount) / 100;
        }

        $freeShipping = $this->getRequest()->getParam('coupon_free_ship');
        if ($freeShipping && $freeShipping > 0 && $address->getShippingAmount()) {
            $totalDiscountAmount+=$address->getShippingAmount();
        }

        if ($totalDiscountAmount <= 0) {
            return $this;
        }

        $totalDiscountAmount += $address->getDiscountAmount();
        $subtotalWithDiscount = $totalDiscountAmount + $address->getSubtotalWithDiscount();
        $baseTotalDiscountAmount = $totalDiscountAmount + $address->getBaseDiscountAmount();
        $baseSubtotalWithDiscount = $totalDiscountAmount + $address->getBaseSubtotalWithDiscount();

        $address->setDiscountAmount($totalDiscountAmount);
        $address->setSubtotalWithDiscount($subtotalWithDiscount);
        $address->setBaseDiscountAmount($baseTotalDiscountAmount);
        $address->setBaseSubtotalWithDiscount($baseSubtotalWithDiscount);

        $address->setGrandTotal($address->getGrandTotal() - $totalDiscountAmount);
        $address->setBaseGrandTotal($address->getBaseGrandTotal() - $totalDiscountAmount);
        return $this;
    }

    /**
     * Retrieve request object
     *
     * @return Mage_Core_Controller_Request_Http
     */
    public function getRequest() {
        return Mage::app()->getRequest();
    }

}

