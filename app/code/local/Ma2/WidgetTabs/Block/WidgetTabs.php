<?php
class Ma2_WidgetTabs_Block_WidgetTabs 
extends Mage_Catalog_Block_Product_Abstract
implements Mage_Widget_Block_Interface
{
	/**
     * A model to serialize attributes
     * @var Varien_Object
     */
    protected $_serializer = null;
    
    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();    
    }
    
    protected function _toHtml()
    {
        //echo "<pre>";
        //var_dump(json_decode($this->getData('tab_item'),true)); 
        //$data = json_decode($this->getData('tab_item'),true);
        //return $data;
        
        $this->assign('tabsData',json_decode($this->getData('tab_item'),true));
        return parent::_toHtml();
    } 

	
}