<?php

class ItemTemplate extends CActiveRecord
{
	const MAX_ITEM_PROTO_STATS = 10;
	const MAX_ITEM_PROTO_DAMAGES = 5;
	const MAX_ITEM_PROTO_SPELLS = 5;

	/* Item classes */
    const ITEM_CLASS_CONSUMABLE = 0;
    const ITEM_CLASS_CONTAINER = 1;
    const ITEM_CLASS_WEAPON = 2;
    const ITEM_CLASS_GEM = 3;
    const ITEM_CLASS_ARMOR = 4;
    const ITEM_CLASS_REAGENT = 5;
    const ITEM_CLASS_PROJECTILE = 6;
    const ITEM_CLASS_TRADE_GOODS = 7;
    const ITEM_CLASS_GENERIC = 8;
    const ITEM_CLASS_RECIPE = 9;
    const ITEM_CLASS_MONEY = 10;
    const ITEM_CLASS_QUIVER = 11;
    const ITEM_CLASS_QUEST = 12;
    const ITEM_CLASS_KEY = 13;
    const ITEM_CLASS_PERMANENT = 14;
    const ITEM_CLASS_MISC = 15;
    const ITEM_CLASS_GLYPH = 16;

	/* ItemFlags */
	const ITEM_FLAGS_BINDED = 0x00000001; // set in game at binding, not set in template
    const ITEM_FLAGS_CONJURED = 0x00000002;
    const ITEM_FLAGS_OPENABLE = 0x00000004;
    const ITEM_FLAGS_WRAPPED = 0x00000008; // conflicts with heroic flag
    const ITEM_FLAGS_HEROIC = 0x00000008; // weird...
    const ITEM_FLAGS_BROKEN = 0x00000010; // appears red icon (like when item durability==0)
    const ITEM_FLAGS_INDESTRUCTIBLE = 0x00000020; // used for totem. Item can not be destroyed, except by using spell (item can be reagent for spell and then allowed)
    const ITEM_FLAGS_USABLE = 0x00000040; // ?
    const ITEM_FLAGS_NO_EQUIP_COOLDOWN = 0x00000080; // ?
    const ITEM_FLAGS_UNK3 = 0x00000100; // saw this on item 47115, 49295...
    const ITEM_FLAGS_WRAPPER = 0x00000200; // used or not used wrapper
    const ITEM_FLAGS_IGNORE_BAG_SPACE = 0x00000400; // ignore bag space at new item creation?
    const ITEM_FLAGS_PARTY_LOOT = 0x00000800; // determines if item is party loot or not
    const ITEM_FLAGS_REFUNDABLE = 0x00001000; // item cost can be refunded within 2 hours after purchase
    const ITEM_FLAGS_CHARTER = 0x00002000; // arena/guild charter
    const ITEM_FLAGS_UNK4 = 0x00008000; // a lot of items have this
    const ITEM_FLAGS_UNK1 = 0x00010000; // a lot of items have this
    const ITEM_FLAGS_PROSPECTABLE = 0x00040000;
    const ITEM_FLAGS_UNIQUE_EQUIPPED = 0x00080000;
    const ITEM_FLAGS_USEABLE_IN_ARENA = 0x00200000;
    const ITEM_FLAGS_THROWABLE = 0x00400000; // not used in game for check trow possibility, only for item in game tooltip
    const ITEM_FLAGS_SPECIALUSE = 0x00800000; // last used flag in 2.3.0
    const ITEM_FLAGS_BOA = 0x08000000; // bind on account (set in template for items that can binded in like way)
    const ITEM_FLAGS_ENCHANT_SCROLL = 0x10000000; // for enchant scrolls
    const ITEM_FLAGS_MILLABLE = 0x20000000;
    const ITEM_FLAGS_BOP_TRADEABLE = 0x80000000;

	public $icon;
	public $class_text;
	public $subclass_text;
	public $dps;
	public $map_text;

