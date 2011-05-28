<?php

class ItemController extends Controller
{
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$this->render('view', array('model' => $model));
	}

    public function loadModel($id)
    {
        $model = ItemTemplate::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
