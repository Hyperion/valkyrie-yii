<?php

class BVisitedBehaivor extends CActiveRecordBehavior
{

    protected $_userKey;
    protected $_modelClass;
    protected $_modelId;
    protected $_tableName   = '{{visit}}';
    protected $_createTable = true;
    protected $_dbEngine    = 'InnoDB';

    function afterFind($event)
    {
        $app = Yii::app();

        $this->_userKey = ($app->getComponent('user')->getIsGuest()) ? $app->getController()->user_guid : $app->getComponent('user')->getId();
        $this->_modelClass = get_class($this->getOwner());
        $this->_modelId = $this->getOwner()->getPrimaryKey();

        if($this->getCreateTable())
            $this->createTable();

        parent::beforeFind($event);
    }

    function saveVisit()
    {
        $connection = $this->getDb();

        $visited = $connection
            ->createCommand('SELECT COUNT(*) FROM ' . $this->getTableName() . ' WHERE user_key = :user_key AND model_class = :model_class AND model_id = :model_id')
            ->queryScalar(array(':user_key'    => $this->_userKey, ':model_class' => $this->_modelClass, ':model_id'    => $this->_modelId));

        if(!$visited)
        {
            $command = $connection
                ->createCommand('INSERT INTO ' . $this->getTableName() . ' (`user_key`,`model_class`,`model_id`) VALUES(:user_key, :model_class, :model_id)');

            $command->bindValue(':user_key', $this->_userKey);
            $command->bindValue(':model_class', $this->_modelClass);
            $command->bindValue(':model_id', $this->_modelId);
            $command->execute();
        }
    }

    function getVisits()
    {
        return $this->getDb()
                ->createCommand('SELECT COUNT(*) FROM ' . $this->getTableName() . ' WHERE model_class = :model_class AND model_id = :model_id')
                ->queryScalar(array(':model_class' => $this->_modelClass, ':model_id'    => $this->_modelId));
    }

    function beforeDelete($event)
    {
        $command = $this->getDb()
            ->createCommand('DELETE FROM ' . $this->getTableName() . ' WHERE model_class = :model_class AND model_id = :model_id');

        $command->bindValue(':model_class', $this->_modelClass);
        $command->bindValue(':model_id', $this->_modelId);
        $command->execute();

        return parent::beforeDelete($event);
    }

    public function setTableName($name)
    {
        if($this->getCreateTable() && (strpos($name, '{{') != 0 || strpos($name, '}}') != (strlen($name) - 2)))
            throw new CException('The table name must be like "{{' . $name . '}}" not just "' . $name . '"');
        $this->_tableName = $name;
    }

    public function getTableName()
    {
        return $this->_tableName;
    }

    public function setCreateTable($bool)
    {
        $this->_createTable = (bool) $bool;
    }

    public function getCreateTable()
    {
        return $this->_createTable;
    }

    protected function getDb()
    {
        return $this->getOwner()->getDbConnection();
    }

    public function setDbEngine($name)
    {
        $this->_dbEngine = $name;
    }

    public function getDbEngine()
    {
        return $this->_dbEngine;
    }

    protected function createTable()
    {
        $connection = $this->getDb();
        $tableName  = $connection->tablePrefix . str_replace(array('{{', '}}'), '', $this->getTableName());
        $sql     = 'CREATE TABLE IF NOT EXISTS `' . $tableName . '` (
		  `id` int(11) NOT NULL auto_increment,
		  `model_class` varchar(64) NOT NULL,
		  `model_id` int(11) NOT NULL,
		  `user_key` varchar(75) NOT NULL,
		  PRIMARY KEY  (`id`),
		  UNIQUE KEY `model_user_key` (`model_class`,`model_id`, `user_key`)
		) ' . ($this->getDbEngine() ? 'ENGINE=' . $this->getDbEngine() : '') . '  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
        $command = $connection->createCommand($sql);
        $command->execute();
    }

}