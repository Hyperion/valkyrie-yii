<?php

class SpellController extends Controller
{
	public function actionView($id)
	{
		$model = $this->loadModel($id);
	}

    public function loadModel($id)
    {
        $model = Spell::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
