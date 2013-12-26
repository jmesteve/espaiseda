<?php

class Ma2_Slideshow_Block_Adminhtml_Slideshow_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('slideshow_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('slideshow')->__('Item Information'));
  }

  protected function _prepareLayout()
  {
	//$return = parent::_prepareLayout();
	
      $this->addTab('main_section', array(
          'label'     => Mage::helper('slideshow')->__('Item Information'),
          'title'     => Mage::helper('slideshow')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('slideshow/adminhtml_slideshow_edit_tab_form')->toHtml(),
		  'active'	  => true,
      ));
     
      return parent::_prepareLayout();
  }
}