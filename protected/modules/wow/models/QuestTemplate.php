<?php

class QuestTemplate extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'quest_template';
	}
    
	public function getDbConnection()
    {
        return Yii::app()->db_world;
    }

}
