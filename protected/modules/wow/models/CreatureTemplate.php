<?php

class CreatureTemplate extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'creature_template';
    }
    
    public function getDbConnection()
    {
        return Yii::app()->db_world;
    }
    
    public static function itemAlias($type, $code=NULL)
    {
        $_items = array(
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
    
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('name',$this->name,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=> array(
                'pageSize'=> 40,
            ),
        ));
    }    
}