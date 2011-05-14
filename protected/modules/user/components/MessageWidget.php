<?php
Yii::import('application.modules.user.UserModule');
Yii::import('zii.widgets.CPortlet');

class MessageWidget extends CPortlet
{
	public $decorationCssClass = 'portlet-decoration messages';

	public function init()
	{
		if($this->module->messageSystem === false)
			return false;

		$this->title=Yii::t('UserModule.user', 'New messages');
		parent::init();
	}

	protected function renderContent()
	{
		if($this->module->messageSystem === false)
			return false;

		if(!Yii::app()->user->isGuest) {
			$messages = Message::model()->unread()->limit(10)->findAll();

			$this->render('messages', array(
						'messages' => $messages
						));
		}
	}
} 
?>
