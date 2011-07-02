<?php

class UserController extends AdminController
{
    private $_model;

    public function actionView()
    {
        $model = $this->loadUser();
        $this->render('view',array('model'=>$model));
    }

    public function actionIndex()
    {
        $model = new User('search');
        $model->unsetAttributes();

        if(isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array('model'=>$model));
    }

    public function actionCreate()
    {
        $model = new User;
        $profile = new Profile;
        $passwordform = new FChangePassword;

        if(!isset($model->status))
            $model->status = 1;

        if(isset($_POST['User'])) {
            $model->attributes=$_POST['User'];

            if(isset($_POST['Profile']) )
                $profile->attributes = $_POST['Profile'];

            if(isset($_POST['FChangePassword'])) {
                if($_POST['FChangePassword']['password'] == '') {
                    $password = User::generatePassword();
                    $model->setPassword($password);
                    Core::setFlash(Yii::t('UserModule.user', 'The generated Password is {password}', array('{password}' => $password)));
                } else {
                    $passwordform->attributes = $_POST['FChangePassword'];

                    if($passwordform->validate())
                        $model->setPassword($_POST['FChangePassword']['password']);
                }
            }

            $model->activationKey = User::encrypt(microtime() . $model->password);

            $model->validate();
            $profile->validate();
            if(!$model->hasErrors()
                    && !$profile->hasErrors()
                    && !$passwordform->hasErrors()) {
                $model->save();
                $profile->user_id = $model->id;
                $profile->save();
                $this->redirect(array('view', 'id'=>$model->id));
            }
        }

        $this->render('create',array(
                    'model' => $model,
                    'passwordform' => $passwordform,
                    'profile' => $profile,
                    ));
    }

    public function actionUpdate()
    {
        $model = $this->loadUser();
        $passwordform = new FChangePassword();

        $profile = $model->profile;

        if(isset($_POST['User'])) {
            $model->attributes = $_POST['User'];


            if(isset($_POST['Profile']) )
                $profile->attributes = $_POST['Profile'];

            if(isset($_POST['FChangePassword'])
                    && $_POST['FChangePassword']['password'] != '') {
                $passwordform->attributes = $_POST['FChangePassword'];
                if($passwordform->validate())
                    $model->setPassword($_POST['FChangePassword']['password']);
            }

            if(!$passwordform->hasErrors() && $model->save()) {
                if(isset($profile)) {
                    if($profile->save())
                        $this->redirect(array('view','id'=>$model->id));
                } else
                    $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('update', array(
                    'model'=>$model,
                    'passwordform' =>$passwordform,
                    'profile' => isset($profile) ? $profile : false,
                    ));
    }

    public function actionDelete()
    {
        $model = $this->loadUser();

        if($model->id == Yii::app()->user->id)
        {
            Yii::app()->user->setFlash('adminMessage', 'You can not delete your own admin account');
        }

        if($model->profile)
            $model->profile->delete();

        if($model->delete()) {
            Core::setFlash('The User has been deleted');
            $this->redirect(array('/user/user/admin'));
        }
    }

    public function loadUser($id = 0)
    {
        if($this->_model === null)
        {
            if($id != 0)
                $this->_model = User::model()->findByPk($id);
            elseif(isset($_GET['id']))
                $this->_model = User::model()->findByPk($_GET['id']);
            if($this->_model === null)
                throw new CHttpException(404,'The requested User does not exist.');
        }
        return $this->_model;
    }
}
