<?php
class Ma2_FeaturedProducts_Block_Adminhtml_FeaturedProducts_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
   protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('FeaturedProducts_form', array('legend'=>Mage::helper('FeaturedProducts')->__('Item information')));
       
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('FeaturedProducts')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
 
        $fieldset->addField('numberaction', 'select', array(
            'label'     => Mage::helper('FeaturedProducts')->__('Display Number'),
            'name'      => 'numberaction',
            'values'    => array(
                array(
                    'value'     => 62,
                    'label'     => Mage::helper('FeaturedProducts')->__('62'),
                ),
                array(
                    'value'     => 54,
                    'label'     => Mage::helper('FeaturedProducts')->__('54'),
                ),
                array(
                    'value'     => 42,
                    'label'     => Mage::helper('FeaturedProducts')->__('42'),
                ),
                array(
                    'value'     => 36,
                    'label'     => Mage::helper('FeaturedProducts')->__('36'),
                ),
                array(
                    'value'     => 33,
                    'label'     => Mage::helper('FeaturedProducts')->__('33'),
                ),
                array(
                    'value'     => 30,
                    'label'     => Mage::helper('FeaturedProducts')->__('30'),
                ),
                array(
                    'value'     => 27,
                    'label'     => Mage::helper('FeaturedProducts')->__('27'),
                ),
                array(
                    'value'     => 21,
                    'label'     => Mage::helper('FeaturedProducts')->__('21'),
                ),
                array(
                    'value'     => 18,
                    'label'     => Mage::helper('FeaturedProducts')->__('18'),
                ),
                array(
                    'value'     => 15,
                    'label'     => Mage::helper('FeaturedProducts')->__('15'),
                ),
                array(
                    'value'     => 12,
                    'label'     => Mage::helper('FeaturedProducts')->__('12'),
                ),
                array(
                    'value'     => 9,
                    'label'     => Mage::helper('FeaturedProducts')->__('9'),
                ),
                array(
                    'value'    => 6,
                    'label'     => Mage::helper('FeaturedProducts')->__('6'),
                ),
 
                array(
                    'value'    => 3,
                    'label'     => Mage::helper('FeaturedProducts')->__('3'),
                ),
            ),
        ));                
        
 
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('FeaturedProducts')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('FeaturedProducts')->__('Active'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('FeaturedProducts')->__('Inactive'),
                ),
            ),
        ));
               
       
        if ( Mage::getSingleton('adminhtml/session')->getFeaturedProductsData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->setFeaturedProductsData());
            Mage::getSingleton('adminhtml/session')->setFeaturedProductsData(null);
        } elseif ( Mage::registry('FeaturedProducts_data') ) {
            $form->setValues(Mage::registry('FeaturedProducts_data')->getData());
        }
        return parent::_prepareForm();
    }
}