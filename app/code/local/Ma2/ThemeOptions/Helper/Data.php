<?php 
class Ma2_ThemeOptions_Helper_Data extends Mage_Core_Helper_Abstract
{
	//public $section = 'theme_options';
	
	public function getAllConfig($section)
	{
		return Mage::getStoreConfig($section);
	}
	
	/**
	 *
	 *get theme options
	 *
	 */
	public function getGroupConfig($section, $group)
	{
		return Mage::getStoreConfig($section.'/'.$group);
	}
	
	/**
	 *
	 *get theme options
	 *
	 */
	public function getFieldConfig($section, $group, $field)
	{
		return Mage::getStoreConfig($section.'/'.$group.'/'.$field);
	}
}