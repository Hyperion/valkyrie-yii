<?php

class UserController extends Controller {
	public $defaultAction = 'login';

	public function accessRules() {
		return array(
				array('allow',
					'actions'=>array('index', 'view', 'login'),
					'users'=>array('*'),
					),
				array('allow',
					'actions'=>array('profile', 'logout', 'changepassword', 'passwordexpired', 'delete', 'browse'),
					'users'=>array('@'),
					),
				array('allow',
						'actions' => array('update'),
						'expression' => 'Yii::app()->user->hasUser($_GET[\'id\'])',
						),
				array('allow',
						'actions' => array('update'),
						'expression' => 'Yii::app()->user->hasRoleOfUser($_GET[\'id\'])',
						),
				array('deny',  // deny all other users
						'users'=>array('*'),
						),
				);
	}

	public function actionIndex() {
		// If the user is not logged in, so we redirect to the actionLogin,
		// which will render the login Form

		if(Yii::app()->user->isGuest)
			$this->actionLogin();
		else
			$this->actionList();
	}

	public function actionStats() {
		$this->redirect($this->createUrl('/user/statistics/index'));
	}


	public function actionPasswordExpired()
	{
		$this->actionChangePassword($expired = true);
	}

	public function actionLogin() {
		// Do not show the login form if a session expires but a ajax request
		// is still generated
		if(Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest)
			return false;
		$this->redirect(array('/user/auth'));
	}

	public function actionLogout() {
		$this->redirect(array('//user/auth/logout'));
	}

	/**
	 * Change password
	 */
	public function actionChangePassword($expired = false) {
		$uid = Yii::app()->user->id;
		if(isset($_GET['id']))
			$uid = $_GET['id'];

		$form = new FChangePassword;

		if(isset($_POST['FChangePassword'])) {
			$form->attributes = $_POST['FChangePassword'];
			$form->validate();

			if(User::encrypt($form->currentPassword) != User::model()->findByPk($uid)->password)
				$form->addError('currentPassword', 'Your actual password is not correct');

			if(!$form->hasErrors()) {
				if(User::model()->findByPk($uid)->setPassword($form->password)) 
					Core::setFlash('The new password has been saved');
				else 
					Core::setFlash('There was an error saving the password');

				$this->redirect(array('//user/user/profile'));
			}
		}
		$this->render('changepassword', array('form'=>$form, 'expired' => $expired));
	}

	public function actionProfile() {
		$this->redirect(array('//user/profile/view',
					'id' => isset($_GET['id']) ? $_GET['id'] : Yii::app()->user->id));
	}


	/**
	 * Displays a User
	 */
	public function actionView()
	{
		$model = $this->loadUser();
		$this->render('view',array(
					'model'=>$model,
					));
	}
	
	public function actionBrowse() {
		$search = '';
		if(isset($_POST['search_username']))
			$search = $_POST['search_username'];

		$criteria = new CDbCriteria;

		$criteria->addCondition('status = 1 or status = 2 or status = 3');
		if($search) 
			$criteria->addCondition("username = '{$search}'");

		$dataProvider=new CActiveDataProvider('User', array(
					'criteria' => $criteria, 
					'pagination'=>array(
						'pageSize'=>50,
						)));

		$this->render('browse',array(
					'dataProvider'=>$dataProvider,
					'search_username' => $search ? $search : '',
					));
	}

	public function loadUser($uid = 0)
	{
		if($this->_model === null)
		{
			if($uid != 0)
				$this->_model = User::model()->findByPk($uid);
			elseif(isset($_GET['id']))
				$this->_model = User::model()->findByPk($_GET['id']);
			if($this->_model === null)
				throw new CHttpException(404,'The requested User does not exist.');
		}
		return $this->_model;
	}

}
