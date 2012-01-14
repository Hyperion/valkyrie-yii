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
    const CLASS_HUNTER = 3;
    const CLASS_ROGUE = 4;
    const CLASS_PRIEST = 5;
    const CLASS_DK = 6;
    const CLASS_SHAMAN = 7;
    const CLASS_MAGE = 8;
    const CLASS_WARLOCK = 9;
    const CLASS_DRUID = 11;
    const MAX_CLASSES = 12;

    const RACE_HUMAN = 1;
    const RACE_ORC = 2;
    const RACE_DWARF = 3;
    const RACE_NIGHTELF = 4;
    const RACE_UNDEAD = 5;
    const RACE_TAUREN = 6;
    const RACE_GNOME = 7;
    const RACE_TROLL = 9;

    const FACTION_ALLIANCE = 1;
    const FACTION_HORDE = 2;

    const POWER_HEALTH = 0xFFFFFFFE;
    const POWER_MANA = 0;
    const POWER_RAGE = 1;
    const POWER_FOCUS = 2;
    const POWER_ENERGY = 3;
    const POWER_HAPPINESS = 4;
    const POWER_RUNE = 5;
    const POWER_RUNIC_POWER = 6;
    const MAX_POWERS = 7;

    const ROLE_MELEE = 1;
    const ROLE_RANGED = 2;
    const ROLE_CASTER = 3;
    const ROLE_HEALER = 4;
    const ROLE_TANK = 5;

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
    public $faction;
    private $_items = array();
    private $_spells = array();
    private $_talents = array();
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
            array('account, name, guid, level, class, race', 'safe', 'on' => 'search'),
            array('account, level, class, race, faction, honor_standing', 'numerical', 'integerOnly' => true),
            array('name, level, class, race, honor_standing, faction', 'safe', 'on' => 'pvp, pvp_current'),
            array('account, name, race, class, gender, level, money, playerBytes, playerBytes2', 'safe', 'on' => 'update'),
        );
    }

    public function relations()
    {
        return array(
            'honor' => array(self::HAS_ONE, 'CharacterHonorStatic', 'guid'),
            'stats' => array(self::HAS_ONE, 'CharacterStats', 'guid'),
            'reputation' => array(
                self::HAS_MANY,
                'CharacterReputation',
                'guid',
                'condition' => '`reputation`.`flags` & ' . CharacterReputation::FACTION_FLAG_VISIBLE,
                'index' => 'faction',
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'honor_highest_rank' => 'Max Rank',
            'honor_standing' => 'Standing',
            'honor_rank_points' => 'RP',
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'classes' => array(
                self::CLASS_WARRIOR => Yii::t('WowModule.character', 'Warrior'),
                self::CLASS_PALADIN => Yii::t('WowModule.character', 'Paladin'),
                self::CLASS_HUNTER => Yii::t('WowModule.character', 'Hunter'),
                self::CLASS_ROGUE => Yii::t('WowModule.character', 'Rogue'),
                self::CLASS_PRIEST => Yii::t('WowModule.character', 'Priest'),
                self::CLASS_SHAMAN => Yii::t('WowModule.character', 'Shaman'),
                self::CLASS_MAGE => Yii::t('WowModule.character', 'Mage'),
                self::CLASS_WARLOCK => Yii::t('WowModule.character', 'Warlock'),
                self::CLASS_DRUID => Yii::t('WowModule.character', 'Druid'),
            ),
            'races' => array(
                self::RACE_HUMAN => Yii::t('WowModule.character', 'Human'),
                self::RACE_ORC => Yii::t('WowModule.character', 'Orc'),
                self::RACE_DWARF => Yii::t('WowModule.character', 'Dwarf'),
                self::RACE_NIGHTELF => Yii::t('WowModule.character', 'Night Elf'),
                self::RACE_UNDEAD => Yii::t('WowModule.character', 'Undead'),
                self::RACE_TAUREN => Yii::t('WowModule.character', 'Tauren'),
                self::RACE_GNOME => Yii::t('WowModule.character', 'Gnome'),
                self::RACE_TROLL => Yii::t('WowModule.character', 'Troll'),
            ),
            'genders' => array(
                0 => 'male',
                1 => 'female',
            ),
            'powers' => array(
                self::POWER_MANA => 'Mana',
                self::POWER_RAGE => 'Rage',
                self::POWER_ENERGY => 'Energy',
            ),
            'factions' => array(
                self::FACTION_ALLIANCE => Yii::t('WowModule.character', 'Alliance'),
                self::FACTION_HORDE => Yii::t('WowModule.character', 'Horde'),
            ),
        );

        if(isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public function search($all_realms = false)
    {
        $criteria = new CDbCriteria;
        $sort = new CSort;

        $criteria->compare('guid', $this->guid);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('race', $this->race);
        $criteria->compare('account', $this->account);
        $criteria->compare('class', $this->class);
        $criteria->compare('level', $this->level);
        $criteria->compare('online', $this->online);
        $criteria->compare('honor_standing', $this->honor_standing);
        $criteria->compare('account', '>0');

        if($this->scenario == 'pvp' or $this->scenario == 'pvp_current')
        {
            $criteria->with = 'honor';
            if($this->scenario == 'pvp')
                $criteria->compare('honor_standing', '>0');
            else
                $criteria->compare('honor.thisWeek_kills', '>25');

            $sort->attributes = array(
                'name' => 'name',
                'honor.hk' => 'honor.hk',
                'level' => 'level',
                'race' => 'race',
                'class' => 'class',
                'honor_standing' => 'honor_standing',
                'honor_highest_rank' => 'honor_highest_rank',
                'honor_rank_points' => 'honor_rank_points',
                'honor.thisWeek_cp' => 'honor.thisWeek_cp',
                'honor.thisWeek_kills' => 'honor.thisWeek_kills',
            );
            $sort->defaultOrder = 'honor_standing ASC';
        }

        switch($this->faction)
        {
            case self::FACTION_ALLIANCE:
                $criteria->compare('race', array(
                    self::RACE_HUMAN,
                    self::RACE_DWARF,
                    self::RACE_NIGHTELF,
                    self::RACE_GNOME
                ));
                break;
            case self::FACTION_HORDE:
                $criteria->compare('race', array(
                    self::RACE_ORC,
                    self::RACE_UNDEAD,
                    self::RACE_TAUREN,
                    self::RACE_TROLL
                ));
                break;
            default : break;
        }

        return new CMultirealmDataProvider(get_class($this), array(
                    'all_realms' => $all_realms,
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 40,
                    ),
                    'sort' => $sort,
                ));
    }

    public function getHonorRank()
    {
        $rank = 0;
        if($this->honor_rank_points <= -2000.0)
            $rank = 1;       // Pariah (-4)
        else if($this->honor_rank_points <= -1000.0)
            $rank = 2;  // Outlaw (-3)
        else if($this->honor_rank_points <= -500.0)
            $rank = 3;   // Exiled (-2)
        else if($this->honor_rank_points < 0.0)
            $rank = 4;       // Dishonored (-1)
        else if($this->honor_rank_points == 0)
            $rank = 0;
        else if($this->honor_rank_points < 2000.00)
            $rank = 5;
        else if($this->honor_rank_points > (13) * 5000)
            $rank = 21;
        else
            $rank = 6 + (int) ($this->honor_rank_points / 5000);

        return $rank;
    }

    public function getHonorBar()
    {
        $bar['percent'] = 0;
        $bar['cap'] = 0;
        if($this->honor_rank_points <= -2000.0)
            $bar['cap'] = -2000;
        else if($this->honor_rank_points <= -1000.0)
        {
            $bar['percent'] = round((2000 + $this->honor_rank_points) / 10);
            $bar['cap'] = -1000;
        }
        else if($this->honor_rank_points <= -500.0)
        {
            $bar['percent'] = round((1000 + $this->honor_rank_points) / 5);
            $bar['cap'] = -500;
        }
        else if($this->honor_rank_points < 0.0)
            $bar['percent'] = round((500 + $this->honor_rank_points) / 5);
        else if($this->honor_rank_points < 2000.00)
        {
            $bar['percent'] = round($this->honor_rank_points / 20);
            $bar['cap'] = 2000;
        }
        else if($this->honor_rank_points > (13) * 5000)
        {
            $bar['percent'] = 100;
            $bar['cap'] = 65000;
        }
        else
        {
            $bar['percent'] = round(($this->honor_rank_points % 5000) / 50);
            $bar['cap'] = floor($this->honor_rank_points / 5000) * 5000 + 5000;
        }

        return $bar;
    }

    public function loadAdditionalData()
    {
        $column = 'name_' . Yii::app()->language;
        $connection = Yii::app()->db;
        $command = $connection->createCommand()
                ->select("r.$column AS race, c.$column AS class")
                ->from('wow_races r, wow_classes c')
                ->where('r.id = ? AND c.id = ?', array($this->race, $this->class))
                ->limit(1);
        $row = $command->queryRow();
        $this->race_text = $row['race'];
        $this->class_text = $row['class'];

        $this->_spells = $this->dbConnection
                ->createCommand("SELECT spell FROM character_spell WHERE guid = {$this->guid} AND disabled = 0")
                ->queryColumn();
    }

    protected function afterFind()
    {
        parent::afterFind();
        $this->realm = Database::$realm;
        $this->equipmentCache = explode(' ', $this->equipmentCache);

        switch($this->race)
        {
            case self::RACE_HUMAN:
            case self::RACE_DWARF:
            case self::RACE_NIGHTELF:
            case self::RACE_GNOME: 
                $this->faction = self::FACTION_ALLIANCE;
                break;
            default :
                $this->faction = self::FACTION_HORDE;
                break;
        }
    }

    public function getItems()
    {
        $item_slots = array(
            self::EQUIPMENT_SLOT_HEAD => 1,
            self::EQUIPMENT_SLOT_NECK => 2,
            self::EQUIPMENT_SLOT_SHOULDERS => 3,
            self::EQUIPMENT_SLOT_BACK => 16,
            self::EQUIPMENT_SLOT_CHEST => 5,
            self::EQUIPMENT_SLOT_BODY => 4,
            self::EQUIPMENT_SLOT_TABARD => 19,
            self::EQUIPMENT_SLOT_WRISTS => 9,
            self::EQUIPMENT_SLOT_HANDS => 10,
            self::EQUIPMENT_SLOT_WAIST => 6,
            self::EQUIPMENT_SLOT_LEGS => 7,
            self::EQUIPMENT_SLOT_FEET => 8,
            self::EQUIPMENT_SLOT_FINGER1 => 11,
            self::EQUIPMENT_SLOT_FINGER2 => 11,
            self::EQUIPMENT_SLOT_TRINKET1 => 12,
            self::EQUIPMENT_SLOT_TRINKET2 => 12,
            self::EQUIPMENT_SLOT_MAINHAND => 21,
            self::EQUIPMENT_SLOT_OFFHAND => 22,
            self::EQUIPMENT_SLOT_RANGED => 28,
        );

        if(!$this->_items)
            for($i = 0, $j = 0; $i < 37; $i += 2, $j++)
            {
                $proto = ItemTemplate::model()->findByPk($this->equipmentCache[$i]);
                if($proto)
                {
                    $item_data = array(
                        'entry' => $proto->entry,
                        'icon' => $proto->icon,
                        'name' => $proto->name,
                        'display_id' => $proto->displayid,
                        'quality' => $proto->Quality,
                        'item_level' => $proto->ItemLevel,
                        'class' => $proto->class,
                        'enchant_id' => $this->equipmentCache[$i + 1],
                        'enchant_item' => 0,
                        'enchant_text' => '',
                        'slot' => $proto->InventoryType,
                        'can_displayed' => !in_array($proto->InventoryType, array(2, 11, 12)),
                        'can_enchanted' => !in_array($j, array(3, 17, 1, 5, 10, 11, 12, 13, 16, 18)),
                    );
                    if($item_data['enchant_id'])
                    {
                        $column = 'text_' . Yii::app()->language;
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
                    $data = array();
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
                        $data[] = 'data[set]=' . implode(',', $set_pieces);
                    }
                    $item_data['data'] = implode('&', $data);
                    $this->_items[$j] = $item_data;
                }
                else
                    $this->_items[$j] = array('slot' => $item_slots[$j]);
            }

        return $this->_items;
    }

    public function isEquipped($entry)
    {
        for($i = 0; $i < 37; $i += 2)
            if($entry == $this->equipmentCache[$i])
                return true;
        return false;
    }

    public function isOffhandWeapon()
    {
        return(isset($this->items[self::EQUIPMENT_SLOT_OFFHAND]['class']) && $this->items[self::EQUIPMENT_SLOT_OFFHAND]['class'] == ItemTemplate::ITEM_CLASS_WEAPON);
    }

    public function isRangedWeapon()
    {
        return(
                isset($this->items[self::EQUIPMENT_SLOT_RANGED]['class']) &&
                $this->items[self::EQUIPMENT_SLOT_RANGED]['class'] == ItemTemplate::ITEM_CLASS_WEAPON);
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
        $power = $this->stats->{'maxpower' . ($this->powerType + 1)};
        if($this->class == self::CLASS_WARRIOR)
            $power /= 10;
        return $power;
    }

    public function getTalents()
    {
        if(empty($this->_talents))
        {
            $talentHandler = new WowTalents($this->class);


            $this->_talents = $talentHandler->talentTrees;

            $build = null;

            foreach($this->_talents as $i => $tree)
            {
                $this->_talents[$i]['count'] = 0;
                foreach($tree['talents'] as $k => $tal)
                {
                    $checked = false;
                    $points = 0;
                    if($tal['keyAbility'])
                    {
                        $tSpell = Spell::model()->findByPk($tal['ranks'][0]['id']);
                        $name = $tSpell->spellname_loc0;
                        $spellRanks = Yii::app()->db->createCommand(
                                        "SELECT spellID
                                FROM wow_spells
                                WHERE spellicon = {$tSpell->spellicon} AND
                                    spellname_loc0 = :name")
                                ->bindParam(':name', $name)
                                ->queryColumn();

                        foreach($spellRanks as $spell)
                            if(in_array($spell, $this->_spells))
                            {
                                $checked = true;
                                $build .= 1;
                                $points = 1;
                                $this->_talents[$i]['count']++;
                                break;
                            }
                    }
                    else
                    {
                        foreach($tal['ranks'] as $j => $spell)
                            if(in_array($spell['id'], $this->_spells))
                            {
                                $checked = true;
                                $build .= $j + 1;
                                $points = $j + 1;
                                $this->_talents[$i]['count'] += $j + 1;
                                break;
                            }
                    }

                    if(!$checked)
                        $build .= 0;

                    $this->_talents[$i]['talents'][$k]['points'] = $points;
                }
            }

            $this->_talents['build'] = $build;

            $this->_talents['maxTreeNo'] = 0;
            for($i = 0; $i < 3; $i++)
                if($this->_talents[$i]['count'] > $this->_talents[$this->_talents['maxTreeNo']]['count'])
                    $this->_talents['maxTreeNo'] = $i;

            $this->_talents['name'] = $this->_talents[$this->_talents['maxTreeNo']]['name'];
            $this->_talents['icon'] = $this->_talents[$this->_talents['maxTreeNo']]['icon'];

            if($this->_talents[0]['count'] == 0 && $this->_talents[1]['count'] == 0 && $this->_talents[2]['count'] == 0)
            {
                // have no talents
                $this->_talents['maxTreeNo'] = -1;
                $this->_talents['icon'] = 'inv_misc_questionmark';
                $this->_talents['name'] = 'No Talents';
            }
        }

        return $this->_talents;
    }

    public function getRole()
    {
        if($this->_role > 0)
            return $this->_role;

        switch($this->class)
        {
            case self::CLASS_WARRIOR:
                if($this->talents[2]['count'] > $this->talents[1]['count'] && $this->talents[2]['count'] > $this->talents[0]['count'])
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
                if($this->talents[0]['count'] > $this->talents[1]['count'] && $this->talents[0]['count'] > $this->talents[2]['count'])
                    if($this->class == self::CLASS_PALADIN)
                        $this->_role = self::ROLE_HEALER;
                    else
                        $this->_role = self::ROLE_CASTER;
                elseif($this->talents[1]['count'] > $this->talents[0]['count'] && $this->talents[1]['count'] > $this->talents[2]['count'])
                    if($this->class == self::CLASS_PALADIN)
                        $this->_role = self::ROLE_TANK; // Paladin: Protection
                    else
                        $this->_role = self::ROLE_MELEE; //Druid: Feral, Shaman: Enhancemenet
                        else
                if($this->class == self::CLASS_PALADIN)
                    $this->_role = self::ROLE_MELEE;
                else
                    $this->_role = self::ROLE_HEALER;
                break;
            case self::CLASS_PRIEST:
                if($this->talents[2]['count'] > $this->talents[0]['count'] && $this->talents[2]['count'] > $this->talents[1]['count'])
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
        $column = 'name_' . Yii::app()->language;
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
        if($i == 0)
        {
            // Prevent divison by zero.
            return $this->_item_level;
        }
        $this->_item_level['avgEquipped'] = round(($maxLvl + $minLvl) / 2);
        $this->_item_level['avg'] = round($total_iLvl / $i);
        return $this->_item_level;
    }

    public function getFeed($count)
    {
        $feed = array();

        $feed = $this->dbConnection
                ->createCommand("SELECT * FROM character_feed_log WHERE guid = {$this->guid} ORDER BY date DESC LIMIT {$count}")
                ->queryAll();

        for($i = 0; $i < count($feed); $i++)
            switch($feed[$i]['type'])
            {
                case 2:
                    $feed[$i]['item'] = ItemTemplate::model()->findByPk($feed[$i]['data']);
                    $feed[$i]['equipped'] = $this->isEquipped($feed[$i]['data']);
                    break;
                case 3:
                    $feed[$i]['count'] = $this->dbConnection
                            ->createCommand("SELECT COUNT(1)
                            FROM character_feed_log
                            WHERE
                                guid = {$this->guid}
                                AND type = 3
                                AND data = {$feed[$i]['data']}
                                AND date <= {$feed[$i]['date']}")
                            ->queryScalar();
                    $feed[$i]['data'] = CreatureTemplate::model()->findByPk($feed[$i]['data']);
                    break;
            }

        return $feed;
    }

    public function getFactions()
    {
        $_factions = array();
        foreach($this->reputation as $id => $data)
            $_factions[] = $id;

        $_factions = implode(', ', $_factions);

        $column = 'name_' . Yii::app()->language;
        $factions = Yii::app()->db
                ->createCommand("SELECT `id`, `category`, $column AS `name`, `baseValue`
                    FROM `wow_factions` WHERE `id` IN ($_factions)
                    ORDER BY `id` DESC")
                ->queryAll();

        // Default categories
        $categories = array(
            // World of Warcraft (Classic)
            1118 => array(
                // Horde
                67 => array(
                    'order' => 1,
                    'side' => CharacterReputation::FACTION_HORDE
                ),
                // Horde Forces
                892 => array(
                    'order' => 2,
                    'side' => CharacterReputation::FACTION_HORDE
                ),
                // Alliance
                469 => array(
                    'order' => 1,
                    'side' => CharacterReputation::FACTION_ALLIANCE
                ),
                // Alliance Forces
                891 => array(
                    'order' => 2,
                    'side' => CharacterReputation::FACTION_ALLIANCE
                ),
                // Steamwheedle Cartel
                169 => array(
                    'order' => 3,
                    'side' => -1
                )
            ),
            // Other
            0 => array(
                // Wintersaber trainers
                589 => array(
                    'order' => 1,
                    'side' => CharacterReputation::FACTION_ALLIANCE
                ),
                // Syndicat
                70 => array(
                    'order' => 2,
                    'side' => -1
                )
            )
        );
        $storage = array();
        $i = 0;
        foreach($factions as $faction)
        {
            // Standing & adjusted values
            $standing = min(42999, $this->reputation[$faction['id']]['standing'] + $faction['baseValue']);
            $type = CharacterReputation::REP_EXALTED;
            $rep_cap = 999;
            $rep_adjusted = $standing - 42000;
            if($standing < CharacterReputation::REPUTATION_VALUE_HATED)
            {
                $type = CharacterReputation::REP_HATED;
                $rep_cap = 36000;
                $rep_adjusted = $standing + 42000;
            }
            elseif($standing < CharacterReputation::REPUTATION_VALUE_HOSTILE)
            {
                $type = CharacterReputation::REP_HOSTILE;
                $rep_cap = 3000;
                $rep_adjusted = $standing + 6000;
            }
            elseif($standing < CharacterReputation::REPUTATION_VALUE_UNFRIENDLY)
            {
                $type = CharacterReputation::REP_UNFRIENDLY;
                $rep_cap = 3000;
                $rep_adjusted = $standing + 3000;
            }
            elseif($standing < CharacterReputation::REPUTATION_VALUE_NEUTRAL)
            {
                $type = CharacterReputation::REP_NEUTRAL;
                $rep_cap = 3000;
                $rep_adjusted = $standing;
            }
            elseif($standing < CharacterReputation::REPUTATION_VALUE_FRIENDLY)
            {
                $type = CharacterReputation::REP_FRIENDLY;
                $rep_cap = 6000;
                $rep_adjusted = $standing - 3000;
            }
            elseif($standing < CharacterReputation::REPUTATION_VALUE_HONORED)
            {
                $type = CharacterReputation::REP_HONORED;
                $rep_cap = 12000;
                $rep_adjusted = $standing - 9000;
            }
            elseif($standing < CharacterReputation::REPUTATION_VALUE_REVERED)
            {
                $type = CharacterReputation::REP_REVERED;
                $rep_cap = 21000;
                $rep_adjusted = $standing - 21000;
            }
            $faction['standing'] = $this->reputation[$faction['id']]['standing'];
            $faction['type'] = $type;
            $faction['cap'] = $rep_cap;
            $faction['adjusted'] = $rep_adjusted;
            $faction['percent'] = round($rep_adjusted * 100 / $rep_cap);

            if(isset($categories[$faction['category']])
                    and $faction['id'] != 67
                    and $faction['id'] != 469)
            {
                if(!isset($storage[$faction['category']]))
                    $storage[$faction['category']] = array();
                $storage[$faction['category']][$i++] = $faction;
            }

            else
            {
                foreach($categories as $catId => $subcat)
                {
                    if(isset($categories[$catId][$faction['category']]))
                        if($subcat[$faction['category']]['side'] == -1
                                or $subcat[$faction['category']]['side'] == $this->faction)
                        {
                            if(!isset($categories[$catId][$faction['category']]))
                                $categories[$catId][$faction['category']] = array();
                            $storage[$catId][$faction['category']][] = $faction;
                        }
                }
            }
        }
        ksort($storage[1118]);
        return $storage;
    }

    public function getTitle($rank)
    {
        switch($rank)
        {
            case 1: $title = 'Pariah';
                break;
            case 2: $title = 'Outlaw';
                break;
            case 3: $title = 'Exiled';
                break;
            case 4: $title = 'Dishonored';
                break;
            default: $title = 'None';
                break;
        }

        $rank = $rank - 4;
        if($rank < 1)
            return $title;

        $column = 'title_';
        if($this->gender == 0)
            $column .= 'M_';
        else
            $column .= 'F_';
        $column .= Yii::app()->language;

        $id = 14 * $this->faction + $rank;
        return Yii::app()->db
                        ->createCommand("SELECT $column
                    FROM `wow_titles` WHERE `id` = $id")
                        ->queryScalar();
    }

}
