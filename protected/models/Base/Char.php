<?php

namespace Base;

class Char extends \BActiveRecord
{
    private static $_db_chars = null;

    public function getDbConnection()
    {
        return self::getCharsDbConnection();
    }

    protected static function getCharsDbConnection()
    {
        if (self::$_db_chars !== null)
            return self::$_db_chars;
        else
        {
            self::$_db_chars = \Yii::app()->db_chars;
            if (self::$_db_chars instanceof \CDbConnection)
            {
                self::$_db_chars->setActive(true);
                return self::$_db_chars;
            }
            else
                throw new \CDbException(\Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}