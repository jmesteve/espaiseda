<?php

class Ma2_Slideshow_Model_Mysql4_Slideshow_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slideshow/slideshow');
    }

    public function orderBySort(){
    	$this->getSelect()->order('sortorder');
    	return $this;
    }
}