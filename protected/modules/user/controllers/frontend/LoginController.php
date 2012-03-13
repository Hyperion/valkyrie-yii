<?php

class LoginController extends Controller
{

    function filters()
    {
        return array(
            'accessControl',
        );
    }

    public $defaultAction = 'login';

    public function actionLogin()
    {
        if(Yii::app()->user->isGuest)
        {
            $model = new UserLogin;
            // collect user input data
            if(isset($_POST['UserLogin']))
            {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if($model->validate())
                {
                    $this->lastViset();
                    if(Yii::app()->request->isajaxRequest)
                        echo CJSON::encode(array(
                            'status' => 'success',
                        ));
                    else
                        $this->redirect(Yii::app()->user->returnUrl);
                    Yii::app()->end();
                }
            }
            // display the login form
            if(Yii::app()->request->isajaxRequest)
                echo CJSON::encode(array(
                    'status'  => 'render',
                    'content' => $this->renderPartial('/user/login', array('model' => $model), true, true),
                    'buttons' => array(
                    CHtml::link('Закрыть', '#', array('class' => 'btn', 'data-dismiss' => 'modal')),
                    CHtml::link('Вход', '#', array('class' => 'btn btn-primary', 'type' => 'submit')),
                ),
                ));
            else
                $this->render('/user/login', array('model' => $model));
        } else
            $this->redirect(Yii::app()->controller->module->returnUrl);
    }

    private function lastViset()
    {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

}