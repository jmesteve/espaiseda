<?php
class Ma2_WidgetTabs_Block_Adminhtml_System_Config_Form_Field_Tabitem 
extends Mage_Adminhtml_Block_System_Config_Form_Field
implements Varien_Data_Form_Element_Renderer_Interface
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {        
        $html = '';  		
		//echo $editorField->getElementHtml();
        $wids = Mage::getModel('WidgetTabs/System_Config_Source_MultiInstances')
                ->toOptionArray();
        
		$html .= '<script>
					function removeTabItem(idtab,idinput,idcontent)
					{
						$(idtab).style.display = "none";
						$(idinput).value = "";
						$(idcontent).value = "";								
					}
				 </script>';
        $html .= '<form id="tab-items" name="tab-items">';
        $html .= '<div id="tab-items-wrapper">';        
        $savedTabs = json_decode($element->getValue(),true);
        if(is_array($savedTabs) && count($savedTabs) > 0)
        {
            foreach($savedTabs as $idx => $savedTab)
            {				
                $html .= '<div class="tab-item" id="tab-item-'.$idx.'">';
                    $html .=  '<div class="flt-lft w50percent"><label>'.$this->__('Tab title').'</label><input id="input-item-'.$idx.'" type="text" name="tabs['.$idx.'][title]" value="'.(isset($savedTab['title']) ? $this->escapeHtml($savedTab['title']) : '').'"/></div>';
                    $html .=  '<div class="flt-lft w50percent"><label>'.$this->__('Tab Content').'</label>';                      
                    $html .= '
					<textarea id="tabs_'.$idx.'_text" name="tabs['.$idx.'][text]" cols="20" rows="16">'.(isset($savedTab['text']) ? $this->escapeHtml($savedTab['text']) : '').'</textarea>
					<button style="" onclick="widgetTools.openDialog(\''.Mage::getBaseUrl().'admin/widget/index/widget_target_id/tabs_'.$idx.'_text\')" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button>																								
					<a href="javascript: void(0)" id="tab-item-remove" onclick="javascript:removeTabItem(\'tab-item-'.$idx.'\',\'input-item-'.$idx.'\',\'tabs_'.$idx.'_text\')">'.$this->__('Remove tab').'</a>';     
                $html .= '</div></div>';   
            }    
        }
        else{                  
           $html .= '<div class="tab-item" id="tab-item-0">';
                $html .=  '<div class="flt-lft w50percent"><label>'.$this->__('Tab title').'</label><input type="text" name="tabs[0][title]" id="input-item-0" value=""/></div>';
                $html .=  '<div class="flt-lft w50percent"><label>'.$this->__('Tab Content').'</label>';
                $html .= '
				<textarea id="tabs_0_text" name="tabs[0][text]" cols="20" rows="8"></textarea>
				<button style="" onclick="widgetTools.openDialog(\''.Mage::getBaseUrl().'admin/widget/index/widget_target_id/tabs_0_text\')" class="scalable add-widget plugin" type="button"><span><span><span>Insert Widget...</span></span></span></button>
				<a href="javascript: void(0)" id="tab-item-remove" onclick="javascript:removeTabItem(\'tab-item-0\',\'input-item-0\',\'tabs_tabs_0_text\')">'.$this->__('Remove tab').'</a>';     
            $html .= '</div></div>'; 
        }            
        $html .= '</div>';        
        $html .=  '<a id="tab-item-add" onclick="addTabItem()">'.$this->__('Add more tabs...').'</a>';
        $html .= '</form>';
        $html .=  '<a id="tab-items-save" onclick="saveTabItems()">'.$this->__('Save tabs').'</a>';
        $html .= '<input id="'.$element->getId().'" type="hidden" name="'.$element->getName().'" value="'.$this->escapeHtml($element->getValue()).'" />';
        $html .= '
            <script type="text/javascript">
                String.prototype.replaceAll = function(target, replacement) {
                  return this.split(target).join(replacement);
                };
			function addTabItem(){   
				var addId = $$(".tab-item").length; 
				var mystring = ""
						+ "<div class=\"tab-item\" id=\"tab-item-zero-'.$idx.'\"><div class=\"flt-lft w50percent\"><label>'.$this->__('Tab title').'</label><input id=\"input-item-zero\" type=\"text\" name=\"tabs[REPLACE][title]\" value=\"\"/></div>"
						+ "<div class=\"flt-lft w50percent\"><label>'.$this->__('Tab Content').'</label>"';
							
						$html .= '
						+ "<textarea id=\"tabs_REPLACE_text\" name=\"tabs[REPLACE][text]\" cols=\"20\" rows=\"8\"></textarea><button onclick=\"widgetTools.openDialog(\''.Mage::getBaseUrl().'admin/widget/index/widget_target_id/tabs_REPLACE_text\')\" class=\"scalable add-widget plugin\" type=\"button\"><span><span><span>Insert Widget...</span></span></span></button><a href=\"javascript: void(0)\" id=\"tab-item-remove\" onclick=\"javascript:removeTabItem(\'tab-item-" + addId + "\',\'input-item-zero\',\'tabs_REPLACE_text\')\">'.$this->__('Remove tab').'</a></div></div>";                  
				var newElement = document.createElement("div");
				newElement.className = "tab-item";
				newElement.id = "tab-item-" + addId;
				newElement.innerHTML = mystring.replaceAll("REPLACE", addId + "");
				$("tab-items-wrapper").appendChild(newElement); 				
			}
			function saveTabItems()
			{                                                            
			  new Ajax.Request("'.Mage::getBaseUrl().'WidgetTabs/adminhtml_widgettabs/save/", {
			  method:"post",
			  parameters:$("tab-items").serialize(),
			  onSuccess: function(transport) {
				var response = transport.responseText || "no response text";
				//alert("Success! \n\n" + response);
				$("'.$element->getId().'").setValue(response);
				confirmAfterSave();				
			  },
			  onFailure: function() { alert("'.$this->__('Saving failure!').'"); }
			  });  			  			  
			} 		
			function confirmAfterSave(){
				Dialog.confirm("'.$this->__('Tabs added. Please click Save now to save the widget now or click Save later to save the widget later!').'", {
					className:"magento",
					closable:true,
					resizable:false,
					draggable:true,
					modal: true,
					title:"'.$this->__('Tabs added successfully').'",
					width:268, 			
					okLabel: "'.$this->__('Save now').'", 
					cancelLabel: "'.$this->__('Save later').'",
					buttonClass: "scalable", 
					id: "myDialogId", 
					cancel:function(win) {}, 
					ok:function(win) {
						saveAndContinueEdit(); 
						return false;
					}
				});
			}						
            </script>
            ';
        return $html; 
    }	
}
?>