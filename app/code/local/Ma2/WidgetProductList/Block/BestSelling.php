<?php
class Ma2_WidgetProductList_Block_BestSelling 
extends Mage_Catalog_Block_Product_Abstract
implements Mage_Widget_Block_Interface
{
     /**
     * A model to serialize attributes
     * @var Varien_Object
     */
    protected $_serializer = null;
    
    protected $_final = null;
    
    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();    
    }
    
    /**
     * Get products collection
     */     
    protected function _getProductCollection()
	{        	 
        if (is_null($this->_productCollection)) 
        {
            $visibility = array(
                      Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                      Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG);

            $storeId = Mage::app()->getStore()->getId();
            $collection = Mage::getResourceModel('reports/product_collection')
                              ->addAttributeToSelect('*')
                              ->addOrderedQty()
                              ->addAttributeToFilter('visibility', $visibility)
                              ->setStoreId($storeId)
                              ->addStoreFilter($storeId)
                              ->setPageSize($this->getData('products_count'))
                              ->setOrder('ordered_qty', 'DESC');                                                $this->_productCollection = $collection;                                                             		         
        }              
        return $this->_productCollection;
    }  
             
    /**
     *  To html
     */    
    public function _toHtml()
    {
        /* $this->assign('WidgetBestSellingProductCollection',$this->_getProductCollection());        
        $this->assign('widget_title',$this->getData('widget_title'));
        $this->assign('products_count',$this->getData('products_count'));    
        $this->assign('list_type',$this->getData('list_type'));
        $this->assign('show_addtocart',$this->getData('show_addtocart'));
        $this->assign('show_price',$this->getData('show_price'));
        $this->assign('show_short_description',$this->getData('show_short_description'));
		*/
		
		$this->assign('_bestsellingCollection',$this->_getProductCollection());
		$this->assign('params', json_decode(json_encode($this->getData())));
		
        return parent::_toHtml();
    }    
}