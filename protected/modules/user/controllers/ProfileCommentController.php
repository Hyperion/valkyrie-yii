<?php

class ProfileCommentController extends Controller
{
	public function accessRules()
	{
		return array(
				array('allow',  
					'actions'=>array('index'),
					'users'=>array('*'),
					),
				array('allow', 
					'actions'=>array('create', 'delete'),
					'users'=>array('@'),
					),
				array('allow', 
					'actions'=>array('admin'),
					'users'=>array('admin'),
					),
				array('deny', 
					'users'=>array('*'),
					),
				);
	}

	public function actionCreate() {
		$model = new ProfileComment;

		$this->performAjaxValidation($model, 'profile-comment-form');

		if(isset($_POST['ProfileComment'])) {
			$model->attributes = $_POST['ProfileComment'];
			$model->save();
			}

		if(isset($model->profile->user) && $user = $model->profile->user)
			$this->renderPartial('/profile/view', array(
						'model'=>$user
						), false, true);
	}


	public function actionDelete($id) {
		$comment = ProfileComment::model()->findByPk($id);

		if($comment->user_id == Yii::app()->user->id
				|| $comment->profile_id == Yii::app()->user->id) {
			$comment->delete();
			$this->redirect(array('/user/profile/view', 'id' => $comment->profile->user_id));
		} else
			throw new CHttpException(400,
					Yii::t('UserModule.user', 'You are not the owner of this Comment or this Profile!'));
	}

	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('ProfileComment');
		$this->render('index',array(
					'dataProvider'=>$dataProvider,
					));
	}

	public function actionAdmin() {
		$model=new ProfileComment('search');
		$model->unsetAttributes();

		if(isset($_GET['ProfileComment']))
			$model->attributes = $_GET['ProfileComment'];

		$this->render('admin',array(
					'model'=>$model,
					));
	}
}
