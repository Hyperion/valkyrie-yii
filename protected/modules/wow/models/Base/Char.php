<?php

namespace Base;

class Char extends \BActiveRecord
{
    public function getDbConnection()
    {
        return \Database::getConnection(\Database::$realm);
    }
}