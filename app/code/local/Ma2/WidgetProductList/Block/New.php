<?php
class Ma2_WidgetProductList_Block_New 
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
            $productIds = $this->getProductIdsByCategories($catIds);
            $todayDate  = Mage::app()->getLocale()->date()
                            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
            $storeId    = Mage::app()->getStore()->getId();
            
            $collection = Mage::getResourceModel('catalog/product_collection')
                                ->addAttributeToSelect(Mage::getSingleton('catalog/config')
                                ->getProductAttributes())
                                ->setStoreId($storeId)
                                ->addStoreFilter($storeId)
                                ->addMinimalPrice()
                                ->addTaxPercents();                                                          
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
            
            $collection->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))->addAttributeToFilter('news_to_date', array('or'=> array(
            0 => array('date' => true, 'from' => $todayDate),
            1 => array('is' => new Zend_Db_Expr('null')))
            ), 'left');
            
            if(count($productIds)) {
                $collection->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            if(isset($sort_dir) && (!empty($sort_dir) && ($sort_dir == "asc" || $sort_dir="desc")))
            {
                $this->_productCollection = $collection->clear()
                 ->setPageSize($this->getData('products_count'))
                 ->setOrder($sort_by, $sort_dir)
                 ->load();
            }
            else
            {                                   
                $this->_productCollection = $collection->clear()
                 ->setPageSize($this->getData('products_count'))
                 ->load();
            }                                         
        }              
        return $this->_productCollection;
    }  
             
    /**
     *  To html
     */
    public function _toHtml()
    {
		/* 
        $this->assign('WidgetNewProductCollection',$this->_getProductCollection());
        $this->assign('widget_title',$this->getData('widget_title'));
        $this->assign('products_count',$this->getData('products_count'));
        $this->assign('sort_by',$this->getData('sort_by'));
        $this->assign('sort_dir',$this->getData('sort_dir'));
        $this->assign('list_type',$this->getData('list_type'));
        $this->assign('show_addtocart',$this->getData('show_addtocart'));
        $this->assign('show_price',$this->getData('show_price'));
        $this->assign('show_short_description',$this->getData('show_short_description'));
		*/
        $this->assign('_newCollection',$this->_getProductCollection());
		$this->assign('params', json_decode(json_encode($this->getData())));
		
        return parent::_toHtml();
    }      
}