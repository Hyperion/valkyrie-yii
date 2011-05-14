<?php
Yii::import('zii.widgets.CPortlet');

class WLogin extends CPortlet
{
	public function init()
	{
		$this->title=Yii::t('user', 'Login');
		parent::init();
	}

	protected function renderContent()
	{
		if(Yii::app()->user->isGuest)
			$this->render('quicklogin', array('model' => new FLogin()));
		else
			$this->render('userNavigation');
	}
} 
?>
