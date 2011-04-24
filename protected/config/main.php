<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/config.php'), 
    require(dirname(__FILE__).'/modules.php')
);