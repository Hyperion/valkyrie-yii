<?php

class BVisitedBehaivor extends CActiveRecordBehavior
{

    protected $_tableName   = '{{visits}}';
    protected $_createTable = false;
    protected $_dbEngine    = 'InnoDB';

    function saveVisit($text)
    {
        $report = new $this->reportModelClass;

        $report->setAttribute($this->reportTextField, $text);
        $report->setAttribute($this->ownerIdField, $this->getOwner()->getPrimaryKey());
        $report->setAttribute($this->ownerControllerField, $this->ownerController);
        $report->setAttribute($this->ownerModuleField, $this->ownerModule);

        return $report->save();
    }

    function getReports()
    {
        $report = $this->getModelInstance();

        $criteria = new CDbCriteria();
        $criteria->compare($this->ownerIdField, $this->getOwner()->getPrimaryKey());
        $criteria->compare($this->ownerControllerField, $this->ownerController);
        $criteria->compare($this->ownerModuleField, $this->ownerModule);

        return $report->findAll($criteria);
    }

    private function getModelInstance()
    {
        if(!isset($this->reportModelClass))
        {
            throw new CException(Yii::t('app', 'reportModelClass should be defined.'));
        }
        return CActiveRecord::model($this->reportModelClass);
    }

    function afterDelete($event)
    {
        $reports = $this->getReports();
        foreach($reports as $report)
        {
            $report->delete();
        }

        parent::afterDelete($event);
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
		$this->_dbEngine=$name;
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
		  `modelClass` varchar(64) NOT NULL,
		  `modelId` int(11) NOT NULL,
		  `user_key` varchar(75) NOT NULL,
		  PRIMARY KEY  (`id`),
		  KEY `model_user_key` (`modelClass`,`modelId`, `user_key`) UNIQUE
		) ' . ($this->getDbEngine() ? 'ENGINE=' . $this->getDbEngine() : '') . '  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
        $command = $connection->createCommand($sql);
        $command->execute();
    }

}