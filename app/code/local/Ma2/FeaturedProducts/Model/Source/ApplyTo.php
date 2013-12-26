<?php

class Ma2_FeaturedProducts_Model_Source_ApplyTo
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => '1',	'label' => 'apply'),			
			array('value' => '0',	'label' => 'unapply')
        );
    }
}
