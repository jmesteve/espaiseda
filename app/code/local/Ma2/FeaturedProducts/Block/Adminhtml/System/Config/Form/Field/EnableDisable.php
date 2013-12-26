<?php
class Ma2_FeaturedProducts_Block_Adminhtml_System_Config_Form_Field_EnableDisable extends Mage_Adminhtml_Block_System_Config_Form_Field
{      
    public function setInitStoreValueModule()
    {
        $InitInputValueModule =  array( "enable"=>"Enable", 
                                        "disable"=>"Disable"
                                    ); // declare function and value.                
        return $InitInputValueModule;
    }  
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $helper_data =  $this->helper('FeaturedProducts');
        
        $ED_cate_para = $helper_data->getValueUseStoreConfig('getEnableDisable');
        $ED_selected = $helper_data->getSupportStoreConfig($ED_cate_para);
        
        
        //foreach($getValueStore as $title=>$value)
        //{
            //echo $getValueStore[$title];
            //echo $value;
        //}
        
        $nonEscapableNbspChar = html_entity_decode('&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;', ENT_NOQUOTES, 'UTF-8');
        $html  = '';
        
        //$helper = $this->helper('widgetcategory');   
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
            if($value == $id_selected)
            {
                $html .= '<option selected="selected" id="item-selected" value="'.$value.'" class="childrent">'.$title.'</option>';
            }
            else
            {
               $html .= '<option value="'.$value.'" class="childrent">'.$title.'</option>'; 
            }  
        } 
        $html .= '</select>';   
        return $html;       
    }
    
}
