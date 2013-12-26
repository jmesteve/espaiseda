<?php
class Ma2_FeaturedProducts_Adminhtml_FeaturedProductsController extends Mage_Adminhtml_Controller_Action
{
      protected function _initAction()
      {
            $this->loadLayout()
            ->_setActiveMenu('FeaturedProducts/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            return $this;
      }
      public function indexAction()
      {
         $this->_initAction();       
         $this->_addContent($this->getLayout()->createBlock('FeaturedProducts/adminhtml_FeaturedProducts'));
         $this->renderLayout();
      }
      public function editAction()
      {
        $FeaturedProductsId     = $this->getRequest()->getParam('id');
        $FeaturedProductsModel  = Mage::getModel('FeaturedProducts/FeaturedProducts')->load($FeaturedProductsId);
 
        if ($FeaturedProductsModel->getId() || FeaturedProductsId == 0) {
            Mage::register('FeaturedProducts_data', $FeaturedProductsModel);
            $this->loadLayout();
            $this->_setActiveMenu('FeaturedProducts/items');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('FeaturedProducts/adminhtml_FeaturedProducts_edit'))
                 ->_addLeft($this->getLayout()->createBlock('FeaturedProducts/adminhtml_FeaturedProducts_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('FeaturedProducts')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
       }
       public function newAction()
       {
          $this->_forward('edit');
       }
       public function saveAction()
       {
          if ($data = $this->getRequest()->getPost() ) {                                         
            try {
                $postData = $this->getRequest()->getPost();
                $FeaturedProductsModel = Mage::getModel('FeaturedProducts/FeaturedProducts');
                           
                $FeaturedProductsModel->setId($this->getRequest()->getParam('id'))
                                    ->setTitle($postData['title'])
                                    ->setNumberaction($postData['numberaction'])                    
                                    ->setStatus($postData['status'])
                                    ->save();
                           
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFeaturedProductsData(false);
             
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFeaturedProductsData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        else {                
            if(isset($data['numberaction']['delete']) && $data['numberaction']['delete'] == 1){
                        $data['FeaturedProducts_main'] = '';
            }
            else{
                unset($data['numberaction']);
            }
         }                    
        $this->_redirect('*/*/');                        
       }
       public function deleteAction()
       {
              if($this->getRequest()->getParam('id') > 0)
              {
                try
                {
                    $FeaturedProductsModel = Mage::getModel('FeaturedProducts/FeaturedProducts');
                    $FeaturedProductsModel->setId($this->getRequest()
                                        ->getParam('id'))
                              ->delete();
                    Mage::getSingleton('adminhtml/session')
                               ->addSuccess('successfully deleted');
                    $this->_redirect('*/*/');
                    
                    
                 }
                 catch (Exception $e)
                  {
                           Mage::getSingleton('adminhtml/session')
                                ->addError($e->getMessage());
                           $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                  }
             }
            $this->_redirect('*/*/');
       }
       /**
         * Product grid for AJAX request.
         * Sort and filter result for example.
         */
        public function gridAction()
        {
            $this->loadLayout();
            $this->getResponse()->setBody(
                   $this->getLayout()->createBlock('FeaturedProducts/adminhtml_FeaturedProducts_grid')->toHtml()
            );
        }
}