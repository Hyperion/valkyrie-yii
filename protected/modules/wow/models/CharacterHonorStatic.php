<?php

/**
 * This is the model class for table "chars.character_honor_static".
 *
 * The followings are the available columns in table 'chars.character_honor_static':
 * @property string $guid
 * @property string $hk
 * @property string $dk
 * @property string $today_hk
 * @property string $today_dk
 * @property string $yesterday_kills
 * @property string $yesterday_cp
 * @property string $thisWeek_kills
 * @property string $thisWeek_cp
 * @property string $lastWeek_kills
 * @property string $lastWeek_cp
 */
class CharacterHonorStatic extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Database::getConnection(Database::$realm);
    }

    public function tableName()
    {
        return 'character_honor_static';
    }

    public function relations()
    {
        return array(
        );
    }
}