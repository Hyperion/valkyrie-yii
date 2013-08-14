<?php

class AccountController extends CpController
{

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'register', 'add'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('edit', 'dashboard', 'characters', 'repair'),
                'expression'=>'$user->hasAccount()',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function init()
    {
        parent::init();
        $this->_cs->registerCssFile('/css/account/inputs.css');
    }

    public function actionIndex()
    {
        $this->_cs->registerCssFile('/css/account/management/lobby.css');
        $this->render('index');
    }

    public function actionCharacters($id)
    {
        Database::$realm = Database::model()->find('type = "characters"')->title;
        $model = new Character('search');
        $model->unsetAttributes();
        $model->account = $id;
        $this->render('characters',array(
            'dataProvider' => $model->search(true),
        ));
    }

    public function actionDashboard($name)
    {
        $this->_cs->registerCssFile('/css/account/management/dashboard.css');
        $this->_cs->registerCssFile('/css/account/management/wow/dashboard.css');
        $this->_cs->registerScriptFile('/js/account/management/dashboard.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/account/management/wow/dashboard.js', CClientScript::POS_END);

        $model = $this->loadModel($name);
        $fAccChangePass = new FAccountChangePassword;
        $fAccChangePass->username = $name;

        if(isset($_POST['FAccountChangePassword']))
        {
            $fAccChangePass->attributes=$_POST['FAccountChangePassword'];
            if($fAccChangePass->validate())
            {
                $model->password = $fAccChangePass->newPassword;
                if($model->save())
                    $this->redirect(array('dashboard','name'=>$model->username));
            }
            else
                $this->_cs->registerScript('show-form','DashboardForm.show($(\'#change-password\'));', CClientScript::POS_END);
        }

        if(isset($_POST['Account']))
        {
            $model->attributes=$_POST['Account'];
            if($model->save())
                $this->redirect(array('dashboard','name'=>$model->username));
            else
                $this->_cs->registerScript('show-form','DashboardForm.show($(\'#change-locale\'));', CClientScript::POS_END);
        }

        $this->render('dashboard',array(
            'model'=>$model,
            'change_password_form'=>$fAccChangePass,
        ));
    }

    public function actionRegister()
    {
        $form = new FAccountCreate();

        if(isset($_POST['FAccountCreate']))
        {
            $form->attributes=$_POST['FAccountCreate'];
            if($form->validate())
            {
                $model = new Account;
                $model->attributes = $form->getAttributes();
                $model->email = Yii::app()->user->email;
                $model->password = $form->password;
                if($model->save())
                {
                    $model->saveUserRelation();
                    $this->redirect(array('dashboard','name'=>$model->username));
                }
            }
        }

        $this->render('register',array(
            'model'=>$form,
        ));
    }

    public function actionAdd()
    {
        $model = new Account('add');

        if(isset($_POST['Account']))
        {
            $model->attributes=$_POST['Account'];
            $model->email = Yii::app()->user->email;
            if($model->save())
            {
                $model->saveUserRelation();
                $this->redirect(array('dashboard','name'=>$model->username));
            }
        }

        $this->render('add',array(
            'model'=>$model,
        ));
    }

    public function actionRepair($id)
    {
        $mapper = new CharacterMapper();
        if($mapper->repair((int) $_GET['guid'], (int) $_GET['id']))
            $this->redirect(array('characters','id'=>$id));
        else throw new CHttpException(404,'The requested character does not exist on your account.');
    }

    public function loadModel($name)
    {
        $model = Account::model()->find('username = ?', array($name));
        if($model===null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}
