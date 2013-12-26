<?php

class Ma2_FeaturedProducts_Model_Source_Status
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => '1',	'label' => 'active'),			
			array('value' => '0',	'label' => 'unactive')
        );
    }
}
