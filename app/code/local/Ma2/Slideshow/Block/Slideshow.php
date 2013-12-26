<?php
class Ma2_Slideshow_Block_Slideshow extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface
{
	protected function _toHtml()     
    {
		$slideshow_ids = $this->getData('slideshow_ids');
		
		$collection = Mage::getModel('slideshow/slideshow')
			->getCollection()
			->addFieldToFilter('slideshow_id', array('in' => explode(',', $slideshow_ids)));
		
		$this->assign('items', $collection);
		$this->assign('options', json_decode(json_encode(Mage::getStoreConfig('slideshow_options/general'))));
		
		
		return parent::_toHtml();
	}
}