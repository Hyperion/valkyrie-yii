<?php

class SpellController extends Controller
{
    public function actionView($id)
    {
        $this->layout = '//layouts/wiki';
        $model = $this->loadModel($id);

        $this->cs->registerCssFile('/css/wow/wiki/wiki.css');
        $this->cs->registerCssFile('/css/wow/wiki/item.css');

        $this->cs->registerScriptFile('/js/wow/wiki/wiki.js', CClientScript::POS_END);
        $this->cs->registerScriptFile('/js/wow/wiki/item.js', CClientScript::POS_END);
        $this->cs->registerScriptFile('/js/local-common/table.js', CClientScript::POS_END);
        $this->cs->registerScriptFile('/js/local-common/cms.js', CClientScript::POS_END);
        $this->cs->registerScriptFile('/js/local-common/filter.js', CClientScript::POS_END);
        $this->cs->registerScriptFile('/js/local-common/utility/model-rotator.js', CClientScript::POS_END);

        $this->render('view', array('model' => $model));
    }

    public function actionIndex()
    {
        $model = new Spell('search');
        $model->unsetAttributes();

        if(isset($_GET['Spell']))
        {
            $model->attributes = $_GET['Spell'];
        }

        $this->render('index', array('model' => $model));
    }

    public function actionTooltip($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('tooltip', array('model' => $model));
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
