<?php

class CharacterController extends Controller
{
    public $layout='//layouts/profile_wrapper';

    public function actionSimple($realm, $name)
    {
        Database::$realm = (string)$realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();

        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/summary.css');
        $this->_cs->registerCss(1, '#content .content-top { background: url("/images/wow/character/summary/backgrounds/race/'.$model->race.'.jpg") left top no-repeat; } .profile-wrapper { background-image: url("/images/wow/2d/profilemain/race/'.$model->race.'-'.$model->gender.'.jpg"); }');

        $this->render('summary',array(
            'model'=>$model,
        ));
    }

    public function actionIndex()
    {
        $this->layout = '//layouts/main';

        Database::$realm = Database::model()->find('type = "characters"')->title;
        $model = new Character('search');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('index',array(
            'model' => $model,
        ));
    }

    public function actionAdvanced($realm, $name)
    {
        Database::$realm = (string)$realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();

        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/summary.css');
        $this->_cs->registerCss(1, '#content .content-top { background: url("/images/wow/character/summary/backgrounds/race/'.$model->race.'.jpg") left top no-repeat; } .profile-wrapper { background-image: url("/images/wow/2d/profilemain/race/'.$model->race.'-'.$model->gender.'.jpg"); }');

        $this->render('summary',array(
            'model'=>$model,
        ));
    }

    public function actionThreed($realm, $name)
    {
        Database::$realm = (string)$realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();
        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/summary.css');

        $this->render('summary',array(
            'model'=>$model,
        ));
    }

    public function actionTalents($realm, $name)
    {
        Database::$realm = (string)$realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();

        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/talent.css');
        $this->_cs->registerCssFile('/css/wow/tool/talent-calculator.css');
        $this->_cs->registerScriptFile('/js/wow/tool/talent-calculator.js', CClientScript::POS_END);

        $this->render('talents',array(
            'model'=>$model,
        ));
    }

    public function actionTooltip($realm, $name)
    {

        Database::$realm = (string)$realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();

        $this->renderPartial('tooltip',array(
            'model'=>$model,
        ));
    }

    public function actionReputation($realm, $name)
    {
        Database::$realm = (string) $realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();
        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/reputation.css');
        $this->_cs->registerScriptFile('/js/wow/character/reputation.js', CClientScript::POS_END);

        $this->render('reputation',array(
            'model'=>$model,
        ));
    }

    public function actionPvp($realm, $name)
    {
        Database::$realm = (string) $realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();
        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/pvp.css');

        $this->render('pvp',array(
            'model'=>$model,
        ));
    }

    public function actionFeed($realm, $name)
    {
        Database::$realm = (string) $realm;
        $model = $this->loadModel((string)$name);
        $model->loadAdditionalData();
        $this->registerFiles();
        $this->_cs->registerCssFile('/css/wow/character/pvp.css');

        $this->render('feed',array(
            'model'=>$model,
        ));
    }

    public function loadModel($name)
    {
        $this->_model = Character::model()->find('name = ?', array($name));
        if($this->_model===null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $this->_model;
    }

    private function registerFiles()
    {
        $this->_cs->registerCssFile('/css/wow/profile.css');
        $this->_cs->registerScriptFile('/js/wow/profile.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile('/js/wow/character/summary.js', CClientScript::POS_END);
    }
}
