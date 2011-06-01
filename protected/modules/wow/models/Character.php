<?php

class Character extends CActiveRecord
{
    /* Equipment Slots */
    const EQUIPMENT_SLOT_START = 0;
    const EQUIPMENT_SLOT_HEAD = 0;
    const EQUIPMENT_SLOT_NECK = 1;
    const EQUIPMENT_SLOT_SHOULDERS = 2;
    const EQUIPMENT_SLOT_BODY = 3;
    const EQUIPMENT_SLOT_CHEST = 4;
    const EQUIPMENT_SLOT_WAIST = 5;
    const EQUIPMENT_SLOT_LEGS = 6;
    const EQUIPMENT_SLOT_FEET = 7;
    const EQUIPMENT_SLOT_WRISTS = 8;
    const EQUIPMENT_SLOT_HANDS = 9;
    const EQUIPMENT_SLOT_FINGER1 = 10;
    const EQUIPMENT_SLOT_FINGER2 = 11;
    const EQUIPMENT_SLOT_TRINKET1 = 12;
    const EQUIPMENT_SLOT_TRINKET2 = 13;
    const EQUIPMENT_SLOT_BACK = 14;
    const EQUIPMENT_SLOT_MAINHAND = 15;
    const EQUIPMENT_SLOT_OFFHAND = 16;
    const EQUIPMENT_SLOT_RANGED = 17;
    const EQUIPMENT_SLOT_TABARD = 18;
    const EQUIPMENT_SLOT_END = 19;

    const CLASS_WARRIOR = 1;
    const CLASS_PALADIN = 2;
    const CLASS_HUNTER  = 3;
    const CLASS_ROGUE   = 4;
    const CLASS_PRIEST  = 5;
    const CLASS_DK      = 6;
    const CLASS_SHAMAN  = 7;
    const CLASS_MAGE    = 8;
    const CLASS_WARLOCK = 9;
    const CLASS_DRUID   = 11;
    const MAX_CLASSES   = 12;

    const POWER_HEALTH = 0xFFFFFFFE;
    const POWER_MANA = 0;
    const POWER_RAGE = 1;
    const POWER_FOCUS = 2;
    const POWER_ENERGY = 3;
    const POWER_HAPPINESS = 4;
    const POWER_RUNE = 5;
    const POWER_RUNIC_POWER = 6;
    const MAX_POWERS = 7;

    const ROLE_MELEE  = 1;
    const ROLE_RANGED = 2;
    const ROLE_CASTER = 3;
    const ROLE_HEALER = 4;
    const ROLE_TANK   = 5;

    const SKILL_BLACKSMITHING = 164;
    const SKILL_LEATHERWORKING = 165;
    const SKILL_ALCHEMY = 171;
    const SKILL_HERBALISM = 182;
    const SKILL_MINING = 186;
    const SKILL_TAILORING = 197;
    const SKILL_ENGINERING = 202;
    const SKILL_ENCHANTING = 333;
    const SKILL_SKINNING = 393;
    const SKILL_JEWELCRAFTING = 755;
    const SKILL_INSCRIPTION = 773;

    public $class_text = false;
    public $race_text = false;
    public $realm = false;

