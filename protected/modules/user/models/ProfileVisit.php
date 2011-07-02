<?php

class ProfileVisit extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function primaryKey() {
        return array('visitor_id', 'visited_id');
    }

    public function beforeValidate() {
        if ($this->timestamp_first_visit === NULL)
            $this->timestamp_first_visit = time();

        $this->timestamp_last_visit = time();
        $this->num_of_visits++;
        return true;
    }

    public function tableName()
    {
        return 'profile_visit';
    }

    public function rules() {
        return array(
                array('visitor_id, visited_id, timestamp_first_visit, timestamp_last_visit, num_of_visits', 'required'),
                array('visitor_id, visited_id, timestamp_first_visit, timestamp_last_visit, num_of_visits', 'numerical', 'integerOnly' => true),
                array('visitor_id, visited_id, timestamp_first_visit, timestamp_last_visit, num_of_visits', 'safe', 'on' => 'search'),
                );
    }

    public function relations() {
        return array(
                'visitor' => array(self::BELONGS_TO, 'User', 'visitor_id'),
                'visited' => array(self::BELONGS_TO, 'User', 'visited_id'),
                );
    }

    public function attributeLabels() {
        return array(
                'visitor_id' => Yii::t('UserModule.user', 'Visitor'),
                'visited_id' => Yii::t('UserModule.user', 'Visited'),
                'timestamp_first_visit' => Yii::t('UserModule.user', 'Time of first visit'),
                'timestamp_last_visit' => Yii::t('UserModule.user', 'Time of last visit'),
                'num_of_visits' => Yii::t('UserModule.user', 'Total Num of Visits'),
                );
    }

    public function __toString() {
        return $this->visitor->username;
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('visitor_id', $this->visitor_id);
        $criteria->compare('visited_id', $this->visited_id);
        $criteria->compare('timestamp_first_visit', $this->timestamp_first_visit);
        $criteria->compare('timestamp_last_visit', $this->timestamp_last_visit);
        $criteria->compare('num_of_visits', $this->num_of_visits);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                    ));
    }

}
