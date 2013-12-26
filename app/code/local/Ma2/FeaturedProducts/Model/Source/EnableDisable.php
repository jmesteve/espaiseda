<?php
class Ma2_FeaturedProducts_Model_Source_EnableDisable
{
   public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => 'enable',	    'label' => 'Enable'),			
			array('value' => 'disable',		    'label' => 'Disable')                       
        );
    }
}
