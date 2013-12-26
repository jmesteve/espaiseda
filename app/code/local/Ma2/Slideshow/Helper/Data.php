<?php

class Ma2_Slideshow_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function recursiveReplace($search, $replace, $subject)
	{
	   if (!is_array($subject))
		 return $subject;

	   foreach ($subject as $key => $value)
		 if (is_string($value))
		   $subject[$key] = str_replace($search, $replace, $value);
		 elseif (is_array($value))
		   $subject[$key] = self::recursiveReplace($search, $replace, $value);

	   return $subject;
	}
}