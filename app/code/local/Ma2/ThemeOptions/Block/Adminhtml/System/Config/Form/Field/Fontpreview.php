<?php
class Ma2_ThemeOptions_Block_Adminhtml_System_Config_Form_Field_FontPreview extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return String
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        // Get the default HTML for this option
        $html = parent::_getElementHtml($element);
		//Zend_Debug::dump(Mage::app()->getStore()->isCurrentlySecure());
		$isSecure = Mage::app()->getStore()->isCurrentlySecure();
		$selectId = $element->getHtmlId();
		$previewId = $selectId.'_preview';
		
        $html .= '<div class="font-preview rounded" id="'.$previewId.'"><span class="span-font-preview">The quick brown fox jumps over the lazy dog</span></div>';
		
		// css for font preview
		$css = '
				div.font-preview{
					background-color: #f8f8f8;
					border: 1px solid #CCC;
					width: 260px;
					padding: 8px;
					overflow: hidden;
					-webkit-box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2); /* Safari, Chrome */
					-moz-box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2); /* Firefox */
					box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.2);
				}
				span.span-font-preview{
					float: left;
					width: 100%;
					text-align: center;
					font-size: 18px;
					line-height: normal;
				}
			';
		$savedFont = explode(':', $element->getValue());
		if (isset($savedFont[0]) && $savedFont[1] && $savedFont[0] == "w"){
			$css .= '
				#'.$previewId.' { font-family: "'.$savedFont[1].'";}
			';
		}
		else{
			$css .= '
				#'.$previewId.' { font-family: '.str_replace(array('s:', 'w:'), '', $element->getValue()).';}
			';
		}
		
		$html .= '
			<style type="text/css">
				'.$css.'
			</style>
			';
		
		// script for font preview
        $html .= '
			<script type="text/javascript">
				var ma2FontPreviewModel = Class.create();

				ma2FontPreviewModel.prototype = {
					initialize : function()
					{
						this.fontSelect = $("'.$selectId.'");
						this.fontPreviewElement = $("'.$previewId.'");
						this.loadedFonts = "";

						this.loadPreviewFont();
						this.bindFontChange();
					},
					bindFontChange : function()
					{
						Event.observe(this.fontSelect, "change", this.loadPreviewFont.bind(this));
						Event.observe(this.fontSelect, "keyup", this.loadPreviewFont.bind(this));
						Event.observe(this.fontSelect, "keydown", this.loadPreviewFont.bind(this));
					},
					loadPreviewFont : function()
					{
						if ( this.loadedFonts.indexOf( this.fontSelect.value ) > -1 ) {
							this.updatePreview();
							return;
						}
						var font = this.fontSelect.value.split(":");
						var fontfamily = font[1];
						if (font[0] == "w"){
							/* 
							WebFont.load({
								google: {
									families: [ fontfamily ]
								}
							});
							*/
							// use synchronous method
							var fcs = document.createElement("link");
							fcs.type = "text/css";
							fcs.rel = "stylesheet";
							fcs.href = "'.($isSecure ? 'https:' : 'http:').'//fonts.googleapis.com/css?family=" + fontfamily;
							document.getElementsByTagName("head")[0].appendChild(fcs);

							this.updatePreview();
							this.loadedFonts += this.fontSelect.value + ",";
						}
					},
					updatePreview : function()
					{
						var font = this.fontSelect.value.split(":");
						var fontfamily = font[1];
						if (font[0] == "w"){
							$(this.fontPreviewElement).setStyle({ fontFamily: "\'"+fontfamily+"\'" });
						}
						else{
							$(this.fontPreviewElement).setStyle({ fontFamily: fontfamily });
						}
					}
				}
				
				backendFontPreview = new ma2FontPreviewModel();
				
			</script>
			';
		
        return $html;
    }
}