<?php

class WowTalents extends CComponent
{

    private $_class;
    private $_icons;
    private $_names;

    public function __construct($class)
    {
        $this->_class = $class;
    }

    public function getTalentTrees()
    {
        $talentTrees = Yii::app()->cache->get('talentTrees_'.$this->_class);
        if(!$talentTrees)
        {
            $tab_class = $this->getTalentTabForClass();

            $talentTrees = array();

            for($i = 0; $i < 3; $i++)
            {
                $current_tab = Yii::app()->db
                        ->createCommand("SELECT * FROM `wow_talent` WHERE `tab` = {$tab_class[$i]} ORDER BY tab, row, col")
                        ->queryAll();
                if(!$current_tab)
                {
                    continue;
                }

                $talentTrees[$i]['name'] = $this->names[$i];
                $talentTrees[$i]['icon'] = $this->icons[$i];
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
                    $talent['ranks'][] = array(
                        'description' => $tSpell->info,
                        'id' => $tal['rank1']);

                    if($tal['rank2'])
                    {
                        $tSpell = Spell::model()->findByPk($tal['rank2']);
                        $tSpell->formatInfo();
                        $talent['ranks'][] = array(
                            'description' => $tSpell->info,
                            'id' => $tal['rank2']);
                    }
                    if($tal['rank3'])
                    {
                        $tSpell = Spell::model()->findByPk($tal['rank3']);
                        $tSpell->formatInfo();
                        $talent['ranks'][] = array(
                            'description' => $tSpell->info,
                            'id' => $tal['rank3']);
                    }
                    if($tal['rank4'])
                    {
                        $tSpell = Spell::model()->findByPk($tal['rank4']);
                        $tSpell->formatInfo();
                        $talent['ranks'][] = array(
                            'description' => $tSpell->info,
                            'id' => $tal['rank4']);
                    }
                    if($tal['rank5'])
                    {
                        $tSpell = Spell::model()->findByPk($tal['rank5']);
                        $tSpell->formatInfo();
                        $talent['ranks'][] = array(
                            'description' => $tSpell->info,
                            'id' => $tal['rank5']);

                    }

                    $talent['maxpoints'] = count($talent['ranks']);

                    if($tal['singlePoint'])
                        $talent['keyAbility'] = true;
                    else
                        $talent['keyAbility'] = false;

                    $talentTrees[$i]['talents'][] = $talent;
                }
            }

            Yii::app()->cache->set('talentTrees_'.$this->_class, $talentTrees);
        }

        return $talentTrees;
    }

    public function getTalentTabForClass()
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
        if(!isset($talentTabId[$this->_class]))
        {
            return false;
        }
        $tab_class = $talentTabId[$this->_class];

        return $tab_class;
    }

    public function getPowerType()
    {
        switch($this->_class)
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

    public function getNames()
    {
        if(!$this->_names)
        {
            $column = 'name_'.Yii::app()->language;
            $this->_names = Yii::app()->db
            ->createCommand("SELECT $column FROM wow_talent_icons WHERE class = {$this->_class} ORDER BY spec LIMIT 3")
            ->queryColumn();
        }

        return $this->_names;
    }

    public function getIcons()
    {
        if(!$this->_icons)
            $this->_icons = Yii::app()->db
            ->createCommand("SELECT icon FROM wow_talent_icons WHERE class = {$this->_class} ORDER BY spec LIMIT 3")
            ->queryColumn();
        return $this->_icons;
    }
}
