<?php

class DatabaseForm extends CFormModel
{
    public $username;
    public $password;
    public $database;
  
    public function rules()
    {
        return array(
            array('username, password, database', 'required'),
        );
    }
}