<?php
class Ma2_FeaturedProducts_Block_Adminhtml_System_Config_Form_Field_Status extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {        
        $element->setStyle('width:22px; border:1px solid #CCC; color:#333;')
            ->setName($element->getName() . '[]');

        if ($element->getValue()) {
            $values = explode(',', $element->getValue());
        } else {
            $values = array();
        }

        $selectme = $element->setValue(isset($values[0]) ? $values[0] : null)->getElementHtml();
        //$to = $element->setValue(isset($values[1]) ? $values[1] : null)->getElementHtml();
        return $selectme;                
    }
 
}