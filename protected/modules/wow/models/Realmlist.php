<?php

/**
 * This is the model class for table "logon.realmlist".
 *
 * The followings are the available columns in table 'logon.realmlist':
 * @property string $id
 * @property string $name
 * @property string $address
 * @property integer $port
 * @property integer $icon
 * @property integer $color
 * @property integer $timezone
 * @property integer $allowedSecurityLevel
 * @property double $population
 * @property string $realmbuilds
 */
class Realmlist extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDbConnection()
    {
        return Yii::app()->db_realmd;
    }

	public function tableName()
	{
		return 'realmlist';
	}

	public function rules()
    {

		return array(
			array('port, icon, color, timezone, allowedSecurityLevel', 'numerical', 'integerOnly'=>true),
			array('population', 'numerical'),
			array('name, address', 'length', 'max'=>32),
			array('realmbuilds', 'length', 'max'=>64),
		);
	}

}