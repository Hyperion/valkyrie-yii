<?php

class AccountController extends CpController
{

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('index', 'create'),
                'users'=>array('@'),
            ),
            array('allow',
                'actions'=>array('edit', 'view', 'characters', 'repair'),
                'expression'=>'$user->haveAccount()',
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Account('login');
        $model->unsetAttributes();

        if(isset($_POST['Account']))
        {
            $model->attributes = $_POST['Account'];
            if($model->validate())
            {
                $model->email = Yii::app()->user->email;
                if($model->save())
                    $model->saveUserRelation();
            }
        }

        $this->render('index', array('model' => $model));
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

    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel(),
        ));
    }

    public function actionCreate()
    {
        $form = new AccountCreateForm();

        if(isset($_POST['AccountCreateForm']))
        {
            $form->attributes=$_POST['AccountCreateForm'];
            if($form->validate())
            {
                $model = new Account('create');
                $model->attributes = $form->getAttributes();
                $model->email = Yii::app()->user->email;
                $model->password = $form->password;
                if($model->save())
                {
                    $model->saveUserRelation();
                    $this->redirect(array('view','id'=>$model->id));
                }
            }
        }

        $this->render('create',array(
            'form'=>$form,
        ));
    }


    public function actionEdit($id)
    {
        $model=$this->loadModel();
        $model->setScenario('edit');

        if(isset($_POST['Account']))
        {
            $model->attributes=$_POST['Account'];
            if($_POST['change_pass'] == 1)
                $model->password = $_POST['Account']['password'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('edit',array(
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
}
