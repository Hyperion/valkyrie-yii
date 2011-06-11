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
}
