<?php

class CharacterController extends Controller
{
    public $layout='//layouts/column2';

    public function actionSimple($realm, $name)
    {
        Database::$realm = (string)$realm;
        $model = $this->loadModel((string)$name);
		$model->loadAdditionalData();
        
        $this->render('simple',array(
            'model'=>$model,
        ));
    }
    
    public function loadModel($name)
    {
        $model = Character::model()->find('name = ?', array($name));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}
