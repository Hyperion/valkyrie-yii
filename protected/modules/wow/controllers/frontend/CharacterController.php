<?php

class CharacterController extends Controller
{
    public $layout='//layouts/profile_wrapper';
    private $_model;

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
        $this->_model = Character::model()->find('name = ?', array($name));
        if($this->_model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $this->_model;
    }
}
