<?php
class Ma2_WidgetProductList_Helper_Data extends Mage_Core_Helper_Abstract 
{

 public function randomkeys($length) {
  $pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  $key = '';
  for($i = 0; $i < $length; $i++) {
   $key .= $pattern{rand(0,strlen($pattern)-1)};
  }
  return $key;
 }

}
