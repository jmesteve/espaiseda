<?php
class Ma2_FeaturedProducts_Block_Listing extends Mage_Catalog_Block_Product_Abstract 
{
    public function __construct() {

        $this->setTemplate('ma2/featuredproducts/block_featured_products.phtml');

        $this->setLimit((int) Mage::getStoreConfig("FeaturedProducts/cmspage/number_of_items"));
        $sort_by = Mage::getStoreConfig("FeaturedProducts/cmspage/product_sort_by");
        $this->setItemsPerRow((int) Mage::getStoreConfig("FeaturedProducts/cmspage/number_of_items_per_row"));

        switch ($sort_by) {
            case 0:
                $this->setSortBy("rand()");
                break;
            case 1:
                $this->setSortBy("created_at desc");
                break;
            default:
                $this->setSortBy("rand()");
        }
    }

    /*
     * Load featured products collection
     * */

    protected function _beforeToHtml() {
        $collection = Mage::getResourceModel('catalog/product_collection');

        $attributes = Mage::getSingleton('catalog/config')
                ->getProductAttributes();

        $collection->addAttributeToSelect($attributes)
                ->addMinimalPrice()
                ->addFinalPrice()
                ->addTaxPercents()
                ->addAttributeToFilter('ma2_featured_product', 1, 'left')
                ->addStoreFilter()
                ->getSelect()->order($this->getSortBy())->limit($this->getLimit());

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        $this->_productCollection = $collection;

        $this->setProductCollection($collection);
        return parent::_beforeToHtml();
    }

    protected function _toHtml() {

        if (!$this->helper('FeaturedProducts')->getIsActive()) {
            return '';
        }

        return parent::_toHtml();
    }

    /*
     * Return label for CMS block output
     * */

    protected function getBlockLabel() {
        return $this->helper('FeaturedProducts')->getCmsBlockLabel();
    }

}