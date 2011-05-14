<?php

// This controller handles the upload and the deletion of an Avatar
// image for the user profile.

class AvatarController extends Controller {
	public function actionRemoveAvatar() {
		$model = User::model()->findByPk(Yii::app()->user->id);
		$model->avatar = '';
		$model->save();
		$this->redirect(array('user/profile/view', 'id' => $model->id));	
	}

	public function beforeAction($action) {
		// Disallow guests
		if(Yii::app()->user->isGuest)
			$this->redirect($this->module->loginUrl);

		// Stop action if Avatars are disabled in the module configuration
		if(!$this->module->enableAvatar)
			return false;

		return parent::beforeAction($action);
	}

	public function actionEditAvatar() {
		$model = User::model()->findByPk(Yii::app()->user->id);

		if(isset($_POST['YumUser'])) {
			$model->attributes = $_POST['YumUser'];
			$model->setScenario('avatarUpload');

			if($this->module->avatarMaxWidth != 0)
				$model->setScenario('avatarSizeCheck');

			$model->avatar = CUploadedFile::getInstanceByName('YumUser[avatar]');
			if($model->validate()) {
				if ($model->avatar instanceof CUploadedFile) {

					// Prepend the id of the user to avoid filename conflicts
					$filename = $this->module->avatarPath .'/'.  $model->id . '_' . $_FILES['YumUser']['name']['avatar'];
					$model->avatar->saveAs($filename);
					$model->avatar = $filename;
					if($model->save()) {
						Core::setFlash(Yii::t('UserModule.user', 'The image was uploaded successfully'));
						Core::log(Yii::t('UserModule.user', 'User {username} uploaded avatar image {filename}', array(
										'{username}' => $model->username,
										'{filename}' => $model->avatar)));
						$this->redirect(array('user/profile'));	
					}
				}
			}
		}

		$this->render('edit_avatar', array('model' => $model));
	}
}
