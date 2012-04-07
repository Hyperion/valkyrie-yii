<?php

class Album extends CActiveRecord
{

    public $username;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'               => 'zii.behaviors.CTimestampBehavior',
                'createAttribute'     => 'create_time',
                'updateAttribute'     => null,
            ),
            'BVisitedBehaivor' => array(
                'class'           => 'application.components.behaviors.BVisitedBehaivor',
            )
        );
    }

    public function tableName()
    {
        return 'albums';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, visible', 'required'),
            array('user_id, create_time, cover_id, visible', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, user_id, create_time, cover_id, visible, username', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'cover' => array(self::BELONGS_TO, 'Image', 'cover_id'),
            'images' => array(self::HAS_MANY, 'Image', 'album_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'name'        => 'Название',
            'description' => 'Описание',
            'create_time' => 'Время создания',
            'cover_id'    => 'Обложка',
            'visible'     => 'Публичный',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = true;
        $criteria->with = array('user');
        $criteria->compare('user.username', $this->username, true);

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('cover_id', $this->cover_id);
        $criteria->compare('visible', $this->visible);

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

    public function images()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('album_id', $this->id);

        return new CActiveDataProvider(Image::model(), array(
                'criteria'   => $criteria,
                'pagination' => array(
                    'pageSize' => 12,
                ),
            ));
    }

    protected function afterFind()
    {
        if($this->cover_id and !is_object($this->cover))
            $this->cover_id = 0;
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->user_id = Yii::app()->user->id;
        }

        return parent::beforeSave();
    }

}