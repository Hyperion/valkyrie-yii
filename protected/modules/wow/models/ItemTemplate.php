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

    private $_icon;
    private $_class_text;
    private $_subclass_text;
    private $_dps;
    private $_map_text;

    private $_stats = array();
    private $_spells = array();
    private $_set = array();

    private $_required_races = false;
    private $_required_classes = false;
    private $_required_skill;
    private $_required_faction;
    private $_required_spell;

    private $_sell_price;

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
    
    public function rules()
    {
        return array(
            array('class, subclass, InventoryType', 'safe', 'on'=>'search'),
        );
    }
    
    public static function itemAlias($type, $code=NULL)
    {
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
                '5' => 'Use with no delay',
                '6' => 'Use',
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('name',$this->name,true);
        $criteria->compare('class',$this->class);
        $criteria->compare('subclass',$this->subclass);
        $criteria->compare('InventoryType',$this->InventoryType);
        $criteria->order = 'Quality DESC, ItemLevel DESC';

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=> array(
                'pageSize'=> 40,
            ),
        ));
    }
    
    public function getIcon()
    {
        return $this->_icon;
    }
    protected function afterFind()
    {
        parent::afterFind();
        $column = 'name_'.Yii::app()->language;
        $connection = Yii::app()->db;
        $this->_icon = $connection
            ->createCommand("SELECT icon FROM wow_icons WHERE displayid = {$this->displayid} LIMIT 1")
            ->queryScalar();

    }
    
    public function getSubclass_text()
    {
        if(!isset($this->_subclass_text))
        {
            $column = 'name_'.Yii::app()->language;
            $this->_subclass_text = Yii::app()->db 
                ->createCommand("SELECT subclass_$column FROM wow_item_subclasses WHERE subclass = {$this->subclass}  AND class = {$this->class} LIMIT 1")
                ->queryScalar();
        }
        return $this->_subclass_text;
    }

    public function getClass_text()
    {
        if(!isset($this->_class_text))
        {
            $column = 'name_'.Yii::app()->language;
            $this->_class_text = Yii::app()->db 
                ->createCommand("SELECT class_$column FROM wow_item_subclasses WHERE class = {$this->class} LIMIT 1")
                ->queryScalar();
        }
        return $this->_class_text;
    }

    public function getMap_text()
    {
        if(!$this->_map_text)
        {
            $column = 'name_'.Yii::app()->language;
            $this->_map_text = Yii::app()->db
                ->createCommand("SELECT $column FROM wow_maps WHERE id = {$this->Map} LIMIT 1")
                ->queryScalar();
        }

        return $this->_map_text;
    }    

    public function getStats()
    {
        if(!$this->_stats)
            for($i = 0; $i < self::MAX_ITEM_PROTO_STATS; $i++)
            {
                $key = $i+1;
                if(isset($this->{'stat_type' . $key}))
                {
                    $this->_stats[$i] = array(
                        'type'  => $this->{'stat_type'  . $key},
                        'value' => $this->{'stat_value' . $key});
                }
            }

        return $this->_stats;
    }

    public function getDps()
    {
        if(!$this->_dps AND $this->class == self::ITEM_CLASS_WEAPON)
        {
            $this->_dps = 0;
            for($i = 1; $i <= self::MAX_ITEM_PROTO_DAMAGES; $i++)
                if(isset($this->{'dmg_type' . $i}))
                    $this->_dps += round(($this->{'dmg_min'. $i} + $this->{'dmg_max'. $i}) * 500 / $this->delay, 1);
        }

        return $this->_dps;
    }

    public function getSpells()
    {
        if(!$this->_spells)
            for($i = 0; $i < self::MAX_ITEM_PROTO_SPELLS; $i++)
            {
                $key = $i+1;
                if($this->{'spellid_' . $key} > 0)
                {
                    $spell = Spell::model()->findByPk($this->{'spellid_'.$key});
                    $spell->formatInfo();
                    $this->_spells[$i] = array(
                        'spellid'          => $this->{'spellid_'               . $key}, 
                        'trigger'          => $this->{'spelltrigger_'          . $key}, 
                        'charges'          => $this->{'spellcharges_'          . $key}, 
                        'ppmRate'          => $this->{'spellppmRate_'          . $key},
                        'cooldown'         => $this->{'spellcooldown_'         . $key},
                        'category'         => $this->{'spellcategory_'         . $key},
                        'categorycooldown' => $this->{'spellcategorycooldown_' . $key},
                        'description'       => $spell->info,
                    );
                    unset($spell);
                }
            }

        return $this->_spells;
    }

    public function getRequired_classes()
    {
        if(!$this->_required_classes)
        {
            $mask = $this->AllowableClass;
            $mask &= 0x5DF;
            if($mask == 0x5DF || $mask == 0)
                $this->_required_classes = true;
            
            if(!$this->_required_classes)
            {
                $column = 'name_'.Yii::app()->language;
                $command = Yii::app()->db->createCommand("SELECT $column FROM wow_classes WHERE id = :id");  
                $this->_required_classes = array();
                $i = 1;
                while($mask)
                {
                    if($mask & 1)
                    {
                        $command->bindParam(':id', $i);
                        $this->_required_classes[$i] = $command->queryScalar();
                    }
                    $mask >>= 1;
                    $i++;
                }
            }
        }

        return $this->_required_classes;
    }

    public function getRequired_races()
    {
        if(!$this->_required_races)
        {
            $mask = $this->AllowableRace;
            $mask &= 0xFF;
            if($mask == 0xFF || $mask == 0)
                $this->_required_races = true;

            if(!$this->_required_races)
            {
                $column = 'name_'.Yii::app()->language;
                $command = Yii::app()->db->createCommand("SELECT $column FROM wow_races WHERE id = :id");  
                $this->_required_races = array();
                $i = 1;
                while($mask)
                {
                    if($mask & 1)
                    {
                        $command->bindParam(':id', $i);
                            $this->_required_races[$i] = $command->queryScalar();
                    }
                    $mask >>= 1;
                    $i++;
                }
            }
        }

        return $this->_required_races;
    }
    
    public function getRequired_skill()
    {    
        if(!$this->_required_skill)
        {
            $column = 'name_'.Yii::app()->language;
            $this->_required_skill = Yii::app()->db
                ->createCommand("SELECT $column FROM wow_skills WHERE id = {$this->RequiredSkill} LIMIT 1")
                ->queryScalar();
        }

        return $this->_required_skill;
    }

    public function getRequired_spell()
    {    
        if(!$this->_required_spell)
        {
            $this->_required_spell = Yii::app()->db
                ->createCommand("SELECT spellname_loc0 FROM wow_spells WHERE spellID = {$this->requiredspell} LIMIT 1")
                ->queryScalar();
        }

        return $this->_required_spell;
    }

    public function getRequired_faction()
    {    
        if(!$this->_required_faction)
        {
            $column = 'name_'.Yii::app()->language;
            $this->_required_faction = Yii::app()->db
                ->createCommand("SELECT $column FROM wow_factions WHERE id = {$this->RequiredReputationFaction} LIMIT 1")
                ->queryScalar();
        }

        return $this->_required_faction;
    }

    public function getSet()
    {
        if(!$this->_set)
        {
            $item_set = Yii::app()->db
                ->createCommand("SELECT * FROM wow_itemset WHERE id = {$this->itemset} LIMIT 1")
                ->queryRow();
            $this->_set['name'] = $item_set['name_loc0'];

            $this->_set['items'] = $this->dbConnection
                ->createCommand("SELECT entry, name FROM item_template WHERE itemset = {$this->itemset}")
                ->queryAll();

            $this->_set['count'] = count($this->_set['items']);

            for($i = 1; $i < 8; $i++)
                if($item_set['spell' . $i] > 0)
                {
                    $spell = Spell::model()->findByPk($item_set['spell' . $i]);
                    
                    $spell->formatInfo();
                    $this->_set['bonuses'][$item_set['bonus'.$i]] = $spell;
                    unset($spell);
                }
            ksort($this->_set['bonuses']);            
        }
        
        return $this->_set;
    }

    public function getSell_price()
    {
        if(!$this->_sell_price)
        {
            $amount = $this->SellPrice;
            $this->_sell_price['gold'] = floor($amount/(100*100));
            $amount = $amount-$this->_sell_price['gold']*100*100;
            $this->_sell_price['silver'] = floor($amount/100);
            $amount = $amount-$this->_sell_price['silver']*100;
            $this->_sell_price['copper'] = floor($amount);
        }
        
        return $this->_sell_price;
    }

    public function getEnchantText($id)
    {
        $column = 'text_'.Yii::app()->language;
        return Yii::app()->db
            ->createCommand("SELECT $column FROM wow_enchantment WHERE id = {$id} LIMIT 1")
            ->queryScalar();
    }
}
