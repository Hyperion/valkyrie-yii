<?php

class CharacterHonorStatic extends Base\Char
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'character_honor_static';
    }

    public function attributeLabels()
    {
        return array(
            'hk' => 'HK',
            'thisWeek_cp' => 'Week CP',
            'thisWeek_kills' => 'Week HK',
        );
    }
}
