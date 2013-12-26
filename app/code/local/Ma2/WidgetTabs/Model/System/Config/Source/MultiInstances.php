<?php
class Ma2_WidgetTabs_Model_System_Config_Source_MultiInstances
{     
    public function toOptionArray()
	{
        $wids = Mage::getModel('widget/widget_instance')
                ->getCollection()
                ->load();
        
        $output = array();   
        $output[] = array('value' => "", 'label' => '-- Select widget instance --');           
        foreach($wids as $wid)
        {
            $label = $wid->getTitle();
            $value = $wid->getId();
            $output[] = array('value' => $value, 'label' => "&nbsp;".$label);   
        }            
        return  $output;
	}    
}
?>