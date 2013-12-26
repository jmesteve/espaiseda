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
class Kancart_MobileApi_Model_Items extends Kancart_MobileApi_Model_Abstract {

    /**
     * The API interface function
     * @param type $apidata
     * @return type
     */
    public function kancart_items_get() {
        if (isset($_REQUEST['query']) && $_REQUEST['query']) {
            $_REQUEST['query'] = str_replace('%20', ' ', $_REQUEST['query']);
        }
        $params = $this->getRequest()->getParams();
        try {
            $cid = $params['cid'];
            $query = isset($params['query']) ? $params['query'] : false;
            $pageNo = isset($params['page_no']) ? $params['page_no'] : 1;
            $pageSize = isset($params['page_size']) ? $params['page_size'] : 20;
            $orderBy = isset($params['order_by']) && strpos($params['order_by'], ':') > 0 ? $params['order_by'] : 'postion:desc';
            list($order, $direction) = explode(':', $orderBy, 2);
            if (isset($params['item_ids']) && trim($params['item_ids'])) {
                // get by item ids
                $products = $this->getSpecifiedProducts($params['item_ids'], $pageNo, $pageSize, $order, $direction);
            } else if (isset($params['is_specials']) && intval($params['is_specials'])) {
                // get Special Products
                $products = $this->getSpecialProducts($pageNo, $pageSize, $order, $direction);
            } else if (strlen($query)) {
                // get by query
                $products = $this->getProductsByQuery($query, $pageNo, $pageSize, $order, $direction);
            } else if ($cid == -1) {
                // get all products
                $products = $this->getAllProducts($pageNo, $pageSize, $order, $direction);
            } else {
                // get by category
                $products = $this->getProductsByCategory($cid, $pageNo, $pageSize, $order, $direction);
            }
            return array(true, '0x0000', $products);
        } catch (Exception $e) {
            return array(false, '0x0013', $e->getMessage());
        }
    }

    private function getSpecifiedProducts($ids, $pageNo, $pageSize, $order, $direction) {
        $collection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->setCurPage($pageNo)
                ->setPageSize($pageSize);

        if (strlen($ids)) {
            is_string($ids) && $ids = explode(',', $ids);
            $count = count($ids);
            $start = max($pageNo - 1, 0) * $pageSize;
            $itemIds = array_splice($ids, $start, $pageSize);
            $collection->addIdFilter($itemIds);
        } else {
            return array('items' => array(), 'total_results' => 0);
        }

        $collection->load();
        $productList = $collection->getItems();

        $items = array();
        $sortOrder = array();
        $itemObject = Kancart::getModel('Item');
        foreach ($productList as $product) {
            if ($product->getId()) {
                $itemObject->setProduct($product);
                $itemObject->getItemBaseInfo();
                $itemObject->getItemPrices();
                $items[] = $itemObject->getItem();
                $itemObject->clear();
                $sortOrder[] = array_search($product->getId(), $itemIds);
            }
        }
        array_multisort($sortOrder, SORT_ASC, $items);

        $products = array();
        $products['items'] = $items;
        $products['total_results'] = $count;
        return $products;
    }

    private function getSpecialProducts($pageNo, $pageSize, $order, $direction) {
        return $this->getAllProducts($pageNo, $pageSize, $order, $direction, true);
    }

    private function getAllProducts($pageNo, $pageSize, $order, $direction, $specials = false) {
        $layer = Mage::getSingleton('catalog/layer')
                ->setCurrentCategory(Mage::app()->getStore()->getRootCategoryId());
        $collection = Mage::getResourceModel('catalog/product_collection');
        $layer->prepareProductCollection($collection);
        $collection->setCurPage($pageNo)
                ->setPageSize($pageSize)
                ->setOrder($order, $direction);

        if ($specials) {
            $collection->getSelect()->where('`price` > `final_price`');
        }

        $collection->load();
        $size = $collection->getSize();
        $productList = $collection->getItems();

        $items = array();
        $itemObject = Kancart::getModel('Item');
        foreach ($productList as $product) {
            if ($product->getId()) {
                $itemObject->setProduct($product);
                $itemObject->getItemBaseInfo();
                $itemObject->getItemPrices();
                $items[] = $itemObject->getItem();
                $itemObject->clear();
            }
        }
        $products = array();
        $products['items'] = $items;
        $products['total_results'] = $size;
        return $products;
    }

    private function getProductsByQuery($query, $pageNo, $pageSize, $order, $direction) {
        $products = array();
        if ($query) {
            $helper = Mage::helper('catalogsearch');
            $this->getRequest()->setParam($helper->getQueryParamName(), $query);
            $query = $helper->getQuery();
            $query->setStoreId(Mage::app()->getStore()->getId());
            if ($query->getQueryText()) {
                if ($helper->isMinQueryLength()) {
                    $query->setId(0)
                            ->setIsActive(1)
                            ->setIsProcessed(1);
                } else {
                    if ($query->getId()) {
                        $query->setPopularity($query->getPopularity() + 1);
                    } else {
                        $query->setPopularity(1);
                    }
                    if (false && $query->getRedirect()) {
                        $query->save();
                        return array();
                    } else {
                        $query->prepare();
                    }
                }
                $helper->checkNotes();
                if (!Mage::helper('catalogsearch')->isMinQueryLength()) {
                    $query->save();
                }
            }

            $layer = Mage::getSingleton('catalogsearch/layer');
            $collection = $layer->getProductCollection()
                    ->setCurPage($pageNo)
                    ->setPageSize($pageSize)
                    ->setOrder($order, $direction);

            $collection->load();
            $size = $collection->getSize();
            $productList = $collection->getItems();

            $items = array();
            $itemObject = Kancart::getModel('Item');
            foreach ($productList as $product) {
                if ($product->getId()) {
                    $itemObject->setProduct($product);
                    $itemObject->getItemBaseInfo();
                    $itemObject->getItemPrices();
                    $items[] = $itemObject->getItem();
                    $itemObject->clear();
                }
            }

            $products['items'] = $items;
            $products['total_results'] = $size;
        }

        return $products;
    }

    private function getProductsByCategory($cid = false, $pageNo = 1, $pageSize = 20, $order = 'entity_id', $direction = 'desc') {
        $layer = Mage::getSingleton('catalog/layer')->setCurrentCategory($cid);
        $collection = $layer->getProductCollection()
                ->setCurPage($pageNo)
                ->setPageSize($pageSize)
                ->setOrder($order, $direction);

        $collection->load();
        $size = $collection->getSize();
        $productList = $collection->getItems();

        $items = array();
        $itemObject = Kancart::getModel('Item');
        foreach ($productList as $product) {
            if ($product->getId()) {
                //  Mage::getModel('cataloginventory/stock_item')->assignProduct($product);
                $itemObject->setProduct($product);
                $itemObject->getItemBaseInfo();
                $itemObject->getItemPrices();
                $items[] = $itemObject->getItem();
                $itemObject->clear();
            }
        }
        $products = array();
        $products['items'] = $items;
        $products['total_results'] = $size;
        return $products;
    }

}

?>
