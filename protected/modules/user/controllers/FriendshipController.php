<?php

class FriendshipController extends Controller {
	// make sure that friendship is enabled in the configuration
	public function beforeAction($action) {
		if(!$this->module->enableFriendship) 
			return false;
		return(parent::beforeAction($action));
	}

	public function actionIndex() {
		if(isset($_POST['Friendship']['inviter_id']) 
				&& isset($_POST['Friendship']['friend_id']) ) {
			$friendship = Friendship::model()->find(
					'inviter_id = :inviter_id and friend_id = :friend_id', array(
						':inviter_id' => $_POST['Friendship']['inviter_id'],
						':friend_id' => $_POST['Friendship']['friend_id']));

			if(isset($friendship))
				if($friendship->inviter_id == Yii::app()->user->id 
						|| $friendship->friend_id == Yii::app()->user->id)
					if(isset($_POST['Friendship']['add_request']))
					{
						$friendship->acceptFriendship();
					} elseif(isset($_POST['Friendship']['deny_request'])) {
						$friendship->status = 3;
						$friendship->save();
					} elseif(isset($_POST['Friendship']['ignore_request'])) {
						$friendship->status = 0;
						$friendship->save();
					} elseif(isset($_POST['Friendship']['cancel_request']) 
							|| isset($_POST['Friendship']['remove_friend'])) {
						$friendship->delete();
					}
		}

		$user = User::model()->findByPk(Yii::app()->user->id);
		$this->render('myfriends', array('friends' => $user->getFriendships()));
	}

	public function actionAdmin() {
		$friendships = new CActiveDataProvider('Friendship', array(
					'criteria'=>array(
						'order'=>'status ASC',
						),
					'pagination'=>array(
						'pageSize'=>20,
						),
					));

		$this->render('admin', array('friendships' => $friendships));

	} 

	public function actionInvite($user_id = null) {
		if(isset($_POST['user_id']))
			$user_id = $_POST['user_id'];

		if($user_id == null)
			return false;

		if(isset($_POST['message']) && isset($user_id)) {
			$friendship = new Friendship;
			if($friendship->requestFriendship(Yii::app()->user->id,
						$_POST['user_id'],
						$_POST['message'])) {
				Core::setFlash('The friendship request has been sent');
				$this->redirect(array('//user/profile/view', 'id' => $user_id));
			}
		} 

		$this->render('invitation', array(
					'inviter' => User::model()->findByPk(Yii::app()->user->id),
					'invited' => User::model()->findByPk($user_id),
					'friendship' => isset($friendship) ? $friendship : null,
					));
	}

	public function ActionConfirmFriendship($id,$key)
	{
		$friendship=Friendship::model()->findByPK($id);

		if($friendship->friend_id == $key)
		{
			$friendship->acceptFriendship();
			$verified=true;
		}else{
			$verified=false;
		}
		return $verified;
	}

	public function actionView()
	{
		$model = Friendship::model()->findByPK($_GET['id']);
		$model->acknowledgetime =date('M/j/y g:i',$model->acknowledgetime);
		$model->requesttime =date('M/j/y g:i',$model->requesttime);
		$model->updatetime =date('M/j/y g:i',$model->updatetime);
		$this->render('view',array(
					'model'=>$model,
					));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,Yii::t('App','Invalid request. Please do not repeat this request again.'));
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(Yii::app()->request->isPostRequest)
		{
			$model->attributes=$_POST['Friendship'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
					'model'=>$model,
					));
	}

	public static function invitationLink($inviter, $invited) {
		if($inviter === $invited)
			return false;
		if(!is_object($inviter))
			$inviter = User::model()->findByPk($inviter);
		if(!is_object($invited))
			$invited = User::model()->findByPk($invited);

		$friends = $inviter->getFriends(true);
		if($friends && $friends[0] != NULL)
			foreach($friends as $friend) 
				if($friend->id == $invited->id)
					return false; // already friends, rejected or request pending

		return CHtml::link(Yii::t('UserModule.user', 'Add as a friend'), array(
					'friendship/invite', 'user_id' => $invited->id));
	}
}

?>
