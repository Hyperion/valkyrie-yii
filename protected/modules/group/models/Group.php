<?php

class Group extends CActiveRecord
{
    	const STATUS_REGISTERED = 'registered';
    	const STATUS_ACTIVE     = 'active';
    	const STATUS_BLOCKED    = 'blocked';
	const STATUS_REMOVED    = 'removed';

	const GOV_MONARCHY      = 'monarchy';
	const GOV_ANARCHY       = 'anarchy';
	const GOV_REPUBLIC      = 'republic';

	const TYPE_POSITIVE     = 'positive';
	const TYPE_NEGATIVE     = 'negative';

	const AVATAR_WALLPAPER  = 'wallpaper';
	const AVATAR_GRAFFITI   = 'graffiti'; 

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{groups}}';
	}

	public function rules()
	{
		return array(
			array('post_id, type, government, title', 'required', 'on'=>'create'),
			array('avatar', 'EPhotoValidator',
				'allowEmpty' => true,
				'mimeType'   => array('image/jpeg', 'image/png', 'image/gif'),
				'maxWidth'   => 600,
				'maxHeight'  => 200,
				'minWidth'   => 50,
				'minHeight'  => 50,
				'on'         => 'create, update',
			),
			array('post_id', 'uniquePost', 'on' => 'create'),
			array('owner_id, post_id', 'numerical', 'integerOnly'=>true),
			array('type', 'in', 'range' => array(self::TYPE_POSITIVE, self::TYPE_NEGATIVE)),
			array('government', 'in', 'range' => array(self::GOV_MONARCHY, self::GOV_ANARCHY, self::GOV_REPUBLIC)),
			array('avatar_type', 'in' , 'range' => array(self::AVATAR_WALLPAPER, self::AVATAR_GRAFFITI)),
			array('status', 'in', 'range' => array(self::STATUS_REGISTERED, self::STATUS_ACTIVE, self::STATUS_REMOVED, self::STATUS_BLOCKED)),
			array('title', 'length', 'max'=>25),
			array('url', 'length', 'max'=>255),
			array('description, info', 'safe'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner_id' => 'Owner',
			'post_id' => 'Post ID',
			'type' => 'Type',
			'government' => 'Government',
			'title' => 'Title',
			'description' => 'Description',
			'info' => 'Info',
			'avatar' => 'Avatar',
			'avatar_type' => 'Avatar Type',
			'url' => 'Url',
			'create_time' => 'Createtime',
		);
	}

	public function uniquePost()
	{
		$model = self::model()->findByAttributes(array(
			'post_id' => $this['post_id'],
			'type'    => $this['type'],
		));
		if($model !== null)
			$this->addError('post_id',Core::t('Group for this page and type already exists!'));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this['owner_id']    = Yii::app()->user->id;
				$this['create_time'] = date('Y-m-d H:i:s');
				if(empty($this->status)) $this->status = self::STATUS_REGISTERED;
			}
			return true;
		} else
			return false;
	}

	protected function afterSave()
	{
		parent::afterSave();
		if($this->isNewRecord)
		{
			$path = Yii::app()->basePath.'/../uploads/g'.$this['id'];
			mkdir($path);
			mkdir($path.'/images');
			if(!empty($this['avatar']))
				$this['avatar']->saveAs($path.'/'.$this['avatar']->name);
		}
	}
}
