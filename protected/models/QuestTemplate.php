<?php

class QuestTemplate extends Base\World
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'quest_template';
	}
}
