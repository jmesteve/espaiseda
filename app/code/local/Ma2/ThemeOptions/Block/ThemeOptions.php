<?php
class Ma2_ThemeOptions_Block_ThemeOptions extends Mage_Core_Block_Template
{

	protected function _toHtml()
	{
		$this->assign('themeOptions', Mage::getStoreConfig('theme_options'));
		return parent::_toHtml();
	}
	
}
?>