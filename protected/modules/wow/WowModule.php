<?php

class WowModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'wow.models.*',
			'wow.components.*',
		));
                
        Yii::app()->db_world->active = true;

	}
}
