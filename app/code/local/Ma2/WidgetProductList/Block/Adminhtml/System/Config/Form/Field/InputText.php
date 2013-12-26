<?php
class Ma2_WidgetProductList_Block_Adminhtml_System_Config_Form_Field_InputText extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setStyle('background-color:#EBEBEB; width:89px !important; height:26px;')->setName($element->getName() . '[]');                    
        if ($element->getValue()) {
            $values = $element->getValue();
        } else {
            $values = array();
        }
        $selectme = $element->setValue(isset($values[0]) ? $values[0] : null)->getElementHtml();
        return $selectme; 
    }        
}