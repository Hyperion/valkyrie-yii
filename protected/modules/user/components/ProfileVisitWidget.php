<?php
Yii::import('application.modules.user.UserModule');
Yii::import('zii.widgets.CPortlet');

class ProfileVisitWidget extends CPortlet
{
	public $decorationCssClass = 'portlet-decoration profilevisits';

	public function init() {
		if(!$this->module->enableProfileVisitLogging)
			return false;

		$this->title=Yii::t('UserModule.user', 'Profile visits');
		if(Yii::app()->user->isGuest)
			return false;

		parent::init();
	}

	protected function renderContent()
	{
		if(!$this->module->enableProfileVisitLogging)
			return false;

		parent::renderContent();
		if(Yii::app()->user->isGuest)
			return false;

			$this->render('profile_visits', array(
						'visits' => Yii::app()->user->data()->visits));
	}
} 
?>
