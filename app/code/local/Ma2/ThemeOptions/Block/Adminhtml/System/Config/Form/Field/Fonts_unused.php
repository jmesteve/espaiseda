<?php
class OMG_ThemeOptions_Block_Adminhtml_System_Config_Form_Field_Fonts extends Mage_Adminhtml_Block_System_Config_Form_Field
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
		$sans_safe = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"Tahoma, Geneva, sans-serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);
		$serif_safe = array(
			"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
			"Bookman, serif",
			"Garamond, serif",
			"Georgia, serif",
			"'MS Serif', 'New York', serif",
			"'Times New Roman', Times, serif"
		);
		$monospace_safe = array(
			"Courier, monospace",
			"'Courier New', Courier, monospace",
			"'Lucida Console', Monaco, monospace"
		);
		
		$options = array();
		
		$font_default_Opt = array();
		$font_default_Opt[] = array(
			'label' => htmlentities("'Helvetica Neue', Helvetica, Arial, sans-serif"),
			'value' => htmlentities("s:'Helvetica Neue',Helvetica,Arial,sans-serif")
		);
		
		$sans_safe_Opt = array();
		foreach($sans_safe as $sansfont){
			//$selected = ($this->value == 's:'.htmlentities($sansfont)) ? ' selected="selected"' : '';
			$sans_safe_Opt[] = array(
				'label' => htmlentities($sansfont),
				'value' => 's:'.htmlentities($sansfont)
			);
		}
		$serif_safe_Opt = array();
		foreach($serif_safe as $seriffont){
			//$selected = ($this->value == 's:'.htmlentities($seriffont)) ? ' selected="selected"' : '';
			$serif_safe_Opt[] = array(
				'label' => htmlentities($seriffont),
				'value' => 's:'.htmlentities($seriffont)
			);
		}
		$monospace_safe_Opt = array();
		foreach($monospace_safe as $monospace_font){
			//$selected = ($this->value == 's:'.htmlentities($monospace_font)) ? ' selected="selected"' : '';
			$monospace_safe_Opt[] = array(
				'label' => htmlentities($monospace_font),
				'value' => 's:'.htmlentities($monospace_font)
			);
		}
		
		
		$options[] = array(
			'label' => 'Default',
			'value' => $font_default_Opt
		);
		$options[] = array(
			'label' => 'Safe Fonts: Sans-Serif',
			'value' => $sans_safe_Opt
		);
		$options[] = array(
			'label' => 'Safe Fonts: Serif',
			'value' => $serif_safe_Opt
		);
		$options[] = array(
			'label' => 'Safe Fonts: Monospace',
			'value' => $monospace_safe_Opt
		);
		
		$element->setValues($options);
		//$element->setClass('');
		
        $html = parent::_getElementHtml($element);
		return $html;
		
        $sans_safe = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"Tahoma, Geneva, sans-serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);
		$serif_safe = array(
			"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
			"Bookman, serif",
			"Garamond, serif",
			"Georgia, serif",
			"'MS Serif', 'New York', serif",
			"'Times New Roman', Times, serif"
		);
		$monospace_safe = array(
			"Courier, monospace",
			"'Courier New', Courier, monospace",
			"'Lucida Console', Monaco, monospace"
		);
		
		$html = array();
		$optionsHtml = array();
		
		$optionsHtml[] = '<optgroup label="Default">';
		$optionsHtml[] = '<option value="s:\'Helvetica Neue\',Helvetica,Arial,sans-serif">\'Helvetica Neue\', Arial, Helvetica, sans-serif</option>';
		$optionsHtml[] = '</optgroup>';
		
		$optionsHtml[] = '<optgroup label="Safe Fonts: Sans-Serif">';
		foreach($sans_safe as $sansfont){
			$selected = ($this->value == 's:'.htmlentities($sansfont)) ? ' selected="selected"' : '';
			$optionsHtml[] = '<option value="s:'.htmlentities($sansfont).'" '.$selected.'>'.htmlentities($sansfont).'</option>';
		}
		
		$optionsHtml[] = '<optgroup label="Safe Fonts: Serif">';
		foreach($serif_safe as $seriffont){
			$selected = ($this->value == 's:'.htmlentities($seriffont)) ? ' selected="selected"' : '';
			$optionsHtml[] = '<option value="s:'.htmlentities($seriffont).'" '.$selected.'>'.htmlentities($seriffont).'</option>';
		}
		
		$optionsHtml[] = '<optgroup label="Safe Fonts: Monospace">';
		foreach($monospace_safe as $monospace_font){
			$selected = ($this->value == 's:'.htmlentities($monospace_font)) ? ' selected="selected"' : '';
			$optionsHtml[] = '<option value="s:'.htmlentities($monospace_font).'" '.$selected.'>'.htmlentities($monospace_font).'</option>';
		}
		
		$optionsHtml[] = '</optgroup>';
		/* 
		$optionsHtml[] = '<optgroup label="Google WebFonts">';
		
		if (!isset($_SESSION["gfontlist"]) || empty($_SESSION["gfontlist"])){
			$webfontJFile = JPATH_LIBRARIES . DS . 'omg' . DS . '3rd'. DS . 'webfonts' . DS .'gwebfonts.json';
			$fontsJson = $this->file_include_contents($webfontJFile);
			$_SESSION["gfontlist"] = $fontsJson;
		}
		$webfonts = $_SESSION["gfontlist"] ? $_SESSION["gfontlist"] : $fontsJson;
		
		
		$webfonts = @json_decode($webfonts, true);
		$wfontArray = $webfonts["items"];
		if (is_array($wfontArray) && count($wfontArray) > 0){
			foreach($wfontArray as $idx => $wfont){
				$subsets = implode(',', (array)$wfont["subsets"]);
				$selected = ($this->value == 'w:'.$wfont["family"]) ? ' selected="selected"' : '';
				$optionsHtml[] = '<option value="w:'.$wfont["family"].'" '.$selected.'>'.$wfont["family"] . ' (' .$subsets . ')'.'</option>';
			}
		}
		$optionsHtml[] = '</optgroup>';
		 */
		/* 
		$html[] = '<div class="select-wrapper '.($this->element['class'] ? trim($this->element['class']->__toString()) : '').'">';
		$html[] = '<span class="savedValue rounded-6">'.str_replace(array('w:','s:'), '', $this->value).'</span>';
		$html[] = '		<select id="' . $this->id . '" data-value="' . $this->value . '" name="' . $this->name . '" class="selectbox-real" onchange="fontPreview(this.value);">';
		$html[] = implode("\n", $optionsHtml);
		$html[] = '		</select>';
		$html[] = '</div>';
		
		return implode('', $html); */
    }
}