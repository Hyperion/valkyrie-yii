<?php

class MessagesController extends Controller {
	public function accessRules() {
		return array(
			array('allow',
				'actions' => array('view', 'compose', 'index',
					'delete', 'sent', 'success', 'users', 'markRead'),
				'users'=>array('@'),
				),
			array('allow',
				'actions' => array('sendDigest'),
				'users'=>array('admin'),
				),
			array('deny',
				'users'=>array('*')
			)
		);
	}	

	public function actionUsers() {
		if(Yii::app()->request->isAjaxRequest)
			echo json_encode(CHtml::listData(User::model()->findAll(), 'id', 'username'));
	}

	public function actionMarkRead() {
		$model = $this->loadModel('Message');
		$model->message_read = true;
		$model->save();
		Core::setFlash(Yii::t('UserModule.user', 'Message "{message}" was marked as read', array(
					'{message}' => $model->title
					)));
		$this->redirect(array('//user/profile/view', 'id' => $model->from_user_id));
	}

	public function actionView() {
		$model = $this->loadModel('Message');

		// If the model is a draft and i am not the author of the message, throw 403
		if($model->draft && $model->from_user_id != Yii::app()->user->id) 
			throw new CHttpException(403);

		// Only allow to view the message if i am either the recipient or the author
		if($model->to_user_id == Yii::app()->user->id
				|| $model->from_user_id == Yii::app()->user->id) {
		// If the recipient reads the message the first time, set the
		// message_read boolean 
			if(!$model->message_read 
					&& $model->to_user_id == Yii::app()->user->id) {
				$model->message_read = true;
				$model->save(false, array('message_read'));
			}
			$this->render('view',array('model'=>$model));
		} else
			throw new CHttpException(403);

	}

	public function actionCompose($to_user_id = null) {
		if(!Yii::app()->user->isAdmin() 
				&& !Yii::app()->user->data()->can('message_write')) {
			if($this->module->enableMembership)
				$this->render($this->module->membershipExpiredView);
			else
				throw new CHttpException(403);
			Yii::app()->end();
		}

		$this->performAjaxValidation('Message', 'yum-messages-form');
		$model = new Message;

		if(isset($_POST['Message'])) {
			$model->attributes = $_POST['Message'];
			$model->from_user_id = Yii::app()->user->id;
			$model->validate();
			if(!$model->hasErrors()) {
				$model->save();
				Core::setFlash(Yii::t('UserModule.user', 'Message "{message}" has been sent to {to}', array(
								'{message}' => $model->title,
								'{to}' => User::model()->findByPk($model->to_user_id)->username
								))); 
				$this->redirect(array('index'));
			}
		}

		$this->render('compose',array(
			'model'=>$model,
			'to_user_id' => $to_user_id,
		));
	}

	public function actionSuccess() {
		$this->renderPartial('success');
	}

	public function actionDelete() {
			$this->loadModel('Message')->delete();
			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$model = new Message;

		$this->render('index',array(
					'model'=> $model));
	}

	public function actionSent()
	{
		$model = new Message;

		$this->render('sent',array(
					'model'=> $model));
	}

	public function actionSendDigest() {
		$message = '';

		$recipients = array();
		if(isset($_POST['sendDigest'])) {
			foreach(Message::model()->with('to_user')->findAll('not message_read') as $message) {
				if((is_object($message->to_user) && $message->to_user->notifyType == 'Digest')
						|| $this->module->notifyType == 'Digest') { 
					$this->mailMessage($message);
					$recipients[] = $message->to_user->profile->email;
				}
			}
			if(count($recipients) == 0)
				$message = Yii::t('UserModule.user', 'No messages are pending. No message has been sent.'); 
			else {
				$message = Yii::t('UserModule.user', 'Digest has been sent to {users} users:', array('{users}' => count($recipients)));
				$message .= '<ul>';
				foreach($recipients as $recipient) {
					$message .= sprintf('<li> %s </li>', $recipient);
				}
				$message .= '</ul>';
			}
		}
		$this->render('send_digest', array('message' => $message));
	}
}
