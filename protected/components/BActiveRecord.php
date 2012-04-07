<?php

class BActiveRecord extends CActiveRecord
{

    public static function itemAlias($type, $code = NULL)
    {
        if(isset($code))
            return isset(static::$_items[$type][$code]) ? static::$_items[$type][$code] : false;
        else
            return isset(static::$_items[$type]) ? static::$_items[$type] : false;
    }

}
