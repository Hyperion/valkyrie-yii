<?php

class ToolController extends Controller
{
    private $class;
    public function actionTalents($class)
    {
        $this->class = $class;

        $tab_class = $this->getTalentTabForClass();

        $characterClass = array();
        $characterClass['classId'] = $class;
        $characterClass['name'] = 'Шаман';
        $characterClass['powerType'] = 'Mana';
        $characterClass['powerTypeId'] = $this->powerType;

        $talentTrees = array();

        for($i = 0; $i < 3; $i++)
        {
            $current_tab = Yii::app()->db
                    ->createCommand("SELECT * FROM `wow_talent` WHERE `tab` = {$tab_class[$i]} ORDER BY `tab`, `row`, `col`")
                    ->queryAll();
            if(!$current_tab)
            {
                continue;
            }

            $talentTrees[$i]['name'] = $this->getTalentSpecNameFromDB($i);
            $talentTrees[$i]['icon'] = $this->getTalentSpecIconFromDB($i);
            $talentTrees[$i]['treeNo'] = $i;
            $talentTrees[$i]['overlayColor'] = "#cc33cc";
            $talentTrees[$i]['description'] = "Заклинатель, который подчиняет себе разрушительные силы стихий.";

            foreach($current_tab as $tal)
            {
                $talent = array();

                $talent['id'] = $tal['id'];
                $talent['y'] = $tal['row'];
                $talent['x'] = $tal['col'];
                if($tal['required'])
                    $talent['req'] = $tal['required'];

                $tSpell = Spell::model()->findByPk($tal['rank1']);
                $tSpell->formatInfo();
                $talent['name'] = $tSpell->spellname_loc0;
                $talent['icon'] = $tSpell->iconName;

                $talent['ranks'] = array();
                $talent['ranks'][] = array('description' => $tSpell->info);

                if($tal['rank2'])
                {
                    $tSpell = Spell::model()->findByPk($tal['rank2']);
                    $tSpell->formatInfo();
                    $talent['ranks'][] = array('description' => $tSpell->info);
                }
                if($tal['rank3'])
                {
                    $tSpell = Spell::model()->findByPk($tal['rank3']);
                    $tSpell->formatInfo();
                    $talent['ranks'][] = array('description' => $tSpell->info);
                }
                if($tal['rank4'])
                {
                    $tSpell = Spell::model()->findByPk($tal['rank4']);
                    $tSpell->formatInfo();
                    $talent['ranks'][] = array('description' => $tSpell->info);
                }
                if($tal['rank5'])
                {
                    $tSpell = Spell::model()->findByPk($tal['rank5']);
                    $tSpell->formatInfo();
                    $talent['ranks'][] = array('description' => $tSpell->info);
                }

                if($tal['singlePoint'])
                    $talent['keyAbility'] = true;
                else
                    $talent['keyAbility'] = false;

                $talentTrees[$i]['talents'][] = $talent;
            }
        }
        $data = array();
        $data['characterClass'] = $characterClass;
        $data['talentTrees'] = $talentTrees;
        echo 'TalentCalculator.instances.character.receiveData({
  "talentData" : '.json_encode($data).'});';
    }

    public function getPowerType()
    {
        switch($this->class)
        {
            case Character::CLASS_WARRIOR:
                return Character::POWER_RAGE;
                break;
            case Character::CLASS_ROGUE:
                return Character::POWER_ENERGY;
                break;
            case Character::CLASS_DK:
                return Character::POWER_RUNIC_POWER;
                break;
            /*
            case Character::CLASS_HUNTER:
                $this->_power_type = self::POWER_FOCUS;
                break;
            */
            default:
                return Character::POWER_MANA;
                break;
        }
    }

    public function getTalentTabForClass($tab_count = -1)
    {

        $talentTabId = array(
            Character::CLASS_WARRIOR => array(161, 164, 163),
            Character::CLASS_PALADIN => array(382, 383, 381),
            Character::CLASS_HUNTER  => array(361, 363, 362),
            Character::CLASS_ROGUE   => array(182, 181, 183),
            Character::CLASS_PRIEST  => array(201, 202, 203),
            //Character::CLASS_DK      => array(398, 399, 400),
            Character::CLASS_SHAMAN  => array(261, 263, 262),
            Character::CLASS_MAGE    => array( 81,  41,  61),
            Character::CLASS_WARLOCK => array(302, 303, 301),
            Character::CLASS_DRUID   => array(283, 281, 282)
        );
        if(!isset($talentTabId[$this->class]))
        {
            return false;
        }
        $tab_class = $talentTabId[$this->class];
        if($tab_count >= 0)
        {
            $values = array_values($tab_class);
            return $values[$tab_count];
        }
        return $tab_class;
    }

    public function getTalentSpecNameFromDB($spec)
    {
        $column = 'name_'.Yii::app()->language;
        return Yii::app()->db
            ->createCommand("SELECT $column FROM wow_talent_icons WHERE class = {$this->class} AND spec = $spec LIMIT 1")
            ->queryScalar();
    }

    public function getTalentSpecIconFromDB($spec)
    {
        return Yii::app()->db
            ->createCommand("SELECT icon FROM wow_talent_icons WHERE class = {$this->class} AND spec = $spec LIMIT 1")
            ->queryScalar();
    }
}
