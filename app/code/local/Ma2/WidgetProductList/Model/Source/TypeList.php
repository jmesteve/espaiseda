<?php

class Ma2_WidgetProductList_Model_Source_TypeList
{
    public function toOptionArray()
    {
        return array(
			//Ease in-out
			array('value' => 'grid',	'label' => 'Grid'),			
			array('value' => 'list',	'label' => 'List')
        );
    }
}
