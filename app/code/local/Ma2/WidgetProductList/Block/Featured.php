<?php
class Ma2_WidgetProductList_Block_Featured
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
            $attributes = Mage::getSingleton('catalog/config')
                            ->getProductAttributes();            
            $collection = Mage::getModel('catalog/product')->getCollection();    	          
            $collection->addAttributeToSelect($attributes)
                        ->addMinimalPrice()
                        ->addFinalPrice()
                        ->addTaxPercents()
                        ->addAttributeToFilter('ma2_featured_product', 1, 'left')
                        ->addStoreFilter()
                        ->getSelect();
            
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);                           
            
            if(isset($sort_dir) && (!empty($sort_dir) && ($sort_dir == "asc" || $sort_dir="desc")))
            { 
                $_collection = $collection->clear()
                ->setPageSize($this->getData('products_count'))
                ->setOrder($sort_by, $sort_dir)
                ->load();
                $this->_productCollection = $_collection; 
            }
            else
            {                        
                $_collection = $collection->clear()
                ->setPageSize($this->getData('products_count'))
                ->load(); 
                $this->_productCollection = $_collection;            
            }                    		         
        }              
        return $this->_productCollection;
    }  
             
    /**
     *  To html
     */        
    protected function _toHtml()
    { 
        /* $this->assign('WidgetFeaturedProductCollection',$this->_getProductCollection()); 
        $this->assign('widget_title', $this->getData('widget_title'));
        $this->assign('products_count', $this->getData('products_count'));
        $this->assign('sort_by', $this->getData('sort_by')); // name, price, created_at
        $this->assign('sort_dir', $this->getData('sort_dir')); // asc, desc
        $this->assign('list_type', $this->getData('list_type'));
        $this->assign('show_addtocart', $this->getData('show_addtocart'));
        $this->assign('show_price',$this->getData('show_price'));
        $this->assign('show_short_description',$this->getData('show_short_description')); 
		*/
		$this->assign('_featuredCollection',$this->_getProductCollection());
		$this->assign('params', json_decode(json_encode($this->getData())));
		
        return parent::_toHtml();
    }     
}
