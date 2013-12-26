<?php
class Ma2_ThemeOptions_Block_Adminhtml_System_Config_Form_Field_OColor extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Get the default HTML for this option
       $element->setClass('color');
	   $html = parent::_getElementHtml($element);
       return $html;
    }
}