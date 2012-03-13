<?php

class Image extends CActiveRecord
{

    public $username;
    public $albumname;

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
            'BReportableBehaivor' => array(
                'class'           => 'application.components.behaviors.BReportableBehaivor',
                'ownerController' => Yii::app()->controller->id,
                'ownerModule'     => Yii::app()->controller->module->id,
            )
        );
    }

    public function tableName()
    {
        return 'images';
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'album' => array(self::BELONGS_TO, 'Album', 'user_id'),
        );
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image, mime_type', 'required'),
            array('user_id, album_id, create_time, last_visit, visits, size, width, height', 'numerical', 'integerOnly' => true),
            array('url, thumb_url, mime_type', 'length', 'max' => 255),
            array('user_guid', 'length', 'max' => 75),
            array('description', 'safe'),
            array('image', 'file', 'on' => 'create'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, description, user_id, album_id, user_guid, create_time, last_visit, visits, image, url, thumb_url, mime_type, size, width, height, username, albumname', 'safe', 'on' => 'search'),
        );
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
        {
            $this->user_id = (!Yii::app()->user->isGuest) ? Yii::app()->user->id : 0;
            $this->user_guid = (Yii::app()->user->isGuest) ? Yii::app()->controller->user_guid : 0;
        }

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if(is_object($this->album) and !$this->album->cover_id)
        {
            $this->album->cover_id = $this->id;
            $this->album->save(array('cover_id'));
        }
    }

    protected function afterDelete()
    {
        $filename = realpath(Yii::app()->getBasePath() . '/..' . $this->url);

        if(file_exists($filename))
            unlink($filename);

        $filename = realpath(Yii::app()->getBasePath() . '/..' . $this->thumb_url);
        if(file_exists($filename))
            unlink($filename);
    }

    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'description' => 'Description',
            'user_id'     => 'User',
            'album_id'    => 'Album',
            'user_guid'   => 'Guid',
            'create_time' => 'Create Time',
            'last_visit'  => 'Last Visit',
            'visits'      => 'Visits',
            'image'       => 'Name',
            'url'         => 'Url',
            'thumb_url'   => 'Thumb Url',
            'mime_type'   => 'Mime Type',
            'size'        => 'Size',
            'width'       => 'Width',
            'height'      => 'Height',
            'albumname'   => 'Альбом',
        );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = true;
        $criteria->with = array('user', 'album');
        $criteria->compare('album.name', $this->albumname, true);
        $criteria->compare('user.username', $this->username, true);

        $criteria->compare('id', $this->id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('album_id', $this->album_id);
        $criteria->compare('user_guid', $this->user_guid, true);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('last_visit', $this->last_visit);
        $criteria->compare('visits', $this->visits);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('thumb_url', $this->thumb_url, true);
        $criteria->compare('mime_type', $this->mime_type, true);
        $criteria->compare('size', $this->size);
        $criteria->compare('width', $this->width);
        $criteria->compare('height', $this->height);

        $sort = new CSort;
        $sort->attributes = array(
            'username' => array(
                'asc'       => 'user.username',
                'desc'      => 'user.username DESC',
            ),
            'albumname' => array(
                'asc'  => 'album.name',
                'desc' => 'album.name DESC',
            ),
            '*',
        );

        return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
                'sort'     => $sort,
            ));
    }

    public function getViewUrl()
    {
        return Yii::app()->controller->createAbsoluteUrl('/gallery/image/view', array('id' => $this->id));
    }

    public function getAbsoluteUrl()
    {
        return Yii::app()->controller->createAbsoluteUrl($this->url);
    }

    public function getThumbAbsoluteUrl()
    {
        return Yii::app()->controller->createAbsoluteUrl($this->thumb_url);
    }

    public function getHtmlCode()
    {
        return CHtml::link(CHtml::image($this->thumbAbsoluteUrl, $this->image), $this->viewUrl);
    }

    public function getBBCode()
    {
        return "[URL={$this->viewUrl}][IMG]{$this->thumbAbsoluteUrl}[/IMG][/URL]";
    }

}