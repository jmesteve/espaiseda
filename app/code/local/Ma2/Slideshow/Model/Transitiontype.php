<?php

class Ma2_Slideshow_Model_Transitiontype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'fade',	'label' => Mage::helper('slideshow')->__('Fade')),
			array('value' => 'slide',	'label' => Mage::helper('slideshow')->__('Slide'))
        );
    }
}