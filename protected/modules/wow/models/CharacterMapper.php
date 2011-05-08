<?

class CharacterMapper
{
    private $_table = 'characters';
    private $_searchParams = array();

    public function getDbConnection()
    {
        $db = new WowDatabase();
		return $db->getDb();
    }

    public function getDbTable()
    {
        return $this->_table;
    }
    
    private function createSqlCommand($conditions, $params, $type = 'default')
    {
    	$sql_min =
    		'characters.guid,
            characters.account,
            characters.name,
            characters.race,
            characters.class,
            characters.gender,
            characters.level';
		
		$sql_admin = $sql_min.',
			characters.money,
			characters.playerBytes,
			characters.playerBytes2';
		
		$sql_statistic = $sql_min.',
			characters.map,
			characters.zone';
			
		$sql_pvp = $sql_min.',
			characters.honor_standing,
            characters.honor_highest_rank,
            characters.honor_rank_points,
            character_honor_static.hk,
            character_honor_static.thisWeek_cp,
            character_honor_static.thisWeek_kills';
            
        $sql_info = $sql_min.',
            characters.health,
            characters.power1,
            characters.power2,
            characters.power3,
            characters.equipmentCache,
            guild_member.guildid AS guildId,
            guild.name AS guildName';
            		
    	$db = self::getDbConnection();
    	
    	switch($type)
    	{
    		case 'admin':
    			$sql = $sql_admin;
    			break;
    		case 'statistic':
    			$sql = $sql_statistic;
    			break;
    		case 'pvp':
    			$sql = $sql_pvp;
    			break;
    		case 'info':
    			$sql = $sql_info;
    			break;
    		case 'default': default:
    			$sql = $sql_min;
    			break;
    	}
    	
    	$command=$db->createCommand()
            ->select($sql)
            ->from('characters');
            
        switch($type)
    	{
    		case 'pvp':
    			$command->leftjoin('character_honor_static', 'characters.guid = character_honor_static.guid');
    			break;
    		case 'info':
    			$command
    				->leftJoin('guild_member', '`guild_member`.`guid` = `characters`.`guid`')
            		->leftJoin('guild', '`guild`.`guildid` = `guild_member`.`guildid`');
    			break;
    		case 'default': default:
    			break;
    	}   
            
        $command->where($conditions, $params);
            
		return $command;
    }

    public function findByName($name)
    {
        return $this->findBySql('`characters`.`name`=:name', array(':name' => $name));
    }
    
    public function findById($id)
    {
        return $this->findBySql('characters.guid=:id', array(':id' => $id));
    }
    
    public function findBySql($conditions = null, $params = null)
    {
        $lang = Yii::app()->language;
        
        $command = $this->createSqlCommand($conditions, $params, 'info');
        $command->limit(1);
        
        $row = $command->queryRow();
 
        $char = new Character;
        $char->setAttributes($row);
        
        $column = 'name_'.$lang;
        $sql = "SELECT
            {{wow_classes}}.`$column` AS class,
            {{wow_races}}.`$column` AS race
            FROM {{wow_classes}}, {{wow_races}}
            WHERE {{wow_classes}}.`id` = :class_id AND {{wow_races}}.`id` = :race_id LIMIT 1";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":class_id", $char->class);
        $command->bindParam(":race_id", $char->race);
        $row = $command->queryRow();
        
        $char->classText = $row['class'];
        $char->raceText  = $row['race'];

        return $char;
    }
    
    public function setSearchParams($params)
    {
        if(is_array($params))
            $this->_searchParams = array_merge($this->_searchParams, $params);
        return $this;
    }
    
    private function getSearchCommand()
    {
    	if(!isset($this->_searchParams['type']))
    		$this->_searchParams['type'] = 'default';
    		
    	$conditions = array('and');
        $params = array();
        
        if(isset($this->_searchParams['name']) and $this->_searchParams['name'] != '')
        {
            $conditions[] = 'characters.name like :name';
            $params[':name'] = '%'.$this->_searchParams['name'].'%';
         }
        if(isset($this->_searchParams['account']))
        {
            $conditions[] = 'characters.account = :account'; 
            $params[':account'] = $this->_searchParams['account'];
        }
        if(isset($this->_searchParams['online']))
            $conditions[] =  'characters.online = 1';
        if(isset($this->_searchParams['level']) and $this->_searchParams['level'] != '')
        {
            $conditions[] = 'characters.level = :level';
            $params[':level'] = $this->_searchParams['level'];
        }
        if(isset($this->_searchParams['class']) and $this->_searchParams['class'] != '')
        {
            if($this->_searchParams['class'] != 0)
            {
                $conditions[] = 'characters.class = :class';
                $params[':class'] = $this->_searchParams['class'];
            }
        }
        if(isset($this->_searchParams['race']) and $this->_searchParams['race'] != '')
        {
            if($this->_searchParams['race'] != 0)
            {
                $conditions[] = 'characters.race = :race';
                $params[':race'] = $this->_searchParams['race'];
            }
        }
        if(isset($this->_searchParams['faction']) and $this->_searchParams['faction'] != '')
        {
            if($this->_searchParams['faction'] == 0) //alliance
                $conditions[] = 'characters.race IN (1, 3, 4, 7)';
            elseif($this->_searchParams['faction'] == 1)
                $conditions[] = 'characters.race IN (2, 5, 6, 8)';
        }
        if(isset($this->_searchParams['honor_standing']) and $this->_searchParams['honor_standing'] != '')
        {
            $conditions[] = 'characters.honor_standing = :honor_standing';
            $params[':honor_standing'] = $this->_searchParams['honor_standing'];
        }
        
        switch($this->_searchParams['type'])
    	{
    		case 'admin':
    			$command = $this->createSqlCommand($conditions, $params, 'admin');
    			break;
    		case 'statistic':
    			$command = $this->createSqlCommand($conditions, $params, 'statistic');
    			break;
    		case 'pvp':
    			$conditions[] = 'honor_standing > 0';
    			$command = $this->createSqlCommand($conditions, $params, 'pvp')
    				->order('characters.honor_standing');
    			break;
    		case 'info':
    			$command = $this->createSqlCommand($conditions, $params, 'info');
    			break;
    		case 'default': default:
    			$command = $this->createSqlCommand($conditions, $params);
    			break;
    	}
    	
        return $command;
    }

