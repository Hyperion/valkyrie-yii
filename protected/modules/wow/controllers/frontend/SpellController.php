<?php

class SpellController extends Controller
{
    public function actionIndex()
    {
        $model = new Spell('search');
        
        $this->render('index', array('model' => $model));
    }

    public function loadModel($id)
    {
        $model = Spell::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        
        $model->formatInfo();
        return $model;
    }
}
