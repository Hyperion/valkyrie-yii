<?php

namespace Base;

class World extends \BActiveRecord
{
    private static $_db_world = null;

    public function getDbConnection()
    {
        return self::getWorldDbConnection();
    }

    protected static function getWorldDbConnection()
    {
        if (self::$_db_world !== null)
            return self::$_db_world;
        else
        {
            self::$_db_world = \Yii::app()->db_world;
            if (self::$_db_world instanceof \CDbConnection)
            {
                self::$_db_world->setActive(true);
                return self::$_db_world;
            }
            else
                throw new \CDbException(\Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}
