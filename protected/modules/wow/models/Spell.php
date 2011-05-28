<?php

class Spell extends CActiveRecord
{
	public $info = false;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'wow_spells';
	}

	public function formatInfo()
	{
		$s1 = $this->effect1BasePoints + 1;
		eval('$this->info = "'.$this->tooltip_loc0.'";');
	}
}
