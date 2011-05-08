<?php

class CCharactersDataProvider extends CModelDataProvider
{

    public $all = false;
    public $lang;    
    
	protected function fetchData()
	{
        $characters = array();
        
        if($this->all)
        {
            $db = new WowDatabase;
            $realmInfo = $db->realmInfo;
            $characters = array();
            $data = array();
            
            foreach($realmInfo as $server => $data)
            {
                if($server != 'realmlist')
                {
                    WowDatabase::$name = $server;
                    $this->db = $db->getDb();
                    $data = array_merge($data, parent::fetchData());
                }
            }
        } else
            $data = parent::fetchData();
		return $data;
	}
 
    protected function handleModel($char)
    {
        $column = 'name_'.$this->lang;
        $sql = "SELECT
            {{wow_classes}}.`$column` AS class,
            {{wow_races}}.`$column` AS race
            FROM {{wow_classes}}, {{wow_races}}
            WHERE {{wow_classes}}.`id` =:class_id AND {{wow_races}}.`id` =:race_id LIMIT 1";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":class_id", $char->class);
        $command->bindParam(":race_id", $char->race);
        $row = $command->queryRow();
                        
        $char->classText = $row['class'];
        $char->raceText  = $row['race'];
        
        $char->realm = WowDatabase::$name;
        $char->location = $this->getLocation($char->map, $char->zone);
        return $char;
    }
    
    private function getLocation($map, $zone)
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
        $location = ($map == 0 or $map == 1) ? $zones[$zone] : $maps[$map];
        return $location;
    }
}
