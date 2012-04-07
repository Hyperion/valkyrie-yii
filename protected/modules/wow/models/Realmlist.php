<?php

class Realmlist extends Base\Realm
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'realmlist';
    }

    public function rules()
    {

        return array(
            array('port, icon, color, timezone, allowedSecurityLevel', 'numerical', 'integerOnly' => true),
            array('population', 'numerical'),
            array('name, address', 'length', 'max' => 32),
            array('realmbuilds', 'length', 'max' => 64),
            array('name', 'safe', 'on' => 'search'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(get_class($this), array(
                'criteria' => $criteria,
            ));
    }

    public function getUptime()
    {
        return $this->dbConnection
                ->createCommand("SELECT `uptime` FROM `uptime` WHERE `starttime` = (SELECT MAX(`starttime`) FROM `uptime` WHERE realmid = :realmid)")
                ->queryScalar(array(':realmid' => $this->id));
    }

    public function getPlayers()
    {
        $chars_db = Database::getConnection($this->name);
        return $chars_db->createCommand("SELECT COUNT(*) FROM characters WHERE online = 1")->queryScalar();
    }

    public function getMaxPlayers()
    {
        return $this->dbConnection
                ->createCommand("SELECT MAX(`maxplayers`) FROM uptime WHERE realmid = :realmid")
                ->queryScalar(array(':realmid' => $this->id));
    }

}
