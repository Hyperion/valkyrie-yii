<?php

class UserController extends BackendController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model   = new User;
        $profile = new Profile;
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            $model->activkey = Yii::app()->controller->module->encrypting(microtime().$model->password);
            $model->createtime = time();
            $model->lastvisit = time();
            $profile->attributes = (isset($_POST['Profile'])) ? $_POST['Profile'] : array();
            $profile->user_id = 0;
            if ($model->validate() && $profile->validate())
            {
                $model->password = Yii::app()->controller->module->encrypting($model->password);
                if ($model->save())
                {
                    $profile->user_id = $model->id;
                    $profile->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            } else
                $profile->validate();
        }

        $this->render('create', array(
            'model'   => $model,
            'profile' => $profile,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate($id)
    {
        $model   = $this->loadModel($id);
        $profile = $model->profile;
        
        $this->performAjaxValidation($model);
        
        if (isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            $profile->attributes = (isset($_POST['Profile'])) ? $_POST['Profile'] : array();

            if ($model->validate() && $profile->validate())
            {
                $old_password = User::model()->notsafe()->findByPk($model->id);
                if ($old_password->password != $model->password)
                {
                    $model->password = Yii::app()->controller->module->encrypting($model->password);
                    $model->activkey = Yii::app()->controller->module->encrypting(microtime().$model->password);
                }
                $model->save();
                $profile->save();
                $this->redirect(array('view', 'id' => $model->id));
            } else
                $profile->validate();
        }

        $this->render('update', array(
            'model'   => $model,
            'profile' => $profile,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model   = $this->loadModel($id);
            $profile = Profile::model()->findByPk($model->id);
            $profile->delete();
            $model->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_POST['ajax']))
                $this->redirect(array('/user/user'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}