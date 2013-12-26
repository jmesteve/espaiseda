<?php
class Ma2_ThemeOptions_Block_Adminhtml_System_Config_Form_Field_Heading extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
		//var_dump($element->getData());
	   $html = '<p class="'.$element->getClass().'">'.$element->getLabel().'</p>';
       return $html;
    }
}