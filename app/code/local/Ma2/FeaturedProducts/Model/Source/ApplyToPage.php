<?php

class Ma2_FeaturedProducts_Model_Source_ApplyToPage
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => 'featured',	    'label' => 'List Featured Products'),			
			array('value' => 'list',		    'label' => 'List Any Products'),			
			array('value' => 'listproduct',		'label' => 'Catalog Products List')                       
        );
    }
}
