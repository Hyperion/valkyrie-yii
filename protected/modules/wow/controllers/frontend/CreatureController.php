<?php

class CreatureController extends Controller
{
    public function allowedActions()
    {
        return '*';
    }
    
    public function actionView($id)
    {
        $this->layout = '//layouts/wiki';
        $model = $this->loadModel($id);
        $this->render('view', array('model' => $model));
    }

    public function actionIndex()
    {
        $model = new CreatureTemplate('search');
        
        $this->render('index', array('model' => $model));
    }
    
    public function actionTooltip($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('tooltip', array('model' => $model));
    }

	public function actionLoot($id)
	{
		$model = $this->loadModel($id);
		$dataProvider = $model->loot;

		$this->render('/item/_items', array('dataProvider' => $dataProvider));
	}

    public function loadModel($id)
    {
        $model = CreatureTemplate::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
