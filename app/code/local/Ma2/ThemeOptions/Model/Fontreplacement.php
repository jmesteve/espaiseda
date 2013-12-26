<?php 
class Ma2_ThemeOptions_Model_Fontreplacement
{
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('ThemeOptions')->__('Disable')),
            array('value'=>2, 'label'=>Mage::helper('ThemeOptions')->__('Enable'))        
        );
    }

}