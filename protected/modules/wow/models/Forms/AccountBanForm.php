<?php

class AccountBanForm extends CFormModel
{
    public $value;
    public $method; //0 - by id, 1 - by ip;
    public $time;
    public $reason;
    public $active;

    public function rules()
    {
        return array(
            array('value, method, time, reason', 'required'),
            array('time, method, active', 'numerical', 'integerOnly'=>true),
        );
    }
    public function attributeLabels()
    {
        return array(
            'value' => 'Ip or Id',
            'method' => 'Method of ban, ip or id based',
            'time' => 'Duration of ban in days',
            'active' => 'Boolean 0 or 1 controlling if the ban is currently active or not (for id based ban)'
        );
    }
}