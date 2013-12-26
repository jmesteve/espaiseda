<?php
class Ma2_WidgetProductList_Block_Adminhtml_System_Config_Form_Field_SortBy 
extends Mage_Adminhtml_Block_System_Config_Form_Field
{      
    
    public function setInitStoreValueModule()
    {
        $InitInputValueModule =  array( "asc"=>"Price ASC", 
                                        "desc"=>"Price Desc",
                                        "any"=>"Any"
                                    );
                                        
                                    // declare function and value.                
        return $InitInputValueModule;
    }  
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {           
        //foreach($getValueStore as $title=>$value)
        //{
            //echo $getValueStore[$title];
            //echo $value;
        //}
        
        $nonEscapableNbspChar = html_entity_decode('&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;', ENT_NOQUOTES, 'UTF-8');
        $html  = '';
        
        //$helper = $this->helper('WidgetProductList');   
//        $template_selected = $helper->getTypeList();
                            
        $getValueStore = $this->setInitStoreValueModule();
        
        $html .= '<select name="'.$element->getName().'" class="small-select" id="'.$element->getId().'">';
        $title = '';
        
        //var_dump($template_selected);     
        //var_dump($getValueStore);
        
        foreach ($getValueStore as $value=>$title)
        {
            //$getValueStore[$value],$title
            //$value,$title
            $html .= '<option value="'.$value.'" class="childrent">'.$title.'</option>';  
        }
        $html .= '</select>';   
        return $html;       
    }
    
}
