<?php

class ItemController extends Controller
{

    public function allowedActions()
    {
        return '*';
    }

    public $class = 'ItemTemplate';

    public function actionIndex()
    {
        $model = new ItemTemplate('search');
        $model->unsetAttributes();
        
        if(isset($_GET['ItemTemplate']))
            $model->attributes = $_GET['ItemTemplate'];

        $this->render('index', array('model' => $model));
    }

    public function actionDropCreatures($id)
    {
        $model        = $this->loadModel($id);
        $dataProvider = $model->dropCreatures;

        $this->renderPartial('_dropCreatures', array('dataProvider' => $dataProvider));
    }

    public function actionVendors($id)
    {
        $model        = $this->loadModel($id);
        $dataProvider = $model->vendors;

        $this->renderPartial('_vendors', array('dataProvider' => $dataProvider));
    }

    public function actionDisenchantFrom($id)
    {
        $model        = $this->loadModel($id);
        $dataProvider = $model->disenchantFrom;

        $this->renderPartial('_items', array('dataProvider' => $dataProvider));
    }

    public function actionDisenchantItems($id)
    {
        $model        = $this->loadModel($id);
        $dataProvider = $model->disenchantItems;

        $this->renderPartial('_items', array('dataProvider' => $dataProvider));
    }

}