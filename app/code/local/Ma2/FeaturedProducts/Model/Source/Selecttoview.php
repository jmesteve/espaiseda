<?php

class Ma2_FeaturedProducts_Model_Source_Selecttoview
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => 'home',	    'label' => 'home'),			
			array('value' => 'product',		'label' => 'product')                        
        );
    }
}
