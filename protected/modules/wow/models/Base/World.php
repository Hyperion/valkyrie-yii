<?php

namespace Base;

class World extends \BActiveRecord
{
    public function getDbConnection()
    {
        return \Yii::app()->db_world;
    }
}
