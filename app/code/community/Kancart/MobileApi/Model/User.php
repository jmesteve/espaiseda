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
class Kancart_MobileApi_Model_User extends Kancart_MobileApi_Model_Abstract {

    public function kancart_user_register() {
        $userData = $this->getRequest()->getParams();
        $session = $this->_getSession();
        $session->setEscapeMessages(true);
        $errors = array();
        $customer = Mage::registry('current_customer');
        if (is_null($customer)) {
            $customer = Mage::getModel('customer/customer')->setId(null);
        }
        if (isset($userData['isSubscribed'])) {
            $customer->setIsSubscribed(1);
        }
        $customer->getGroupId();
        try {
            $desPassword = Kancart::helper('CryptoUtil')->Crypto($userData['pwd'], 'AES-256', KANCART_APP_SECRECT, false);
            $customer->setPassword($desPassword);
            $customer->setConfirmation($this->getRequest()->getPost('confirmation', $desPassword));
            $customer->setData('email', $userData['email']);
            $customer->setData('firstname', $userData['firstname']);
            $customer->setData('lastname', $userData['lastname']);
            $validationResult = count($errors) == 0;
            if (true === $validationResult) {
                $customer->save();
                if ($customer->isConfirmationRequired()) {
                    $customer->sendNewAccountEmail('confirmation', $session->getBeforeAuthUrl(), Mage::app()->getStore()->getId());
                } else {
                    $session->setCustomerAsLoggedIn($customer);
                    $customer->sendNewAccountEmail('registered', '', Mage::app()->getStore()->getId());
                }

                $addressData = $session->getGuestAddress();
                if ($addressData && $customer->getId()) {
                    $address = Mage::getModel('customer/address');
                    $address->setData($addressData);
                    $address->setCustomerId($customer->getId());
                    $address->save();
                    $session->unsGuestAddress();
                }

                return array(true, '0x0000', array());
            } else {
                return array(false, '0x1000', $errors);
            }
        } catch (Mage_Core_Exception $e) {
            if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
                $url = Mage::getUrl('customer/account/forgotpassword');
                $message = $this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url);
                $session->setEscapeMessages(false);
            } else {
                $message = $e->getMessage();
            }
            return array(false, '0x1000', array($message));
        } catch (Exception $e) {
            return array(false, '0x1000', $e->getMessage());
        }
    }

    public function kancart_user_update() {
        $userData = $this->getRequest()->getParams();
        if (!$this->isLoggedIn()) {
            return array(false, '0x0002', 'You need login first.');
        }
        $customer = $this->_getSession()->getCustomer();
        $customerForm = Mage::getModel('customer/form');
        $customerForm->setFormCode('customer_account_edit')
                ->setEntity($customer);
        $errors = array();
        $customerErrors = $customerForm->validateData($userData);
        if ($customerErrors !== true) {
            $errors = array_merge($customerErrors, $errors);
        } else {
            $customerForm->compactData($userData);
            $customerErrors = $customer->validate();
            if (is_array($customerErrors)) {
                $errors = array_merge($customerErrors, $errors);
            }
        }
        if (!empty($errors)) {
            return array(false, '0x1000', $errors);
        }
        try {
            $customer->save();
            $this->_getSession()->setCustomer($customer);
            return array(true, '0x0000', NULL);
        } catch (Mage_Core_Exception $e) {
            return array(false, '0x1000', $e->getMessage());
        } catch (Exception $e) {
            return array(false, '0x1000', $e->getMessage());
        }
    }

    public function kancart_user_login() {
        $userLoginData = $this->getRequest()->getParams();
        $uname = $userLoginData['uname'];
        $pwd = $userLoginData['pwd'];
        $session = $this->_getSession();
        $defaultGroupId = $session->getCustomer()->getGroupId();
        $desPassword = Kancart::helper('CryptoUtil')->Crypto($pwd, 'AES-256', KANCART_APP_SECRECT, false);
        if ($uname != null && $pwd != null) {
            try {
                if ($session->login($uname, $desPassword)) {
                    if ($session->getCustomer()->getIsJustConfirmed()) {
                        $session->getCustomer()->sendNewAccountEmail('confirmed');
                    }

                    if (($orderIds = $session->getOrderIds())) {
                        $order = Mage::getModel('sales/order');
                        $order->setCustomerId($session->getCustomer()->getId());
                        $resource = $order->getResource();
                        foreach ($orderIds as $orderId) {
                            $order->setId($orderId);
                            $resource->saveAttribute($order, 'customer_id');
                        }
                        $session->unsOrderIds();
                    }

                    $customerGroupId = $session->getCustomer()->getGroupId();
                    $cachekey = $defaultGroupId == $customerGroupId ? NULL : 'group_id_' . $customerGroupId;
                    return array(true, '0x0000', array('sessionkey' => md5(time()), 'cachekey' => $cachekey));
                } else {
                    return array(false, '0x1001', Mage::helper('customer')->__('Invalid login or password.'));
                }
            } catch (Mage_Core_Exception $e) {
                switch ($e->getCode()) {
                    case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                        $value = Mage::helper('customer')->getEmailConfirmationUrl($uname);
                        $message = Mage::helper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                        break;
                    case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                        $message = $e->getMessage();
                        break;
                    default:
                        $message = $e->getMessage();
                }
                return array(false, '0x1000', array($message));
            } catch (Exception $e) { //this error do not show for customer
                return array(false, '0x1000', $e->getMessage());
            }
        } else {
            return array(false, '0x1002', $this->__('Login and password are required.'));
        }
    }

    public function kancart_user_get() {
        $userData = $this->getRequest()->getParams();
        if (!$this->isLoggedIn()) {
            return array(false, '0x0002', 'You need login first.');
        }
        $fields = $userData['fields'];
        $session = $this->_getSession();
        return array(true, '0x0000', $this->_toUserData($session->getCustomer()), $fields);
    }

    public function kancart_user_isexists() {
        $userData = $this->getRequest()->getParams();
        $info = array(
            'uname_is_exist' => true
        );
        $customer = Mage::getModel('customer/customer');
        $customer->setStoreId(1);
        $customer->setWebsiteId(1);
        $customer->loadByEmail($userData['email']);
        if ($customer->getData('entity_id')) {
            $info['uname_is_exist'] = true;
        } else {
            $info['uname_is_exist'] = false;
        }
        return array(true, '0x0000', $info);
    }

    public function kancart_user_logout() {
        try {
            $this->_getSession()->logout();
            return array(true, '0x0000', null);
        } catch (Exception $e) {
            return array(false, '0x1000', $e->getMessage());
        }
    }

    public function kancart_user_address_get() {
        $queryData = $this->getRequest()->getParams();
        if (!$this->isLoggedIn()) {
            return array(false, '0x0002', 'You need login first.');
        }
        if (isset($queryData['address_book_id'])) {
            $addressId = $queryData['address_book_id'];
            $customer = $this->_getSession()->getCustomer();
            $address = $customer->getAddressById($addressId);
            if (!is_null($address->getId())) {
                return array(true, '0x0000', array('address' => $this->toAddressData($address)));
            } else {
                return array(false, '0x1000', 'No matched address data.');
            }
        }
        return array(false, '0x1000', 'Parameter address_book_id missing.');
    }

    public function kancart_user_addresses_get() {
        if (!$this->isLoggedIn()) {
            return array(false, '0x0002', 'You need login first.');
        }
        $customer = $this->_getSession()->getCustomer();
        $addressesData = $customer->getAddresses();
        $addresses = array();
        if (count($addressesData)) {
            foreach ($addressesData as $address) {
                $addresses[] = $this->toAddressData($address);
            }
        }
        return array(true, '0x0000', array('addresses' => $addresses));
    }

    public function kancart_user_address_update() {
        $addressData = $this->getRequest()->getParams();
        $session = $this->_getSession();
        if (!$this->isLoggedIn()) {
            return array(false, '0x0002', 'You need login first.');
        }
        if (!is_null($addressData)) {
            $customer = $session->getCustomer();
            $address = Mage::getModel('customer/address');
            $addressId = $addressData['address_book_id'];
            if ($addressId) {
                $existsAddress = $customer->getAddressById($addressId);
                if ($existsAddress->getId() && $existsAddress->getCustomerId() == $customer->getId()) {
                    $address->setId($existsAddress->getId());
                }
            }
            $errors = array();
            try {
                $address->setCustomerId($customer->getId())
                        ->setIsDefaultBilling(isset($addressData['is_default']) && $addressData['is_default'] > 0)
                        ->setIsDefaultShipping(isset($addressData['is_default']) && $addressData['is_default'] > 0);
                $address->setLastname($addressData['lastname']);
                $address->setFirstname($addressData['firstname']);
                $address->setSuffix($addressData['suffix']);
                $address->setTelephone($addressData['telephone']);
                $address->setCompany($addressData['company']);
                $address->setFax($addressData['fax']);
                $address->setPostcode($addressData['postcode']);
                $address->setCity($addressData['city']);
                $address->setStreet(array($addressData['address1'], $addressData['address2']));
                $address->setCountry($addressData['country_name']);
                $address->setCountryId($addressData['country_id']);
                if (isset($addressData['state'])) {
                    $address->setRegion($addressData['state']);
                    $address->setRegionId(null);
                } else {
                    $address->setRegion($addressData['zone_name']);
                    $address->setRegionId($addressData['zone_id']);
                }
                $addressErrors = $address->validate();
                if ($addressErrors !== true) {
                    $errors = array_merge($errors, $addressErrors);
                }
                $addressValidation = count($errors) == 0;
                if (true === $addressValidation) {
                    $address->save();
                    return array(true, '0x0000', $address->getId());
                } else {
                    return array(false, '0x1000', $errors);
                }
            } catch (Mage_Core_Exception $e) {
                return array(false, '0x1000', $e->getMessage());
            } catch (Exception $e) {
                return array(false, '0x1000', $e->getMessage());
            }
        } else {
            return array(false, '0x1011', NULL);
        }
    }

    public function kancart_user_address_add() {
        return $this->kancart_user_address_update();
    }

    public function kancart_user_address_remove() {
        $addressData = $this->getRequest()->getParams();
        if (!$this->isLoggedIn()) {
            return array(false, '0x0002', 'You need login first.');
        }
        $addressId = $addressData['address_book_id'];
        if ($addressId) {
            $address = Mage::getModel('customer/address')->load($addressId);
            if ($address->getCustomerId() != $this->_getSession()->getCustomerId()) {
                return array(false, '0x1000', 'Address does not belong to this customer.');
            }
            try {
                $address->delete();
                return array(true, '0x0000', null);
            } catch (Exception $e) {
                return array(false, '0x1000', $e->getMessage());
            }
        }
    }

    protected function _getSession() {
        return Mage::getSingleton('customer/session');
    }

    protected function _toUserData($customerData) {
        $userData = array(
            'uname' => $customerData->email,
            'nick' => $customerData->firstname . $customerData->lastname,
            'email' => $customerData->email,
            'fax' => null,
            'telephone' => null,
            'default_address_id' => null,
            'dob' => null,
            'lastname' => $customerData->lastname,
            'firstname' => $customerData->firstname,
            'gender' => null,
            'mobile' => null
        );
        return $userData;
    }

}
