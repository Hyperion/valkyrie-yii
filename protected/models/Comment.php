<?php

class Comment extends CActiveRecord
{
	const STATUS_PENDING  = 'pending';
	const STATUS_APPROVED = 'approved';
	
	const TYPE_POSITIVE   = 'positive';
	const TYPE_NEGATIVE   = 'negative';

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{comments}}';
	}

	public function rules()
	{
		return array(
			array('content', 'required'),
			array('type', 'in', 'range' => array(self::TYPE_POSITIVE, self::TYPE_NEGATIVE), 'on' => 'post_comment'),
			array('type', 'required', 'on' => 'post_comment'),
			array('content', 'uniqueComment' , 'on' => 'post_comment'),
		);
	}

	public function uniqueComment()
	{
		$model = self::model()->findByAttributes(array(
			'author_id' 	=> Yii::app()->user->id,
			'material_id'   => $this['material_id'],
		));
		if($model !== null)
			$this->addError('post_id',Core::t('Group for this page and type already exists!'));
	}

	public function relations()
	{
		return array(
			'material' => array(self::BELONGS_TO, 'Material', 'material_id'),
			'author'   => array(self::BELONGS_TO, 'User', 'author_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'content' => 'Comment',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'material_id' => 'Material',
		);
	}

	public function approve()
	{
		$this->status=Comment::STATUS_APPROVED;
		$this->update(array('status'));
	}

	public function getUrl($material=null)
	{
		if($material===null)
			$material=$this->material;
		return $material->url.'#c'.$this->id;
	}

	public function getAuthorLink()
	{
		return CHtml::link(CHtml::encode($this->author->username),array('/user/profile/view/', 'id'=>$this->author->id));
	}

	public function getPendingCommentCount()
	{
		return $this->count('status=:status', array(':status' => self::STATUS_PENDING));
	}

	public function findRecentComments($limit=10)
	{
		return $this->with('material')->findAll(array(
			'condition'=>'t.status=:status',
			'order'=>'t.create_time DESC',
			'limit'=>$limit,
			'params' => array(':status' => self::STATUS_APPROVED),
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
				$this->create_time=time();
				$this->author_id = Yii::app()->user->id;
			return true;
		}
		else
			return false;
	}
}
