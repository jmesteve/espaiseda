<?php

/**
 * KanCart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@kancart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade KanCart to newer
 * versions in the future. If you wish to customize KanCart for your
 * needs please refer to http://www.kancart.com for more information.
 *
 * @copyright  Copyright (c) 2011 kancart.com (http://www.kancart.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
abstract class Kancart_MobileApi_Model_Abstract {

    public function _construct() {
        
    }

    public function __() {
        $args = func_get_args();
        return Mage::app()->getTranslator()->translate($args);
    }

    /**
     * Retrieve current layout object
     *
     * @return Mage_Core_Model_Layout
     */
    public function getLayout() {
        return Mage::getSingleton('core/layout');
    }

    public function toAddressData($address) {
        if (!$address) {
            return array();
        }
        if (!$address->getLastname() && strpos($address->getFirstname(), ' ') > 0) {
            $name = explode(' ', $address->getFirstname());
            $address->setFirstname($name[0]);
            $address->setLastname($name[1]);
        }
        if ($address->getCustomerAddressId()) {
            $addressId = $address->getCustomerAddressId();
        } else {
            $addressId = $address->getId();
        }
        $defaultAddressId = Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping();
        $addressData = array(
            'address_type' => $address->getAddressType(),
            'address_book_id' => $addressId,
            'is_default' => $addressId == $defaultAddressId,
            'firstname' => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'gender' => $address->getGender(),
            'suffix' => $address->getSuffix(),
            'mobile' => $address->getTelephone(),
            'company' => $address->getCompany(),
            'fax' => $address->getFax(),
            'telephone' => $address->getTelephone(),
            'postcode' => $address->getPostcode(),
            'city' => $address->getCity(),
            'address1' => $address->getStreet(1),
            'address2' => $address->getStreet(2),
            'country_id' => $address->getCountryId(),
            'country_code' => $address->getIso2Code(),
            'country_name' => $address->getCountry(),
            'zone_id' => $address->getRegionId(),
            'zone_name' => $address->getRegion(),
            'state' => $address->getRegion()
        );

        return $addressData;
    }

    protected function getAvailablePayment() {
        $block = Mage::getBlockSingleton('Checkout/Onepage_Payment_Methods');
        if ($block) {
            return $block->getMethods();
        }

        return array();
    }

    protected function getPriceInfos() {
        $PriceInfos = array();
        $position = 0;
        $currency = Mage::app()->getStore()->getCurrentCurrencyCode();
        $block = Mage::getBlockSingleton('Checkout/Cart_Totals');
        method_exists($block, 'canApplyMsrp') && $block->canApplyMsrp();
        foreach ($block->getTotals() as $item) {
            if ($item->getAs()) {
                $type = $item->getAs();
            } else {
                $type = $item->getCode();
            }
            if ($type == 'grand_total') {
                $type = 'total';
            } elseif ($type == 'reward_label') {
                $type = 'info';
            }

            $PriceInfos[] = array(
                'title' => $item->getTitle(),
                'currency' => $currency,
                'type' => $type,
                'price' => $item->getValue(),
                'position' => $position++
            );
        }
        return $PriceInfos;
    }

    /**
     * Retrieve request object
     *
     * @return Mage_Core_Controller_Request_Http
     */
    public function getRequest() {
        return Mage::app()->getRequest();
    }

    /**
     * Retrieve Onepage object
     *
     * @return Mage_Checkout_Model_Type_Onepage
     */
    public function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }

    public function isLoggedIn() {
        return Mage::getSingleton('customer/session')->isLoggedIn();
    }

    public function getCurrencyPrice($price, $format = false, $includeContainer = false) {
        return Mage::helper('core')->currency($price, $format, $includeContainer);
    }

}