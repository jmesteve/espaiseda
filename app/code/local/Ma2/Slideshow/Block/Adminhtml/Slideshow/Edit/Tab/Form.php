<?php

class Ma2_Slideshow_Block_Adminhtml_Slideshow_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		if(Mage::getSingleton('cms/wysiwyg_config')->isEnabled())
		{
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}
	}
  
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
	  $form->setHtmlIdPrefix('slideshow_');
      $this->setForm($form);
      $fieldset = $form->addFieldset('slideshow_form', array('legend'=>Mage::helper('slideshow')->__('Item information')));
     
	  $slideshow = Mage::getModel('slideshow/slideshow')->load( $this->getRequest()->getParam('id') );
      $after_html = '';
      if( $slideshow->getFilename() )
      {
          $path = Mage::getBaseUrl('media')."ma2slideshow/".$slideshow->getFilename();
          $after_html = '<a onclick="imagePreview(ma2slideshow); return false;" href="'.$path.'">
                  <img height="22" width="22" class="small-image-preview v-middle" alt="'.$slideshow->getFilename().'" title="'.$slideshow->getFilename().'" id="ma2slideshow" src="'.$path.'"/>
                  </a>';
      }
	  
	  try {
		$config = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
		$config->setData(
			Mage::helper('slideshow')->recursiveReplace('/slideshow/', '/' . (string) Mage::app()->getConfig()->getNode('admin/routers/adminhtml/args/frontName') . '/', $config->getData()
			)
		);
	  } catch (Exception $ex) {
		$config = null;
	  }
	 
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
	  
	  $fieldset->addField('category', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Category'),
		  'class'     => 'required-entry',
		  'required'  => true,
          'name'      => 'category',
	  ));
	  
	   $fieldset->addField('slideshow_url', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Url'),
          'name'      => 'slideshow_url',
		  'note'      => Mage::helper('slideshow')->__('Example: http://www.example.com'),
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('slideshow')->__('File'),
          'name'      => 'filename',
          'after_element_html' => $after_html,
          'class'     => (($slideshow->getfilename()) ? '' : 'required-entry'),
          'required'  => (($slideshow->getfilename()) ? false : true),
	  ));
	  
	  /**
       * Check is single store mode
       */
      /* if (!Mage::app()->isSingleStoreMode()) {
          $fieldset->addField('store_id', 'multiselect',
                  array (
                          'name' => 'stores[]',
                          'label' => Mage::helper('cms')->__('Store view'),
                          'title' => Mage::helper('cms')->__('Store view'),
                          'required' => true,
                          'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true) ));
      }
      else {
          $fieldset->addField('store_id', 'hidden', array (
                  'name' => 'stores[]',
                  'value' => Mage::app()->getStore(true)->getId() ));
          $fieldset->setStoreId(Mage::app()->getStore(true)->getId());
      } */
		
      $fieldset->addField('status', 'radios', array(
          'label'     => Mage::helper('slideshow')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slideshow')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('slideshow')->__('Disabled'),
              ),
          ),
      ));
	  
	  $fieldset->addField('sortorder', 'text', array(
          'label'     => Mage::helper('slideshow')->__('Sort Order'),
          'class'     => 'required-entry validate-digits',
          'required'  => true,
          'name'      => 'sortorder',
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('slideshow')->__('Content'),
          'title'     => Mage::helper('slideshow')->__('Content'),
          'style'     => 'width:666px; height:255px;',
          'wysiwyg'   => true,
		  'config'  => $config,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getSlideshowData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSlideshowData());
          Mage::getSingleton('adminhtml/session')->setSlideshowData(null);
      } elseif ( Mage::registry('slideshow_data') ) {
          $form->setValues(Mage::registry('slideshow_data')->getData());
      }
      return parent::_prepareForm();
  }
}