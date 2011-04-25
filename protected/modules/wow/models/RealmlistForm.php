<?php

class RealmlistForm extends CFormModel
{
    public $host;
    public $username;
    public $password;
    public $database;
  
    public function rules()
    {
        return array(
            array('host, username, password, database', 'required'),
        );
    }
}