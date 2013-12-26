<?php

class Ma2_FeaturedProducts_Model_Source_Categoryid
{
    public function toOptionArray()
    {
        $nonEscapableNbspChar = html_entity_decode('&#160;&#160;&#160;&#160;&#160;&#160;', ENT_NOQUOTES, 'UTF-8');
        $output = array();
           $output[] = array('value' => '', 'label' => 'Select');
           
           $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('level')
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->addAttributeToSort('path', 'asc')
            ->getItems();
           
           $title = '';
           if (count($categories) > 0){
            foreach ($categories as $category){
             if ($category->getName() != ''){                
              $indent = str_repeat($nonEscapableNbspChar, $category->getLevel());             
              $title = $category->getName();
              $value=$category->getEntityId();              
              $output[] = array('value' => $value, 'label' => $indent.$title.' (ID: '.$category->getId().')');
             }
            }
           } 
          return $output;
    }
}
