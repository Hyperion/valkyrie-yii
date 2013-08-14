<?php

namespace Base;

class Realm extends \BActiveRecord
{
    public function getDbConnection()
    {
        return \Database::getConnection();
    }
}
