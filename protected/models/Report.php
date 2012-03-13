<?php

class Report extends CActiveRecord
{

    public $username;

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'           => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => null,
            ),
            'EStatusBehavior' => array(
                'class'       => 'ext.yiiext.behaviors.model.status.EStatusBehavior',
                'statusField' => 'status',
                'statuses'    => array('Не проверено', 'Проверено'),
            )
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'reports';
    }
    
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }
    
    public function rules()
    {
        return array(
            array('owner_controller', 'required'),
            array('user_id, create_time, status, owner_id', 'numerical', 'integerOnly' => true),
            array('owner_controller, owner_module', 'length', 'max' => 255),
            array('report_text, owner_module', 'safe'),
            array('owner_id', 'uniqueIndex'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, create_time, status, report_text, owner_id, owner_controller, owner_module, user_id, username', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'               => 'ID',
            'create_time'      => 'Create Time',
            'status'           => 'Status',
            'report_text'      => 'Report Text',
            'owner_id'         => 'Owner',
            'owner_controller' => 'Owner Controller',
            'owner_module'     => 'Owner Module',
        );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = true;
        $criteria->with = array('user');
        $criteria->compare('user.username', $this->username, true);

        $criteria->compare('id', $this->id);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('report_text', $this->report_text, true);
        $criteria->compare('owner_id', $this->owner_id);
        $criteria->compare('owner_controller', $this->owner_controller, true);
        $criteria->compare('owner_module', $this->owner_module, true);
        $criteria->compare('user_id', $this->user_id);

        $sort = new CSort;
        $sort->attributes = array(
            'username' => array(
                'asc'  => 'user.username',
                'desc' => 'user.username DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'     => $sort,
            ));
    }

    protected function beforeSave()
    {
        $this->user_id = Yii::app()->user->id;

        return parent::beforeSave();
    }

    public function getUrl()
    {
        if($this->isNewRecord)
            return;

        $route = ($this->owner_module) ? '/' . $this->owner_module : '';
        $route .= '/' . $this->owner_controller . '/view';

        return Yii::app()->controller->createUrl($route, array('id' => $this->owner_id));
    }

    public function uniqueIndex($attribute, $params = array())
    {
        if(!$this->hasErrors())
        {
            $params['criteria'] = array(
                'condition' => 'owner_controller = :controller AND owner_module = :module',
                'params'    => array(':controller' => $this->owner_controller, ':module'     => $this->owner_module),
            );
            $validator    = CValidator::createValidator('unique', $this, $attribute, $params);
            $validator->validate($this, array($attribute));
        }
    }

}