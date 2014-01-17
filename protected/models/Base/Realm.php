<?php

namespace Base;

class Realm extends \BActiveRecord
{
    private static $_db_realmd = null;

    public function getDbConnection()
    {
        return self::getRealmdDbConnection();
    }

    protected static function getRealmdDbConnection()
    {
        if (self::$_db_realmd !== null)
            return self::$_db_realmd;
        else
        {
            self::$_db_realmd = \Yii::app()->db_realmd;
            if (self::$_db_realmd instanceof \CDbConnection)
            {
                self::$_db_realmd->setActive(true);
                return self::$_db_realmd;
            }
            else
                throw new \CDbException(\Yii::t('yii', 'Active Record requires a "db" CDbConnection application component.'));
        }
    }
}
