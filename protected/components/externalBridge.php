<?php

abstract class externalBridge extends CComponent
{
	private $_db = false;
	protected $_password = false;
    protected $_data = array();

    public function init()
    {
    }

    public function setDb($value)
    {
        $this->_db = new CDbConnection($value['connectionString'], $value['username'], $value['password']);
        if($value['tablePrefix'])
            $this->_db->tablePrefix = $value['tablePrefix'];
        if($value['charset'])
            $this->_db->charset = $value['charset'];
        $this->_db->active = true;
    }

    public function getDb()
    {
        return $this->_db;
    }
	
	public function getAttributes()
	{
		return array(
			'email' 	=> $this->email,
			'username' 	=> $this->username,
			'password'	=> $this->_password,
			'role'		=> $this->userRole,
			'status'	=> User::STATUS_ACTIVE,
		);
	}
    
    abstract public function getUserData($email, $password);

    abstract public function getEmail();

    abstract public function getUsername();

    abstract public function getUserRole();

    abstract static public function generateCompiledPasshash($salt, $password);
}