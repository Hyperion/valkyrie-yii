<?php

class Faction
{
	public static function itemAlias($type, $code=NULL)
	{
		$_items = array(
			'rank' => array(
                		'0' => 'Hated',
                		'1' => 'Hostile',
               			'2' => 'Unfriendly',
                		'3' => 'Neutral',
      	         		'4' => 'Friendly',
    		            	'5' => 'Honoured',
   		             	'6' => 'Revered',
   		             	'7' => 'Exalted',
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
}