    private $_items = array();
    private $_talents_data = array();
    private $_professions = false;
    private $_power_type;
    private $_role;
    private $_item_level;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Database::getConnection(Database::$realm);
    }

    public function tableName()
    {
        return 'characters';
    }

    public function rules()
    {
        return array(
            array('name, level, class, race', 'safe', 'on'=>'online'),
            array('name, level, class, race, honor_standing', 'safe', 'on'=>'pvp'),
        );
    }
    
    public function relations()
    {
        return array(
            'honor' => array(self::HAS_ONE, 'CharacterHonorStatic','guid'),
            'stats' => array(self::HAS_ONE, 'CharacterStats', 'guid'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'honor_highest_rank' => 'Highest Rank',
            'honor_standing' => 'Standing',
            'honor_rank_points' => 'Rank Points',
        );
    }

    public function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'classes' => array(
                
            ),
            'races' => array(
                '1' => 'human',
                '2' => 'orc',
                '3' => 'dwarf',
                '4' => 'nightelf',
                '5' => 'scourge',
                '6' => 'tauren',
                '7' => 'gnome',
                '8' => 'troll',
            ),
            'genders' => array(
                '0' => 'male',
                '1' => 'female',
            ),
            'powers' => array(
                self::POWER_MANA   => 'Mana',
                self::POWER_RAGE   => 'Rage',
                self::POWER_ENERGY => 'Energy',
            ),
            'factions' => array(
                0 => 'alliance',
                1 => 'horde',
            ),
        );
                        
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function search($all_realms = false)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('name',$this->name,true);
        $criteria->compare('race',$this->race);
        $criteria->compare('class',$this->class);
        $criteria->compare('level',$this->level);
        $criteria->compare('online',$this->online);
        $criteria->compare('honor_standing',$this->honor_standing);
        $criteria->compare('account','>0');

        if($this->scenario == 'pvp')
        {
            $criteria->compare('honor_standing','>0');
            $criteria->with = 'honor';
        }

        if(isset($_GET['Character']['faction']))
        {
            switch($_GET['Character']['faction'])
            {
                case 0: $criteria->compare('race', array(1, 3 ,4, 7)); break;
                case 1: $criteria->compare('race', array(2, 5 ,6, 8)); break;
            }
        }
        
        return new CMultirealmDataProvider(get_class($this), array(
            'all_realms'=>$all_realms,
            'criteria'=>$criteria,
            'pagination'=> array(
                'pageSize'=> 40,
            ),
        ));
    }

    public function getFaction()
    {
        switch($this->race)
        {
            case 1: case 3: case 4: case 7: return 0;
            case 2: case 5: case 6: case 8: return 1;
        }
    }

    public function getHonorRank()
    {
        $rank = 0;
        if ($this->honor_rank_points <= -2000.0) $rank = 1;       // Pariah (-4)
        else if ($this->honor_rank_points <= -1000.0) $rank = 2;  // Outlaw (-3)
        else if ($this->honor_rank_points <= -500.0) $rank = 3;   // Exiled (-2)
        else if ($this->honor_rank_points < 0.0) $rank = 4;       // Dishonored (-1)
        else if ($this->honor_rank_points == 0) $rank = 0;
        else if ($this->honor_rank_points <  2000.00) $rank = 5;
        else if ($this->honor_rank_points > (13)*5000) $rank = 21;
        else $rank = 6 + (int) ($this->honor_rank_points / 5000);

        return $rank;
    }

    public function loadAdditionalData()
    {
        $column = 'name_'.Yii::app()->language;
        $connection = Yii::app()->db;
        $command = $connection->createCommand()
            ->select("r.$column AS race, c.$column AS class")
            ->from('wow_races r, wow_classes c')
            ->where('r.id = ? AND c.id = ?', array($this->race, $this->class))
            ->limit(1);
        $row = $command->queryRow();
        $this->race_text = $row['race'];
        $this->class_text = $row['class'];
    }

    protected function afterFind()
    {
        parent::afterFind();
        $this->realm = Database::$realm;
        $this->equipmentCache = explode(' ', $this->equipmentCache);
    }
    
    public function getItems()
    {
        $item_slots = array(
            self::EQUIPMENT_SLOT_HEAD      => 1,
            self::EQUIPMENT_SLOT_NECK      => 2,
            self::EQUIPMENT_SLOT_SHOULDERS => 3,
            self::EQUIPMENT_SLOT_BACK      => 16,
            self::EQUIPMENT_SLOT_CHEST     => 5,
            self::EQUIPMENT_SLOT_BODY      => 4,
            self::EQUIPMENT_SLOT_TABARD    => 19,
            self::EQUIPMENT_SLOT_WRISTS    => 9,
            self::EQUIPMENT_SLOT_HANDS     => 10,
            self::EQUIPMENT_SLOT_WAIST     => 6,
            self::EQUIPMENT_SLOT_LEGS      => 7,
            self::EQUIPMENT_SLOT_FEET      => 8,
            self::EQUIPMENT_SLOT_FINGER1   => 11,
            self::EQUIPMENT_SLOT_FINGER2   => 11,
            self::EQUIPMENT_SLOT_TRINKET1  => 12,
            self::EQUIPMENT_SLOT_TRINKET2  => 12,
            self::EQUIPMENT_SLOT_MAINHAND  => 21,
            self::EQUIPMENT_SLOT_OFFHAND   => 22,
            self::EQUIPMENT_SLOT_RANGED    => 28,
        );
        
        if(!$this->_items)
            for($i = 0, $j = 0; $i < 37; $i += 2, $j++)
            {
                $proto = ItemTemplate::model()->findByPk($this->equipmentCache[$i]);
                if($proto)
                {
                    $item_data = array(
                        'entry'            => $proto->entry,
                        'icon'               => $proto->icon,
                        'name'               => $proto->name,
                        'display_id'       => $proto->displayid,
                        'quality'           => $proto->Quality,
                        'item_level'       => $proto->ItemLevel,
                        'enchant_id'       => $this->equipmentCache[$i+1],
                        'enchant_item'    => 0,
                        'enchant_text'    => '',
                        'slot'              => $proto->InventoryType,
                        'can_displayed'      => !in_array($proto->InventoryType, array(2, 11, 12)),
                        'can_enchanted'      => !in_array($j, array(3, 17, 1, 5, 10, 11, 12, 13, 16, 18)),
                    );
                    if($item_data['enchant_id'])
                    {
                        $column = 'text_'.Yii::app()->language;
                        $info = Yii::app()->db
                            ->createCommand("
                                SELECT wow_enchantment.$column AS text, wow_spellenchantment.id AS spellId
                                FROM wow_enchantment
                                LEFT JOIN wow_spellenchantment ON wow_spellenchantment.Value = wow_enchantment.id
                                WHERE wow_enchantment.id = {$item_data['enchant_id']} LIMIT 1")
                            ->queryRow();
                        if(is_array($info))
                        {
                            $item_data['enchant_text'] = $info['text'];
                            if($info['spellId'])
                            {
                                $item = Yii::app()->db_world
                                    ->createCommand("
                                        SELECT entry, name
                                        FROM item_template
                                        WHERE 
                                        spellid_1 = {$info['spellId']} OR
                                        spellid_2 = {$info['spellId']} OR 
                                        spellid_3 = {$info['spellId']} OR
                                        spellid_4 = {$info['spellId']} OR 
                                        spellid_5 = {$info['spellId']} LIMIT 1")
                                    ->queryRow();
                                if($item)
                                {
                                    $item_data['enchant_text'] = $item['name'];
                                    $item_data['enchant_item'] = $item['entry'];
                                }
                            }
                        }
                    }
                    $data=array();
                    if($item_data['enchant_id'])
                        $data[] = "data[enchant_id]={$item_data['enchant_id']}";
                    
                    if($proto->itemset)
                    {
                        $set = Yii::app()->db_world
                            ->createCommand("SELECT entry FROM item_template WHERE itemset = {$proto->itemset}")
                            ->queryColumn();
                        $set_pieces = array();
                        for($k = 0; $k < 37; $k += 2)
                            if(in_array($this->equipmentCache[$k], $set))
                                $set_pieces[] = $this->equipmentCache[$k];
                        $data[] = 'data[set]='.implode(',', $set_pieces);
                    }
                    $item_data['data'] = implode('&', $data);
                    $this->_items[$j] = $item_data;
                }
                else
                    $this->_items[$j] = array('slot' => $item_slots[$j]);
            }
        
        return $this->_items;
    }

    public function getPowerType()
    {
        if(!$this->_power_type)
        {
            switch($this->class)
            {
                case self::CLASS_WARRIOR:
                    $this->_power_type = self::POWER_RAGE;
                    break;
                case self::CLASS_ROGUE:
                    $this->_power_type = self::POWER_ENERGY;
                    break;
                case self::CLASS_DK:
                    $this->_power_type = self::POWER_RUNIC_POWER;
                    break;
                /*
                case self::CLASS_HUNTER:
                    $this->_power_type = self::POWER_FOCUS;
                    break;
                */
                default:
                    $this->_power_type = self::POWER_MANA;
                    break;
            }
        }

        return $this->_power_type;
    }

    public function getPowerValue()
    {
        $power = $this->stats->{'maxpower'.($this->powerType+1)};
        if($this->class == self::CLASS_WARRIOR)
            $power /= 10;
        return $power;
    }

    public function getTalentData()
    {
        if(empty($this->_talents_data))
        {
            $spells = $this->dbConnection
                ->createCommand("SELECT spell FROM character_spell WHERE guid = {$this->guid} AND disabled = 0")
                ->queryColumn();
            $spells = implode(', ',$spells);
            if($spells)
                $tTalents = Yii::app()->db
                    ->createCommand("SELECT count(*) * 5 as c, tab FROM wow_talent WHERE rank5 IN ($spells) GROUP BY tab
                        UNION
                        SELECT count(*) * 4, tab FROM `wow_talent` WHERE rank4 IN ($spells) GROUP BY tab
                        UNION
                        SELECT count(*) * 3, tab FROM `wow_talent` WHERE rank3 IN ($spells) GROUP BY tab
                        UNION
                        SELECT count(*) * 2, tab FROM `wow_talent` WHERE rank2 IN ($spells) GROUP BY tab
                        UNION
                        SELECT count(*), tab  FROM `wow_talent` WHERE rank1 IN ($spells) GROUP BY tab")
                    ->queryAll();
            else
            {
                $this->_talents_data['treeOne'] = 0;
                $this->_talents_data['treeTwo'] = 0;
                $this->_talents_data['treeThree'] = 0;
                $this->_talents_data['name'] = 'No Talents';
                $this->_talents_data['icon'] = 'inv_misc_questionmark';
                return $this->_talents_data;
            }
            $talentTab = $this->getTalentTabForClass();
            $talents = array();
            foreach($talentTab as $tab)
                $talents[$tab] = 0;
            foreach($tTalents as $v)
                $talents[$v['tab']] += $v['c'];

            foreach($talentTab as $k => $v)
                if($v == $this->getMaxArray($talents))
                    $spec = $k;

            $this->_talents_data['treeOne'] = $talents[$talentTab[0]];
            $this->_talents_data['treeTwo'] = $talents[$talentTab[1]];
            $this->_talents_data['treeThree'] = $talents[$talentTab[2]];
            $this->_talents_data['name'] = $this->getTalentSpecNameFromDB($spec);
            $this->_talents_data['icon'] = $this->getTalentSpecIconFromDB($spec);

            if($this->_talents_data['treeOne'] == 0 && $this->_talents_data['treeTwo'] == 0 && $this->_talents_data['treeThree'] == 0)
            {
                // have no talents
                $this->_talents_data['icon'] = 'inv_misc_questionmark';
                $this->_talents_data['name'] = 'No Talents';
            }
        }

        return $this->_talents_data;
    }
    
    private function getTalentTabForClass()
    {
        $talentTabId = array(
            self::CLASS_WARRIOR => array(161, 164, 163),
            self::CLASS_PALADIN => array(382, 383, 381),
            self::CLASS_HUNTER  => array(361, 363, 362),
            self::CLASS_ROGUE   => array(182, 181, 183),
            self::CLASS_PRIEST  => array(201, 202, 203),
            self::CLASS_DK      => array(398, 399, 400),
            self::CLASS_SHAMAN  => array(261, 263, 262),
            self::CLASS_MAGE    => array( 81,  41,  61),
            self::CLASS_WARLOCK => array(302, 303, 301),
            self::CLASS_DRUID   => array(283, 281, 282)
        );
        
        $tab_class = $talentTabId[$this->class];
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
    
    public static function getTalentSpecRolesFromDB($spec)
    {
        return Yii::app()->db
            ->createCommand("SELECT tank, healer, dps FROM wow_talent_icons WHERE class = {$this->class} AND spec = $spec LIMIT 1")
            ->queryRow();
    }

    public function GetRole()
    {
        if($this->_role > 0)
            return $this->_role;
        
        switch($this->class)
        {
            case self::CLASS_WARRIOR:
                if($this->talentData['treeThree'] > $this->talentData['treeTwo'] && $this->talentData['treeThree'] > $this->talentData['treeOne'])
                    $this->_role = self::ROLE_TANK;
                else
                    $this->_role = self::ROLE_MELEE;
                break;
            case self::CLASS_ROGUE:
            case self::CLASS_DK:
                $this->_role = self::ROLE_MELEE;
                break;
            case self::CLASS_PALADIN:
            case self::CLASS_DRUID:
            case self::CLASS_SHAMAN:
                // Hybrid classes. Need to check active talent tree.
                if($this->talentData['treeOne'] > $this->talentData['treeTwo'] && $this->talentData['treeOne'] > $this->talentData['treeThree'])
                    if($this->class == self::CLASS_PALADIN)
                           $this->_role = self::ROLE_HEALER;
                    else
                        $this->_role = self::ROLE_CASTER;
                elseif($this->talentData['treeTwo'] > $this->talentData['treeOne'] && $this->talentData['treeTwo'] > $this->talentData['treeThree'])
                    if($this->class == self::CLASS_PALADIN)
                        $this->_role = self::ROLE_TANK;// Paladin: Protection
                    else 
                        $this->_role = self::ROLE_MELEE; //Druid: Feral, Shaman: Enhancemenet
                else
                    if($this->class == self::CLASS_PALADIN)
                        $this->_role = self::ROLE_MELEE;
                    else
                        $this->_role = self::ROLE_HEALER;
                break;
            case self::CLASS_PRIEST:
                if($this->talentData['treeThree'] > $this->talentData['treeOne'] && $this->talentData['treeThree'] > $this->talentData['treeTwo'])
                    $this->_role = self::ROLE_CASTER;
                else
                    $this->_role = self::ROLE_HEALER;
                break;
            case self::CLASS_MAGE:
            case self::CLASS_WARLOCK:
                $this->_role = self::ROLE_CASTER;
                break;
            case self::CLASS_HUNTER:
                $this->_role = self::ROLE_RANGED;
                break;
        }

        return $this->_role;
    }

    public function getProfessions()
    {
        if($this->_professions !== false)
            return $this->_professions;

        $skill_professions = array(
            self::SKILL_BLACKSMITHING,
            self::SKILL_LEATHERWORKING,
            self::SKILL_ALCHEMY,
            self::SKILL_HERBALISM,
            self::SKILL_MINING,
            self::SKILL_TAILORING,
            self::SKILL_ENGINERING,
            self::SKILL_ENCHANTING,
            self::SKILL_SKINNING,
            self::SKILL_JEWELCRAFTING,
            self::SKILL_INSCRIPTION
        );
        $skill_professions = implode(', ', $skill_professions);

        $professions = $this->dbConnection
            ->createCommand("SELECT * FROM character_skills WHERE guid = {$this->guid} AND skill IN ({$skill_professions}) LIMIT 2")
            ->queryAll();
        if(!is_array($professions))
            return false;

        $this->_professions = array();
        $i = 0;
        $column = 'name_'.Yii::app()->language;
        foreach($professions as $prof)
        {
            $this->_professions[$i] = Yii::app()->db
                ->createCommand("SELECT id, $column AS name, icon FROM wow_professions WHERE id = {$prof['skill']} LIMIT 1")
                ->queryRow();
            if(!$this->_professions[$i])
                continue;
            $this->_professions[$i]['value'] = $prof['value'];
            $this->_professions[$i]['max'] = 300;
            $i++;
        }

        return $this->_professions;
    }

    public function getMaxArray($arr)
    {
        foreach ($arr as $key => $val)
            if ($val == max($arr)) return $key;
    }
    
    public function getItemLevel()
    {
        if($this->_item_level)
            return $this->_item_level;

        $total_iLvl = 0;
        $maxLvl = 0;
        $minLvl = 500;
        $i = 0;
        $this->_item_level = array('avgEquipped' => 0, 'avg' => 0);
        foreach($this->items as $slot => $item)
        {
            if(!in_array($slot, array(self::EQUIPMENT_SLOT_BODY, self::EQUIPMENT_SLOT_TABARD)))
            {
                if(isset($item['item_level']))
                {
                    $total_iLvl += $item['item_level'];
                    if($item['item_level'] < $minLvl)
                        $minLvl = $item['item_level'];
                    if($item['item_level'] > $maxLvl)
                        $maxLvl = $item['item_level'];
                }
                $i++;
            }
        }
        if($i == 0) {
            // Prevent divison by zero.
            return $this->_item_level;
        }
        $this->_item_level['avgEquipped'] = round(($maxLvl + $minLvl) / 2);
        $this->_item_level['avg'] = round($total_iLvl / $i);
        return $this->_item_level;
    }
}
