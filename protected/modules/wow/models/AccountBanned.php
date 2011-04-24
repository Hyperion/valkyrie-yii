<?php

class AccountBanned extends CActiveRecord
{
	public function primaryKey()
	{
		return 'id';
	}
	
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
		return 'account_banned';
	}
	
	public function relations()
	{
		return array(
			'account' => array(self::BELONGS_TO, 'Account', 'id', 'select' => 'username'),
		);
	}
	
	public function rules()
	{
		return array(
			array('bannedby, banreason', 'required'),
			array('id, active', 'numerical', 'integerOnly'=>true),
			array('bandate, unbandate', 'length', 'max'=>40),
			array('bannedby', 'length', 'max'=>50),
			array('banreason', 'length', 'max'=>255),
			array('id, bandate, unbandate, bannedby, banreason, active', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bandate' => 'Ban Date',
			'unbandate' => 'Unban Date',
			'bannedby' => 'Banned by',
			'banreason' => 'Ban Reason',
			'active' => 'Active',
		);
	}

	public function search()
    {

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('bandate',$this->bandate,true);
		$criteria->compare('unbandate',$this->unbandate,true);
		$criteria->compare('bannedby',$this->bannedby,true);
		$criteria->compare('banreason',$this->banreason,true);
		$criteria->compare('active',$this->active);
		$criteria->order = 'bandate DESC';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}