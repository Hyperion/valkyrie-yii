<?php

class CharacterStats extends CActiveRecord
{
	private $_levelStats = array();

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
        return 'character_stats';
    }

    public function relations()
    {
        return array(
            'character' => array(self::BELONGS_TO, 'Character', 'guid'),
        );
    }

	public function getLevelStats()
	{
		if(!$this->_levelStats)
			$this->_levelStats = Yii::app()->db_world->createCommand("
				SELECT str AS strength, agi AS agility, sta AS stamina, inte AS intellect, spi AS spirit 
				FROM player_levelstats 
                WHERE race = {$this->character->race} 
                    AND class = {$this->character->class} 
                    AND level = {$this->character->level}
                LIMIT 1")->queryRow();
        return $this->_levelStats;
    }
    
    public function getMainDps()
    {
        return round(($this->mainMinDmg + $this->mainMaxDmg) / 2 / $this->mainAttSpeed, 1);
    }
    
    public function getOffDps()
    {
        return round(($this->offMinDmg + $this->offMaxDmg) / 2 / $this->offAttSpeed, 1);
    }

    public function getRangedDps()
    {
        return round(($this->rangeMinDmg + $this->rangeMaxDmg) / 2 / $this->rangeAttSpeed, 1);
    }
    
    public function getHealthBonusFromStamina()
    {
        $baseStam = ($this->stamina < 20) ? $this->stamina : 20;
        return $this->stamina * 10 - $baseStam * 9;
    }

    public function getManaBonusFromIntellect()
    {
        $baseInt = ($this->intellect < 20) ? $this->intellect : 20;
        return $this->intellect * 15 - $baseInt * 14;
    }
    
    public function getManaPerFiveSeconds()
    {
        $Spirit = $this->spirit;

        switch ($this->character->class)
        {
            case Character::CLASS_DRUID:   $value = ($Spirit / 5 + 15);   break;
            case Character::CLASS_HUNTER:  $value = ($Spirit / 5 + 15);   break;
            case Character::CLASS_MAGE:    $value = ($Spirit / 4 + 12.5); break;
            case Character::CLASS_PALADIN: $value = ($Spirit / 5 + 15);   break;
            case Character::CLASS_PRIEST:  $value = ($Spirit / 4 + 12.5); break;
            case Character::CLASS_SHAMAN:  $value = ($Spirit / 5 + 17);   break;
            case Character::CLASS_WARLOCK: $value = ($Spirit / 5 + 15);   break;
        }

        return $value / 2 * 5;
    }
    
    public function getSpellCritFromIntellect()
    {
        $crit_data = array(array( 0.0,   0.0,  10.0 ),      //  0: unused
                           array( 0.0,   0.0,  10.0 ),      //  1: warrior
                           array( 3.70, 14.77, 0.65 ),      //  2: paladin
                           array( 0.0,   0.0,  10.0 ),      //  3: hunter
                           array( 0.0,   0.0,  10.0 ),      //  4: rogue
                           array( 2.97, 10.03, 0.82 ),      //  5: priest
                           array( 0.0,   0.0, 10.0  ),      //  6: unused
                           array( 3.54, 11.51, 0.80 ),      //  7: shaman
                           array( 3.70, 14.77, 0.65 ),      //  8: mage
                           array( 3.18, 11.30, 0.82 ),      //  9: warlock
                           array( 0.0,   0.0,  10.0 ),      // 10: unused
                           array( 3.33, 12.41, 0.79 ));     // 11: druid

        $my_class = $this->character->class;
        $crit_ratio = $crit_data[$my_class][1] + $crit_data[$my_class][2] * $this->character->level;
        $crit_chance = $crit_data[$my_class][0] + $this->intellect / $crit_ratio;

        return $crit_chance > 0.0 ? $crit_chance : 0.0;
    }

    public function getMeleeCritFromAgility()
    {
        $level = $this->character->level;

        if ($level > 60)
            $level = 60;

        switch($this->character->class)
        {
            case Character::CLASS_ROGUE:    $classrate = 29 - ((60 - $level) * 0.4);  break;
            case Character::CLASS_HUNTER:   $classrate = 53 - ((60 - $level) * 0.7);  break;
            default:                        $classrate = 20 - ((60 - $level) * 0.25); break;
        }

        return $this->agility / $classrate;
    }
    
    public function getMeleeAPFromStrength()
    {
        $level = $this->character->level;
        $str = $this->strength;
        $agi = $this->agility;

        switch($this->character->class)
        {
            case Character::CLASS_WARRIOR:  $value = $level * 3.0 + $str * 2.0 - 20.0; break;
            case Character::CLASS_PALADIN:  $value = $level * 3.0 + $str * 2.0 - 20.0; break;
            case Character::CLASS_ROGUE:    $value = $level * 2.0 + $str + $agi - 20.0; break;
            case Character::CLASS_HUNTER:   $value = $level * 2.0 + $str + $agi - 20.0; break;
            case Character::CLASS_SHAMAN:   $value = $level * 2.0 + $str * 2.0 - 20.0; break;
            case Character::CLASS_DRUID:    $value = $str * 2.0 - 20.0; break;
            case Character::CLASS_MAGE:     $value = $str - 10.0; break;
            case Character::CLASS_PRIEST:   $value = $str - 10.0; break;
            case Character::CLASS_WARLOCK:  $value = $str - 10.0; break;
            default: $value = 0.0; break;
        }

        return $value;
    }
}
