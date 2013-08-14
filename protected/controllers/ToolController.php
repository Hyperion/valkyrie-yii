<?php

class ToolController extends Controller
{
    public function actionTalents($class)
    {
        $talentHandler = new WowTalents($class);

        $characterClass = array();
        $characterClass['classId'] = $class;
        $characterClass['name'] = 'Шаман';
        $characterClass['powerType'] = 'Mana';
        $characterClass['powerTypeId'] = $talentHandler->powerType;

        $talentTrees = $talentHandler->talentTrees;

        $data = array();
        $data['characterClass'] = $characterClass;
        $data['talentTrees'] = $talentTrees;
        echo 'TalentCalculator.instances.character.receiveData({
  "talentData" : '.json_encode($data).'});';
    }

    public function actionTalentCalculator()
    {
        $this->_cs->registerCssFile('/css/wow/profile.css');
        $this->_cs->registerCssFile('/css/wow/character/talent.css');
        $this->_cs->registerCssFile('/css/wow/tool/talent-calculator.css');
        $this->_cs->registerScriptFile('/js/wow/tool/talent-calculator.js', CClientScript::POS_END);

        $class = (isset($_GET['class'])) ? (int) $_GET['class'] : 1;
        $build = (isset($_GET['build'])) ? $_GET['build'] : null;

        $talentHandler = new WowTalents($class);
        $data = $talentHandler->talentTrees;

        $this->render('talentCalculator', array(
            'data' => $data,
            'classId' => $class,
            'build' => $build,
        ));
    }
}
