<?php

class AdminAccess extends CActiveRecord
{
	public function primaryKey()
	{
		return 'user_id';
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'admin_access';
	}
		
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id', 'select' => 'username'),
		);
	}
	
    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            $this->ip 		= ip2long($_SERVER['REMOTE_ADDR']);
            $this->user_id  = Yii::app()->user->id;
			$this->time 	= date('Y-m-d H:i:s');
            return true;
        }
        else
            return false;
    }
	
	protected function afterFind()
	{
		parent::afterFind();
		$this->ip = long2ip($this->ip);
	}
}