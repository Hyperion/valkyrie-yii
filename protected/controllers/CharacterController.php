<?php

class CharacterController extends Controller
{

    public function allowedActions()
    {
        return '*';
    }

    public function init()
    {
        parent::init();

        $this->layout = '/layouts/character';

        if(isset($_GET['name']))
        {
            $this->_model = $this->loadModel($_GET['name']);
            $this->_model->loadAdditionalData();

            if($this->_model->getPvpTitle($this->_model->honorRank))
            {
                $this->pageCaption = $this->_model->getPvpTitle($this->_model->honorRank) . ' ';
            }

            $this->pageCaption .= $this->_model->name;
            $this->pageDescription = "{$this->_model->race_text} - {$this->_model->class_text} ({$this->_model->talents['name']}) {$this->_model['level']} lvl";
        }
    }

    public function actionSimple()
    {
        $this->registerFiles();
        $this->cs->registerCssFile('/css/wow/character/summary.css');
        $this->cs->registerScriptFile('/js/wow/character/summary.js', CClientScript::POS_END);
        $this->cs->registerCss(1, '#content .content-top { background: url("/images/wow/character/summary/backgrounds/race/'.$this->_model->race.'.jpg") left top no-repeat; } .profile-wrapper { background-image: url("/images/wow/2d/profilemain/race/'.$this->_model->race.'-'.$this->_model->gender.'.jpg"); }');

        $this->render('view', array(
            'model' => $this->_model,
        ));
    }

    public function actionAdvanced()
    {
        $this->registerFiles();
        $this->cs->registerCssFile('/css/wow/character/summary.css');
        $this->cs->registerScriptFile('/js/wow/character/summary.js', CClientScript::POS_END);
        $this->cs->registerCss(1, '#content .content-top { background: url("/images/wow/character/summary/backgrounds/race/'.$this->_model->race.'.jpg") left top no-repeat; } .profile-wrapper { background-image: url("/images/wow/2d/profilemain/race/'.$this->_model->race.'-'.$this->_model->gender.'.jpg"); }');

        $this->render('view', array(
            'model' => $this->_model,
        ));
    }

    public function actionThreed()
    {
        $this->registerFiles();
        $this->cs->registerCssFile('/css/wow/character/summary.css');
        $this->cs->registerScriptFile('/js/wow/character/summary.js', CClientScript::POS_END);

        $this->render('view', array(
            'model' => $this->_model,
        ));
    }

    public function actionIndex()
    {
        $this->layout = '//layouts/column1';

        $model = new Character('search');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /* public function actionTalents($realm, $name)
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
      } */

    public function actionTooltip($realm, $name)
    {
        $this->renderPartial('tooltip', array(
            'model' => $this->_model,
        ));
    }

    public function actionReputation($realm, $name)
    {
        $this->render('reputation', array(
            'model' => $this->_model,
        ));
    }

    public function actionPvp($realm, $name)
    {
        $this->render('pvp', array(
            'model' => $this->_model,
        ));
    }

    public function actionFeed($realm, $name)
    {
        $this->registerFiles();
        $this->render('feed', array(
            'model' => $this->_model,
        ));
    }

    public function loadModel($name)
    {
        $this->_model = Character::model()->with('honor', 'stats')->find('name = ?', array($name));
        if($this->_model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $this->_model;
    }

    private function registerFiles()
    {
        $this->cs->registerCssFile('/css/wow/profile.css');
        $this->cs->registerScriptFile('/js/wow/profile.js', CClientScript::POS_END);
    }
}
