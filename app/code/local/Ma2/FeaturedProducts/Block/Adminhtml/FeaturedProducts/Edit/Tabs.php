<?php
class Ma2_FeaturedProducts_Block_Adminhtml_FeaturedProducts_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('FeaturedProducts_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('FeaturedProducts')->__('News Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('FeaturedProducts')->__('Item Information'),
            'title'     => Mage::helper('FeaturedProducts')->__('Item Information'),
            'numberaction'  => Mage::helper('FeaturedProducts')->__('Item Information'),
            'content'   => $this->getLayout()->createBlock('FeaturedProducts/adminhtml_FeaturedProducts_edit_tab_form')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}