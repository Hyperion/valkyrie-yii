<?php

class ProfileController extends Controller {
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'admin', 'visits'),
				'expression' => 'Yii::app()->user->isAdmin()'
				),
			array('allow',
				'actions'=>array('view', 'update', 'edit'),
				'users' => array('@'),
				),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdate($id = null) {
		if(!$id)
			$id = Yii::app()->user->data()->id;

		$user = User::model()->findByPk($id);
		$profile = $user->profile;

		if(isset($_POST['User']) && isset($_POST['Profile'])) {
			$user->attributes=$_POST['User'];
			$profile->attributes = $_POST['Profile'];
			$profile->user_id = $user->id;

			$profile->validate();
			$user->validate();

			if(!$user->hasErrors() && !$profile->hasErrors()) {
				if($user->save() && $profile->save()) {
					Core::setFlash('Your changes have been saved');
					$this->redirect(array('/user/user/profile', 'id'=>$user->id));
				}
			}
		}

		$this->render($this->module->profileEditView,array(
					'user'=>$user,
					'profile'=>$profile,
					));
	}

	public function actionVisits() {
		$this->layout = $this->module->adminLayout;

		$this->render('visits',array(
			'model'=>new ProfileVisit(),
		));

	}

	public function actionView($id = null) {
		// If no profile id is provided, take myself
		if(!$id)
			$id = Yii::app()->user->id;

		if(Yii::app()->user->isGuest)
			throw new CHttpException(403);

		if(is_numeric($id))
			$model = User::model()->findByPk($id);
		else if(is_string($id))
			$model = User::model()->find("username = '{$id}'");

		$this->updateVisitor(Yii::app()->user->id, $id);

		if(Yii::app()->request->isAjaxRequest)
			$this->renderPartial('/profile/view', array(
						'model' => $model));
		else
			$this->render('/profile/view', array(
						'model' => $model));

	}

	public function updateVisitor($visitor_id, $visited_id)
	{
		// Visiting my own profile doesn't count as visit
		if($visitor_id == $visited_id)
			return true;

		$visit = ProfileVisit::model()->find(
				'visitor_id = :visitor_id and visited_id = :visited_id', array(
					':visitor_id' => $visitor_id,
					':visited_id' => $visited_id));
		if($visit) {
			$visit->save();
		} else {
			$visit = new ProfileVisit();
			$visit->visitor_id = $visitor_id;
			$visit->visited_id = $visited_id;
			$visit->save();
		}
	}

	public function actionIndex()
	{
		$this->redirect('view');
	}

	public function actionAdmin()
	{
		$model = new Profile;

		$dataProvider=new CActiveDataProvider('Profile', array(
			'pagination'=>array(
				'pageSize'=>$this->module->pageSize,
			),
			'sort'=>array(
				'defaultOrder'=>'id',
			),
		));

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,'model'=>$model,
		));
	}
}
