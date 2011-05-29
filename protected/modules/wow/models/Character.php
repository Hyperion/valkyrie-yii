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

	public $class_text = false;
	public $race_text = false;

	private $_items = array();

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
		);
	}

	public function itemAlias($type, $code = NULL)
	{
		$_items = array(
			'classes' => array(
				
			),
			'races' => array(
				
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
        $criteria->compare('race',$this->race);
        $criteria->compare('class',$this->class);
        $criteria->compare('level',$this->level);
        $criteria->compare('online',$this->online);
		$criteria->compare('honor_standing',$this->honor_standing);

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
        
		return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
			'pagination'    => array(
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
		$this->equipmentCache = explode(' ', $this->equipmentCache);
	}
	
	public function getItems()
	{
		if(!$this->_items)
			for($i = 0; $i < count($this->equipmentCache); $i += 2)
				$this->_items[] = ItemTemplate::model()->findByPk($this->equipmentCache[$i]);
		
		return $this->_items;
	}
	
	public function getEquippedItemInfo($slot)
	{
		if(!$this->items[$slot])
			return false;

		$item_data = array(
			'item_id'    => $this->items[$slot]->entry,
		        'name'       => $this->items[$slot]->name,
		        'guid'       => 0,
		        'quality'    => $this->items[$slot]->Quality,
		        'item_level' => $this->items[$slot]->ItemLevel,
		        'icon'       => $this->items[$slot]->icon,
		        'slot_id'    => $slot,
		        'data-item'  => '',
		        /*'enchid'     => $item->GetEnchantmentId(),
		        'g0'         => $item->GetSocketInfo(1),
		        'g1'         => $item->GetSocketInfo(2),
		        'g2'         => $item->GetSocketInfo(3),
		        'can_ench'   => !in_array($item->GetSlot(), array(INV_SHIRT, INV_RANGED_RELIC, INV_TABARD, INV_TRINKET_1, INV_TRINKET_2, INV_TYPE_NECK, INV_OFF_HAND, INV_RING_1, INV_RING_2, INV_NECK, INV_BELT))*/
        	);
        	
		return $item_data;
	}
}
