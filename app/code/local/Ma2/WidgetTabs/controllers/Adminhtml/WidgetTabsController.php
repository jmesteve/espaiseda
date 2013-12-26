<?php
class Ma2_WidgetTabs_Adminhtml_WidgetTabsController 
extends Mage_Adminhtml_Controller_Action
{
    public function saveAction()
    {
       $tabs = $this->getRequest()->getPost('tabs');		
       $newTabs = array();       
       foreach($tabs as $tab)
       {
            if(trim($tab["title"]) != "" && trim($tab["text"]) != "")
            {
                $newTabs[] = $tab;   
            } 
       }
       echo json_encode($newTabs);
    }    
}
?>