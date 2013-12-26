<?php
class Ma2_Slideshow_Model_Slideshowselect
{
    public function toOptionArray()
    {
		$options = array();
		$collection = Mage::getModel('slideshow/slideshow')
			->getCollection()
			->addFieldToSelect('slideshow_id')
			->addFieldToSelect('title')
			->addFieldToFilter('status',1);
		
		foreach ($collection as $item){
			$options[] = array('value' => $item->getData('slideshow_id'), 'label' => $item->getData('title'));
		}
        return $options;
    }
}

