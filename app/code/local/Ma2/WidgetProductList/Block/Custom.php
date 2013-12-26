<?php
class Ma2_WidgetProductList_Block_Custom
extends Mage_Catalog_Block_Product_Abstract
implements Mage_Widget_Block_Interface
{    
    protected function _beforeToHtml() {

        $ids = $this->getData('ids');
        if ($ids) {
            $ids = explode('}{', $ids);
            $cleanIds = array();
            foreach ($ids as $id) {
                $id = str_replace('{', '', $id);
                $id = str_replace('}', '', $id);
                $cleanIds[] = $id;
            }
            if (count($cleanIds)) {
                $products = $this->_getProductsByIDs($cleanIds);
                if ($products) {
                    $this->setProductCollection($products);
                }
            }
        }

        return parent::_beforeToHtml();
    }

    protected function _getProductsByIDs($ids) {
      
        $products = Mage::getModel('catalog/product')->getResourceCollection()
                        ->addAttributeToSelect('*') 
                        ->addStoreFilter(Mage::app()->getStore()->getId())
                        ->setOrder($this->getData('sort_by'), $this->getData('sort_dir'));
                        
        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($products);
        $products->addFieldToFilter('entity_id', array('in' => $ids));            
        $products->load();
                             
        return $products;
    } 
    
    public function _toHtml()
    {
        /* $this->assign('widget_title',$this->getData('widget_title')); 
        $this->assign('ids',$this->getData('ids'));              
        $this->assign('sort_by',$this->getData('sort_by'));
        $this->assign('sort_dir',$this->getData('sort_dir'));
        $this->assign('list_type',$this->getData('list_type'));
        $this->assign('show_addtocart',$this->getData('show_addtocart'));
        $this->assign('show_price',$this->getData('show_price'));
        $this->assign('show_short_description',$this->getData('show_short_description'));
         */
		
		$this->assign('params', json_decode(json_encode($this->getData())));
		
        return parent::_toHtml();
    }
}