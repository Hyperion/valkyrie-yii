<?

class CharacterMapper
{
    private $_table = 'characters';
    private $_searchParams = array();

    public function getDbConnection()
    {
        return Yii::app()->db_chars;
    }

    public function getDbTable()
    {
        return $this->_table;
    }

    public function findById($id)
    {
        $db = self::getDbConnection();

        $sql = "SELECT
            `characters`.`guid`,
            `characters`.`account`,
            `characters`.`name`,
            `characters`.`race`,
            `characters`.`class`,
            `characters`.`gender`,
            `characters`.`level`,
            `characters`.`money`,
            `characters`.`playerBytes`,
            `characters`.`playerBytes2`,
            `characters`.`playerFlags`,
            `characters`.`health`,
            `characters`.`power1`,
            `characters`.`power2`,
            `characters`.`power3`,
            `characters`.`equipmentCache`,
            `guild_member`.`guildid` AS `guildId`,
            `guild`.`name` AS `guildName`
            FROM `characters` AS `characters`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
            WHERE `characters`.`guid`=:id LIMIT 1";
        $command=$db->createCommand($sql);
        $command->bindParam(":id", $id);
        $row = $command->queryRow();
 
        $char = new Character;
        $char->setAttributes($row);

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
        $conditions = array('and');
        $params = array();
        $db = self::getDbConnection();
        $command = $db->createCommand()
            ->select('
            characters.guid,
            characters.account,
            characters.name,
            characters.race,
            characters.class,
            characters.gender,
            characters.level,
            characters.money,
            characters.playerBytes,
            characters.playerBytes2,
            characters.map,
            characters.zone')
            ->from('characters');

        if(isset($this->_searchParams['pvp']) and $this->_searchParams['pvp'])
        {
            $command = $db->createCommand()
            ->select('
            characters.guid,
            characters.account,
            characters.name,
            characters.race,
            characters.class,
            characters.gender,
            characters.level,
            characters.money,
            characters.map,
            characters.zone,
            characters.honor_standing,
            characters.honor_highest_rank,
            characters.honor_rank_points,
            character_honor_static.hk,
            character_honor_static.thisWeek_cp,
            character_honor_static.thisWeek_kills')
            ->from('characters')
            ->leftjoin('character_honor_static', 'characters.guid = character_honor_static.guid')
            ->order('characters.honor_standing');
            $conditions[] = 'honor_standing > 0';
        }

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
            if($this->_searchParams['faction'] == 0) //alliancee
                $conditions[] = 'characters.race IN (1, 3, 4, 7)';
            elseif($this->_searchParams['faction'] == 1)
                $conditions[] = 'characters.race IN (2, 5, 6, 8)';
        }
        if(isset($this->_searchParams['honor_standing']) and $this->_searchParams['honor_standing'] != '')
        {
            $conditions[] = 'characters.honor_standing = :honor_standing';
            $params[':honor_standing'] = $this->_searchParams['honor_standing'];
        }
        if(count($conditions) > 1)
            $command->where($conditions, $params);
        return $command;
    }

    public function search($pageSize = null)
    {
        $count = $this->getSearchCommand()->select('COUNT(1)')->queryScalar();
        $dataProvider = new CModelDataProvider($this->getSearchCommand(), 'Character', array(
            'totalItemCount'=>$count,
            'sort'=>array(
                'attributes'=>array(
                    'name', 'level', 'class', 'race', 'honor_standing', 'honor_highest_rank', 'honor_rank_points', 'hk', 'dk', 'thisWeek_kills', 'thisWeek_cp',
                ),
            ),
            'pagination'=>array(
                'pageSize'=> $pageSize ? $pageSize : 10,
            ),
            'keyField' => 'guid'
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