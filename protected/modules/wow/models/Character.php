<?php

class Character extends CModel
{
    public $guid = false;
    public $account = false;
    public $name = false;
    public $class = false;
    public $race = false; 
    public $gender = false;
    public $level = false;
    public $money = false;
    public $playerBytes = false;
    public $playerBytes2 = false;
    public $playerFlags = false;
    public $zone = false;
    public $map = false; 
    
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
    
    public function getRaceText()
    {
        switch($this->race)
        {
            case 1: $raceText = 'Human'; break;
            case 2: $raceText = 'Orc'; break;
            case 3: $raceText = 'Dwarf'; break;
            case 4: $raceText = 'Night Elf'; break;
            case 5: $raceText = 'Undead'; break;
            case 6: $raceText = 'Tauren'; break;
            case 7: $raceText = 'Gnome'; break;
            case 8: $raceText = 'Troll'; break;
            default: $raceText = 'Unknown'; break;
        }
        return $raceText;
    }

    public function getClassText()
    {
        switch($this->class)
        {
            case 1: $classText = 'Warrior'; break;
            case 2: $classText = 'Paladin'; break;
            case 3: $classText = 'Hunter'; break;
            case 4: $classText = 'Rogue'; break;
            case 5: $classText = 'Priest'; break;
            case 7: $classText = 'Shaman'; break;
            case 8: $classText = 'Mage'; break;
            case 9: $classText = 'Warlock'; break;
            case 11: $classText = 'Druid'; break;
            default: $classText = 'Unknown'; break;
        }
        return $classText;
    }

    public function getLocation()
    {
        $maps = array(
            '0'=>"Azeroth",
            '1'=>"Kalimdor",
            '13'=>"Testing",
            '25'=>"Scott Test",
            '29'=>"CashTest",
            '30'=>"Alterac Valley",
            '33'=>"Shadowfang Keep",
            '34'=>"Stormwind Stockade",
            '35'=>"<unused>StormwindPrison",
            '36'=>"Deadmines",
            '37'=>"Azshara Crater",
            '42'=>"Collin's Test",
            '43'=>"Wailing Caverns",
            '44'=>"<unused> Monastery",
            '47'=>"Razorfen Kraul",
            '48'=>"Blackfathom Deeps",
            '70'=>"Uldaman",
            '90'=>"Gnomeregan",
            '109'=>"Sunken Temple",
            '129'=>"Razorfen Downs",
            '169'=>"Emerald Dream",
            '189'=>"Scarlet Monastery",
            '209'=>"Zul'Farrak",
            '229'=>"Blackrock Spire",
            '230'=>"Blackrock Depths",
            '249'=>"Onyxia's Lair",
            '269'=>"Opening of the Dark Portal",
            '289'=>"Scholomance",
            '309'=>"Zul'Gurub",
            '329'=>"Stratholme",
            '349'=>"Maraudon",
            '369'=>"Deeprun Tram",
            '389'=>"Ragefire Chasm",
            '409'=>"Molten Core",
            '429'=>"Dire Maul",
            '449'=>"Alliance PVP Barracks",
            '450'=>"Horde PVP Barracks",
            '451'=>"Development Land",
            '469'=>"Blackwing Lair",
            '489'=>"Warsong Gulch",
            '509'=>"Ruins of Ahn'Qiraj",
            '529'=>"Arathi Basin",
            '531'=>"Ahn'Qiraj Temple",
            '533'=>"Naxxramas",
            '534'=>"The Battle for Mount Hyjal",
            '572'=>"Ruins of Lordaeron");
        $zones = array(
            '1497' => "Undercity",
            '1537' => "Ironforge",
            '1519' => "Stormwind City",
            '3' => "Badlands",
            '11' => "Wetlands",
            '33' => "Stranglethorn Vale",
            '44' => "Redridge Mountains",
            '38' => "Loch Modan",
            '10' => "Duskwood",
            '41' => "Deadwind Pass",
            '12' => "Elwynn Forest",
            '46' => "Burning Steppes",
            '51' => "Searing Gorge",
            '1' => "Dun Morogh",
            '47' => "The Hinterlands",
            '40' => "Westfall",
            '267' => "Hillsbrad Foothills",
            '139' => "Eastern Plaguelands",
            '28' => "Western Plaguelands",
            '130' => "Silverpine Forest",
            '85' => "Tirisfal Glades",
            '4' => "Blasted Lands",
            '8' => "Swamp of Sorrows",
            '45' => "Arathi Highlands",
            '36' => "Alterac Mountains",
            '1657' => "Darnassus",
            '1638' => "Thunder Bluff",
            '1637' => "Orgrimmar",
            '493' => "Moonglade",
            '1377' => "Silithus",
            '618' => "Winterspring",
            '490' => "Un'Goro Crater",
            '361' => "Felwood",
            '16' => "Azshara",
            '440' => "Tanaris",
            '15' => "Dustwallow Marsh",
            '215' => "Mulgore",
            '357' => "Feralas",
            '405' => "Desolace",
            '400' => "Thousand Needles",
            '14' => "Durotar",
            '331' => "Ashenvale",
            '148' => "Darkshore",
            '141' => "Teldrassil",
            '406' => "Stonetalon Mountains",
            '17' => "The Barrens",
            '25' => "WTF?");
        $location = ($this->map == 0 or $this->map == 1) ? $zones[$this->zone] : $maps[$this->map];
        return $location;
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