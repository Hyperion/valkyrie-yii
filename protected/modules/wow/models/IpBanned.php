<?php

class IpBanned extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        $db = new WowDatabase();
        return $db->getDb('realmlist');
    }

    public function tableName()
    {
        return 'ip_banned';
    }

    public function rules()
    {
        return array(
            array('bandate, unbandate', 'required'),
            array('ip', 'length', 'max'=>32),
            array('bandate, unbandate', 'length', 'max'=>40),
            array('bannedby', 'length', 'max'=>50),
            array('banreason', 'length', 'max'=>255),
            array('ip, bandate, unbandate, bannedby, banreason', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'ip' => 'Ip',
            'bandate' => 'Ban Date',
            'unbandate' => 'Unban Date',
            'bannedby' => 'Banned by',
            'banreason' => 'Ban Reason',
        );
    }

    public function search()
    {

        $criteria=new CDbCriteria;

        $criteria->compare('ip',$this->ip,true);
        $criteria->compare('bandate',$this->bandate,true);
        $criteria->compare('unbandate',$this->unbandate,true);
        $criteria->compare('bannedby',$this->bannedby,true);
        $criteria->compare('banreason',$this->banreason,true);
        $criteria->order = 'bandate DESC';

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }
}
