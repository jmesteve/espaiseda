<?php 
class Ma2_ThemeOptions_Model_Backgroundrepeat
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'no-repeat', 'label'=>Mage::helper('ThemeOptions')->__('No Repeat')),
            array('value'=>'repeat-x', 'label'=>Mage::helper('ThemeOptions')->__('Repeat X')),
            array('value'=>'repeat-y', 'label'=>Mage::helper('ThemeOptions')->__('Repeat Y')),
			array('value'=>'repeat', 'label'=>Mage::helper('ThemeOptions')->__('Repeat All'))
        );
    }

}