	public $ItemStat = array();
	public $Spells = array();

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'item_template';
	}
	
	public function getDbConnection()
    {
    	return Yii::app()->db_world;
    }

   	public static function itemAlias($type, $code=NULL) {
		$_items = array(
			'bonding' => array(
				'1' => 'Binds when picked up',
				'2' => 'Binds when equipped',
				'3' => 'Binds when used',
				'4' => 'Quest item',
			),
			'stat' => array(
			    '3' => 'Agility',
   				'4' => 'Strength',
    			'5' => 'Intellect',
    			'6' => 'Spirit',
    			'7' => 'Stamina',
    			'8' => 'Agility', // Not used?	
			),
			'invtype' => array(
    			'1' => 'Head',
    			'2' => 'Neck',
    			'3' => 'Shoulder',
    			'16' => 'Back',
    			'5' => 'Chest',
    			'20' => 'Chest',
   				'4' => 'Shirt',
    			'18' => 'Tabard',
    			'9' => 'Wrist',
    			'10' => 'Hands',
    			'6' => 'Waist',
    			'7' => 'Legs',
    			'8' => 'Feet',
    			'11' => 'Finger',
    			'12' => 'Trinket',
    			'13' => 'One-hand',
    			'14' => 'Shield',
    			'15' => 'Right hand',
    			'19' => 'Tabard',
    			'23' => 'One-hand',
    			'17' => 'Two-hand',
    			'26' => 'Ranged',
    			'28' => 'Relic',
			),
			'spell_trigger' => array(
				'0' => 'Use',
				'1' => 'On Equip',
				'2' => 'Chance on Hit',
				'4' => 'Soulstone',
				'5'	=> 'Use with no delay',
				'6' => 'Use',
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
 
    protected function afterFind()
    {
     	parent::afterFind();
		$column = 'name_'.Yii::app()->language;
		$connection = Yii::app()->db;
		$command = $connection->createCommand("SELECT icon FROM wow_icons WHERE displayid = {$this->displayid} LIMIT 1");
		$this->icon = $command->queryScalar();

		$command = $connection->createCommand("SELECT `subclass_$column` AS `subclass`, `class_$column` AS `class` FROM `wow_item_subclasses` WHERE `subclass` = {$this->subclass} AND `class` = {$this->class} LIMIT 1");
		$itemsubclass = $command->queryRow();
        $this->subclass_text = $itemsubclass['subclass'];
        $this->class_text = $itemsubclass['class'];
		
		if($this->Map > 0)
		{
			$command = $connection->createCommand("SELECT $column FROM wow_maps WHERE id = {$this->Map} LIMIT 1");
			$this->map_text = $command->queryScalar();
		}
		//Item stats
		for($i = 0; $i < self::MAX_ITEM_PROTO_STATS; $i++)
		{
            $key = $i+1;
            if(isset($this->{'stat_type' . $key}))
			{
                $this->ItemStat[$i] = array(
                    'type'  => $this->{'stat_type'  . $key},
                    'value' => $this->{'stat_value' . $key});
            }
        }

        // Item damages
		$this->dps = 0;
        for($i = 1; $i <= self::MAX_ITEM_PROTO_DAMAGES; $i++)
			if(isset($this->{'dmg_type' . $i}))
				$this->dps += round(($this->{'dmg_min'. $i} + $this->{'dmg_max'. $i}) * 500 / $this->delay, 1);
		
		// Item spells
        for($i = 0; $i < self::MAX_ITEM_PROTO_SPELLS; $i++)
		{
            $key = $i+1;
            if(isset($this->{'spellid_' . $key}))
			{
                $this->Spells[$i] = array(
                    'spellid'          => $this->{'spellid_'               . $key}, 
                    'trigger'          => $this->{'spelltrigger_'          . $key}, 
                    'charges'          => $this->{'spellcharges_'          . $key}, 
                    'ppmRate'          => $this->{'spellppmRate_'          . $key},
                    'cooldown'         => $this->{'spellcooldown_'         . $key},
                    'category'         => $this->{'spellcategory_'         . $key},
                    'categorycooldown' => $this->{'spellcategorycooldown_' . $key}
                );
            }
        }
    }
}
