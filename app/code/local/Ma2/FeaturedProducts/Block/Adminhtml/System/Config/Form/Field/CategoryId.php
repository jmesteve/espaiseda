<?php
class Ma2_FeaturedProducts_Block_Adminhtml_System_Config_Form_Field_CategoryId extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        /**
         * $element->setStyle('width:282px; border:1px solid #EB5E00; color:#333;')
         *             ->setName($element->getName() . '[]');
        
         *         if ($element->getValue()) {
         *             $values = explode(',', $element->getValue());
         *         } else {
         *             $values = array();
         *         }
        
         *         $selectme = $element->setValue(isset($values[0]) ? $values[0] : null)->getElementHtml();
         */
         $nonEscapableNbspChar = html_entity_decode('&#160;&#160;&#160;&#160;', ENT_NOQUOTES, 'UTF-8');
        //$output = array();
           //$output[] = array('value' => '', 'label' => 'Select');
           $html  = '';
           
           $helper_data =  $this->helper('FeaturedProducts');
           $id_cate_para = $helper_data->getValueUseStoreConfig('getIDCategorySelected');
           $id_selected = $helper_data->getSupportStoreConfig($id_cate_para);
           
           $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('entity_id')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('level')
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->addAttributeToSort('path', 'asc')
            ->getItems();
           $html .= '<select name="'.$element->getName().'" id="'.$element->getId().'">';
           $title = '';
           
           if (count($categories) > 0){
            foreach ($categories as $category){
             if ($category->getName() != ''){                 
              $indent = str_repeat($nonEscapableNbspChar, $category->getLevel());             
              $title = $category->getName();
              $value=$category->getEntityId();
              if($value == $id_selected)
              {
                $html .= '<option value="'.$value.'" '.($category->getChildrenCount() > 0 ? 'class="parent"' : 'class="childrent"').'selected="selected" id="item-selected">'.$indent.$title.' (ID: '.$category->getId().')'.$nonEscapableNbspChar. $this->__('<span id="support-tip">selected</span>').'</option>';              
              //$output[] = array('value' => $value, 'label' => $indent.$title.' (ID: '.$category->getId().')');
              }
              else
              {
                $html .= '<option value="'.$value.'" '.($category->getChildrenCount() > 0 ? 'class="parent"' : 'class="childrent"').'>'.$indent.$title.' (ID: '.$category->getId().')'.'</option>';              
              //$output[] = array('value' => $value, 'label' => $indent.$title.' (ID: '.$category->getId().')');
              }              
             }
            }
           } 
           $html .= '</select>';
           return $html;
        //$to = $element->setValue(isset($values[1]) ? $values[1] : null)->getElementHtml();
        //return $selectme;
    }
 
}