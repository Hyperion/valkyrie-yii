<?php

require_once(dirname(__FILE__) . '/local.conf');

return CMap::mergeArray(
    require(dirname(__FILE__) . '/config.php'), 
    require(dirname(__FILE__) . '/modules.php')
);