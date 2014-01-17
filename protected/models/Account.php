<?php

class Account extends Base\Realm
{

    const SEC_PLAYER        = 0;
    const SEC_MODERATOR     = 1;
    const SEC_GAMEMASTER    = 2;
    const SEC_ADMINISTRATOR = 3;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'account';
    }

    public function isPlayer()
    {
        return $this->gmlevel == self::SEC_PLAYER;
    }

}
