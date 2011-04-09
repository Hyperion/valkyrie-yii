<?php

class UniqueNameValidator extends CValidator
{
    protected function validateAttribute($object,$attribute)
    {
        $value=$object->$attribute;
        if($this->allowEmpty && $this->isEmpty($value))
            return;

        $mapper = new CharacterMapper();
        $db = $mapper->getDbConnection();

        $sql = "SELECT COUNT(*) FROM `".$mapper->getDbTable()."` WHERE guid=:id AND name=:name";
        $command=$db->createCommand($sql);
        $command->bindParam(":id", $object->guid);
        $command->bindParam(":name", $value);
        $count = $command->queryScalar();

        if($count === 1)
            return;

        $sql = "SELECT COUNT(*) FROM `".$mapper->getDbTable()."` WHERE name=:name";
        $command=$db->createCommand($sql);
        $command->bindParam(":name", $value);
        $count = $command->queryScalar();

        if($count > 0)
        {
            $message=$this->message!==null?$this->message:Yii::t('yii','{attribute} "{value}" has already been taken.');
            $this->addError($object,$attribute,$message,array('{value}'=>$value));
        }
    }
}