<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
		'components' => array( 
			'errorHandler'=>array(
        	    'errorAction'=>'site/error',
        	),
		),
    )
);
