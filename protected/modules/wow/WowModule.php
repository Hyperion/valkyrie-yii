<?php

class WowModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'wow.models.*',
			'wow.components.*',
		));
                
        Yii::app()->db_realmd->active = true;
        Yii::app()->db_chars->active = true;
        Yii::app()->db_world->active = true;

	}
}
