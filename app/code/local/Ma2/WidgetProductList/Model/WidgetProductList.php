<?php
class Ma2_WidgetProductList_Model_WidgetProductList extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('catalog/product'); // this is location of the resource file.
    }
}