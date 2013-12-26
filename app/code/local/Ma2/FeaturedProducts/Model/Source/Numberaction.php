<?php

class Ma2_FeaturedProducts_Model_Source_Numberaction
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => '9',	    'label' => '9 products'),			
			array('value' => '15',		'label' => '15 products'),			
			array('value' => '30',		'label' => '30 products')			   
        );
    }
}
