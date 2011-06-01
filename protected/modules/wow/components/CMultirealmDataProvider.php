<?php

class CMultirealmDataProvider extends CActiveDataProvider
{
	public $all_realms = false;

	protected function fetchData()
	{
		$criteria=clone $this->getCriteria();

		if(($pagination=$this->getPagination())!==false)
		{
			$pagination->setItemCount($this->getTotalItemCount());
			$pagination->applyLimit($criteria);
		}

		$baseCriteria=$this->model->getDbCriteria(false);

		if(($sort=$this->getSort())!==false)
		{
			// set model criteria so that CSort can use its table alias setting
			if($baseCriteria!==null)
			{
				$c=clone $baseCriteria;
				$c->mergeWith($criteria);
				$this->model->setDbCriteria($c);
			}
			else
				$this->model->setDbCriteria($criteria);
			$sort->applyOrder($criteria);
		}

		$this->model->setDbCriteria($baseCriteria!==null ? clone $baseCriteria : null);

        $data = array();

		if($this->all_realms)
		{
			$realmInfo = Database::model()->findAll('type = "characters"');

        	foreach($realmInfo as $server)
        	{
				Database::$realm = $server->title;
				$data += $this->model->findAll($criteria);
			}
		}
		else
            $data = $this->model->findAll($criteria);

		$this->model->setDbCriteria($baseCriteria);  // restore original criteria
		return $data;
	}
}
