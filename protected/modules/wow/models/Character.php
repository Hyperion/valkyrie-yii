<?php

class Character extends CModel
{
    public $guid = false;
    public $account = false;
    public $name = false;
    public $class = false;
    public $classText = false;
    public $race = false;
    public $raceText = false;
    public $gender = false;
    public $level = false;
    public $money = false;
    public $playerBytes = false;
    public $playerBytes2 = false;
    public $playerFlags = false;
    public $zone = false;
    public $map = false;
    public $location = false;
    
    //private $_chosenTitle = false;
    
    private $_health = false;
    
    private $_power1 = false;
    private $_power2 = false;
    private $_power3 = false;
 
    public $guildId = false;
    public $guildName = false;
    
    private $_equipmentCache = false;
    
    private $_realmName = false;
    private $_realmID = false;

    public $honor_standing = false;
    public $honor_rank_points = false;
    public $honor_highest_rank = false;
    public $hk = false;
    public $dk = false;
    public $thisWeek_cp = false;
    public $thisWeek_kills = false;

    public function attributeNames()
    {
        return array(
            'guid',
            'account',
            'name',
            'level',
            'class',
            'race',
            'gender',
            'money',
            'faction',
            'playerBytes',
            'playerBytes2',
            'zone',
            'map',
            'honor_standing',
            'honor_highest_rank',
            'honor_rank_points',
            'honorRank',
            'hk',
            'dk',
            'thisWeek_cp',
            'thisWeek_kills',
            'guildId',
            'guildName',
        );
    }

    public function rules()
    {
        return array(
            array('guid, account, level, class, race, gender, money, faction, playerBytes, playerBytes2, zone, map, hk, dk, honorRank, honor_standing, honor_highest_rank, honor_rank_points,thisWeek_cp, thisWeek_kills, guildId', 'numerical', 'integerOnly'=>true),
            array('name, guildName', 'length', 'max'=>12),
            array('name', 'UniqueNameValidator', 'on'=>'update'),
            array('name', 'safe', 'on'=>'search'),
            array('name, level, class, race, zone, map', 'safe', 'on'=>'online'),
            array('name, level, class, race, faction, honor_standing, honor_highest_rank, honor_rank_points', 'safe', 'on'=>'pvp'),
        );
    }

    public function getPrimaryKey()
    {
      return $this->guid;
    }

    public function getFaction()
    {
        switch($this->race)
        {
            case 1: case 3: case 4: case 7: return 0;
            case 2: case 5: case 6: case 8: return 1;
        }
    }

    public function setFaction()
    {
        return $this;
    }

    public function setHonorRank()
    {
        return $this;
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
}