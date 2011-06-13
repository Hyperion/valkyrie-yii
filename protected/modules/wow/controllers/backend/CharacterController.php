<?php

class CharacterController extends Controller
{

    public function actionView($realm, $id)
    {
        Database::$realm = $realm;
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionUpdate($realm, $id)
    {
        Database::$realm = $realm;
        $model=$this->loadModel($id);
        $level = $model->level;
        $class = $model->class;

        if(isset($_POST['Character']))
        {
            $model->attributes=$_POST['Character'];
            if($model->save())
            {
                /*if($level !== $model->level)
                    $this->_mapper->updateWeaponSkills($model);
                if($class !== $model->class)
                    $this->_mapper->deleteSpells($model);*/
                $this->redirect(array('view','id'=>$model->guid, 'realm'=>Database::$realm));
            }
        }

        if(isset($_GET['Character']))
            $model->attributes=$_GET['Character'];

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionIndex()
    {
        Database::$realm = Database::model()->find('type = "characters"')->title;
        $model = new Character('admin');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('index',array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model = Character::model()->findByPk((int)$id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
