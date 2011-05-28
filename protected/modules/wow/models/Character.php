<?php

class Character extends CActiveRecord
{
	public $class_text = false;
	public $race_text = false;

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
}
