<?php

namespace Base;

class World extends \BActiveRecord
{
    public function getDbConnection()
    {
        return \Database::getConnection('World');
    }
}
