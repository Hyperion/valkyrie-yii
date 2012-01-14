<?php

class ItemController extends Controller
{

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render('view', array('model' => $model));
    }

    public function actionIndex()
    {
        $model = new ItemTemplate('search');

        $model->unsetAttributes();

        if(isset($_GET['classId']))
            $model->class = (int) $_GET['classId'];
        if(isset($_GET['subClassId']))
            $model->subclass = (int) $_GET['subClassId'];
        if(isset($_GET['invType']))
            $model->InventoryType = (int) $_GET['invType'];

        $this->render('index', array('model' => $model));
    }

    public function actionTooltip($id)
    {
        $model = $this->loadModel($id);
        $data = array();

        if(isset($_REQUEST['data']))
            $data = $_REQUEST['data'];

        $this->renderPartial('tooltip', array('model' => $model, 'data' => $data));
    }

    public function actionDropCreatures($id)
    {
        $model = $this->loadModel($id);
        $dataProvider = $model->dropCreatures;

        $this->renderPartial('_dropCreatures', array('dataProvider' => $dataProvider));
    }

    public function actionVendors($id)
    {
        $model = $this->loadModel($id);
        $dataProvider = $model->vendors;

        $this->renderPartial('_vendors', array('dataProvider' => $dataProvider));
    }

    public function actionDisenchantFrom($id)
    {
        $model = $this->loadModel($id);
        $dataProvider = $model->disenchantFrom;

        $this->renderPartial('_items', array('dataProvider' => $dataProvider));
    }

    public function actionDisenchantItems($id)
    {
        $model = $this->loadModel($id);
        $dataProvider = $model->disenchantItems;

        $this->renderPartial('_items', array('dataProvider' => $dataProvider));
    }

    public function loadModel($id)
    {
        $model = ItemTemplate::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
