<?php

class Ma2_FeaturedProducts_IndexController extends Mage_Core_Controller_Front_Action
{
     public function indexAction()
     {
          if (!Mage::helper('FeaturedProducts')->getIsActive()) {
                $this->_forward('noRoute');
                return;
            }
    
            $template = Mage::getConfig()->getNode('global/page/layouts/' . Mage::getStoreConfig("FeaturedProducts/standalone/layout") . '/template');
  
          $this->loadLayout();     
          
          $this->getLayout()->getBlock('root')->setTemplate($template);
        $this->getLayout()->getBlock('head')->setTitle($this->__(Mage::getStoreConfig("FeaturedProducts/standalone/meta_title")));
        $this->getLayout()->getBlock('head')->setDescription($this->__(Mage::getStoreConfig("FeaturedProducts/standalone/meta_description")));
        $this->getLayout()->getBlock('head')->setKeywords($this->__(Mage::getStoreConfig("FeaturedProducts/standalone/meta_keywords")));

        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
        $breadcrumbsBlock->addCrumb('FeaturedProducts', array(
            'label' => Mage::helper('FeaturedProducts')->__(Mage::helper('FeaturedProducts')->getPageLabel()),
            'title' => Mage::helper('FeaturedProducts')->__(Mage::helper('FeaturedProducts')->getPageLabel()),
        ));
               
          $this->renderLayout();
     }
}