    public function search($pageSize = null, $all = false)
    {
        $count = $this->getSearchCommand()->select('COUNT(1)')->queryScalar();
        $dataProvider = new CCharactersDataProvider($this->getSearchCommand(), 'Character', array(
            'all'            => $all,
            'lang'           => Yii::app()->language,
            'totalItemCount' => $count,
            'sort'           => array(
                'attributes' => array(
                    'name', 'level', 'class', 'race', 'honor_standing', 'honor_highest_rank', 'honor_rank_points', 'hk', 'dk', 'thisWeek_kills', 'thisWeek_cp',
                ),
            ),
            'pagination'    => array(
                'pageSize'=> $pageSize ? $pageSize : 10,
            ),
            'keyField'      => 'guid'
        ));
        return $dataProvider;
    }
    
    public function save(Character $model)
    {
        $db = self::getDbConnection();
        $online = $db->createCommand("SELECT online FROM `{$this->_table}`")
            ->where('guid = :guid', array(':guid' => $model->guid))
            ->queryScalar();
        if($online === false or $online === 1) return false;

        $command = $db->createCommand();
        $command->update('characters', array(
            'account' => $model->account,
            'name' => $model->name,
            'race' => $model->race,
            'class' => $model->class,
            'gender' => $model->gender,
            'level' => $model->level,
            'money' => $model->money,
            'playerBytes' => $model->playerBytes,
            'playerBytes2' => $model->playerBytes2,),
        'guid=:guid', array(':guid'=>$model->guid));
        $command->execute();
    }

    public function updateWeaponSkills(Character $model)
    {
        $db = self::getDbConnection();
        $sql = 'UPDATE character_skills SET max = :max WHERE skill IN (196, 264, 5011, 1180, 204, 107, 3127, 15590, 266, 198, 200, 227, 201, 2567, 197, 199, 202, 203, 5009) AND guid = :guid';
        $command=$db->createCommand($sql);
        $command->bindParam(":max", $model->level*5, PDO::PARAM_INT);
        $command->bindParam(":guid", $model->guid, PDO::PARAM_INT);
        return $command->execute();
    }

    public function deleteSpells(Character $model)
    {
        $db = self::getDbConnection();
        $command = $db->createCommand("DELETE FROM `character_spell` WHERE `guid` = :guid");
        $command->bindParam(":guid", $model->guid, PDO::PARAM_INT);
        return $command->execute();
    }

    public function repair($guid, $account)
    {
        $db = self::getDbConnection();
        $online = $db->createCommand("SELECT online FROM `{$this->_table}`")
            ->where('guid = :guid AND account = :account', array(':guid' => $guid, ':account' => $account))
            ->queryScalar();
        if($online === false or $online === 1) return false;
        $command = $db->createCommand("DELETE FROM `character_aura` WHERE `guid` = :guid");
        $command->bindParam(':guid', $guid);
        $command->execute();

        $command = $db->createCommand("DELETE FROM `groups` WHERE `leaderGuid` = :guid");
        $command->bindParam(':guid', $guid);
        $command->execute();

        $command = $db->createCommand("DELETE FROM `group_member` WHERE `memberGuid`= :guid");
        $command->bindParam(':guid', $guid);
        $command->execute();

        $command = $db->createCommand("INSERT INTO `character_aura` VALUES (:guid, :guid, '0', '15007', '0', '1', '-75', '600000', '600000', '0'), (:guid, :guid, '0', '15007', '1', '1', '-75', '600000', '600000', '0')");
        $command->bindParam(':guid', $guid);
        $command->execute();

        $command = $db->createCommand("UPDATE `characters`, `character_homebind` SET `characters`.`position_x`=`character_homebind`.`position_x`, `characters`.`position_y`=`character_homebind`.`position_y`, `characters`.`position_z`=`character_homebind`.`position_z`, `characters`.`map`=`character_homebind`.`map` WHERE `characters`.`guid`=:guid AND `characters`.`guid`=`character_homebind`.`guid`");
        $command->bindParam(':guid', $guid);
        $command->execute();
        return true;
    }
}
