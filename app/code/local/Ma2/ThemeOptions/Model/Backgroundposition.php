<?php 
class Ma2_ThemeOptions_Model_Backgroundposition
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'left top', 'label'=>Mage::helper('ThemeOptions')->__('Left Top')),
            array('value'=>'center top', 'label'=>Mage::helper('ThemeOptions')->__('Center Top')),
            array('value'=>'right top', 'label'=>Mage::helper('ThemeOptions')->__('Right Top')),
			array('value'=>'left center', 'label'=>Mage::helper('ThemeOptions')->__('Left Center')),
            array('value'=>'center center', 'label'=>Mage::helper('ThemeOptions')->__('Center Center')),
            array('value'=>'right center', 'label'=>Mage::helper('ThemeOptions')->__('Right Center')),
            array('value'=>'left bottom', 'label'=>Mage::helper('ThemeOptions')->__('Left Bottom')),
            array('value'=>'center bottom', 'label'=>Mage::helper('ThemeOptions')->__('Center Bottom')),
            array('value'=>'right bottom', 'label'=>Mage::helper('ThemeOptions')->__('Right Bottom'))
        );
    }

}