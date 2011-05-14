<?php

class Category extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'categories';
	}

	public function rules()
	{
		return array(
			array('id, title', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
		);
	}

	public function items()
	{
		$items = array();
		foreach(self::model()->findAll() as $item)
			$items[$item['id']] = $item['title'];
		return $items;
	}
}
