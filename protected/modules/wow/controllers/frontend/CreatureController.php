<?php

class CreatureController extends Controller
{
    public function actionView($id)
    {
        $this->layout = '//layouts/wiki';
        $model = $this->loadModel($id);

        $this->_cs->registerCssFile('/css/wow/wiki/wiki.css');
        $this->_cs->registerCssFile('/css/wow/wiki/item.css');
        
        $this->_cs->registerScriptFile('/js/wow/wiki/wiki.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/wow/wiki/item.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/local-common/table.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/local-common/cms.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/local-common/filter.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/local-common/utility/model-rotator.js', CClientScript::POS_END);
        
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
        $data = array();

        if(isset($_REQUEST['data']))
            $data = $_REQUEST['data'];

        $this->renderPartial('tooltip', array('model' => $model));
    }

    public function loadModel($id)
    {
        $model = CreatureTemplate::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}
