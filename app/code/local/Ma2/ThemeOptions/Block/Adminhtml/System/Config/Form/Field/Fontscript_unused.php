<?php
class OMG_ThemeOptions_Block_Adminhtml_System_Config_Form_Field_FontScript extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	/*
	* Overide field method to remove label, scope-label
	*/
	public function render(Varien_Data_Form_Element_Abstract $element)
    {
		// we remove the scope label for this element
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
		// we remove the label for this element
        $element->unsLabel()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }
	
    /**
     * Override field method to add js code
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Get the default HTML for this option
        //$html = parent::_getElementHtml($element);
        $html = '';
		/* 
		$html .= '
			<script type="text/javascript">
				WebFont.load({
					google: {
						families: [ "Abel" ]
				}});
				
				function fontPreview(value){
					var font = value.split(":");
					var fontfamily = font[1];
					if (font[0] == "w"){
						WebFont.load({
							google: {
								families: [ fontfamily ]
							}
						});
					}
					
					if (font[0] == "w"){
						$$("span.span-font-preview").setStyle({"font-family": "\'"+fontfamily+"\'"});
					}
					else{
						$$("span.span-font-preview").setStyle({"font-family": ""+fontfamily});
					}
					
					$$("span.span-font-preview").html("The quick brown fox jumps over the lazy dog");
					
					$$("div.font-preview").setStyle({"display": "block"});
					if(value == "none"){
						$$("div.font-preview").setStyle({"display": "none"});
					}
				}
				
				function closePreview(){
					$$("div.font-preview").setStyle({"display": "none"});
				}
			</script>
			';
         */
        return $html;
    }
}