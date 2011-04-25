<?php

class Realmlist extends CActiveRecord
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDbConnection()
    {
        $db = new WowDatabase();
        return $db->getDb('realmlist');
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
			array('name', 'safe', 'on'=>'search'),
		);
	}
	
	public function search()
 {
        $criteria=new CDbCriteria;

        $criteria->compare('name',$this->name,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

}