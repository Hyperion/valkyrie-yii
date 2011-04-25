<?php

class CModelDataProvider extends CDataProvider
{
	public $db;
	public $command;
    public $modelClass;
	public $keyField='id';

	public function __construct($command,$modelClass,$config=array())
	{
        if(is_string($modelClass))
            $this->modelClass = $modelClass;
        else if($modelClass instanceof CModel)
            $this->modelClass = get_class($modelClass);
		$this->command=$command;
		foreach($config as $key=>$value)
			$this->$key=$value;
	}

	protected function fetchData()
	{
		$command=$this->command;
		$db=$this->db===null ? Yii::app()->db : $this->db;

		if(($sort=$this->getSort())!==false)
		{
			$order=$sort->getOrderBy();
			if(!empty($order))
				$command->order($order);
		}

		if(($pagination=$this->getPagination())!==false)
		{
			$pagination->setItemCount($this->getTotalItemCount());
			$limit=$pagination->getLimit();
			$offset=$pagination->getOffset();
			$command->limit($limit,$offset);
		}

		$rows = $command->queryAll();
        $data = array();
        foreach($rows as $row)
        {
            $model = new $this->modelClass();
            $model->setAttributes($row);
            $data[] = $model;
        }
        return $data;
	}

	protected function fetchKeys()
	{
		$keys=array();
		foreach($this->getData() as $i=>$data)
			$keys[$i]=$data[$this->keyField];
		return $keys;
	}

	protected function calculateTotalItemCount()
	{
		return 0;
	}
}
