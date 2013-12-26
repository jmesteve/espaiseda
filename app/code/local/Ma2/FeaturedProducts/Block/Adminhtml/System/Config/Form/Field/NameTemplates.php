<?php
class Ma2_FeaturedProducts_Block_Adminhtml_System_Config_Form_Field_NameTemplates extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    public function setInitStoreValueModule()
    {
        $InitInputValueModule =  array( "template1"=>"Template1", 
                                        "template2"=>"Template2", 
                                        "template3"=>"Template3",
                                        "template4"=>"Template4", 
                                        "template5"=>"Template5", 
                                        "template6"=>"Template6"                                            
                                        // declare function and value.
                                        );     
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
        $helper_data =  $this->helper('FeaturedProducts');
        $name_temp = $helper_data->getValueUseStoreConfig('getTemplateSelected');
        $template_selected = $helper_data->getSupportStoreConfig($name_temp);
                            
        $getValueStore = $this->setInitStoreValueModule();
        $html .= '<select name="'.$element->getName().'" id="'.$element->getId().'">';
        $title = '';
        foreach ($getValueStore as $value=>$title)
        {
            //$getValueStore[$value],$title
            //$value,$title
            if($value == $template_selected)
            {            
                $html .= '<option value="'.$value.'" selected="selected" class="childrent" id="item-selected">'.$title.$nonEscapableNbspChar.$this->__('<span id="support-tip">selected</span>').'</option>';                
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