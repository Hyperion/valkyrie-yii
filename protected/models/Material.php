<?php

class Material extends CActiveRecord
{
	const STATUS_DRAFT     = 'draft';
	const STATUS_PUBLISHED = 'published';
	const STATUS_ARCHIVED  = 'archived';

	const TYPE_NEWS	       = 'news';
	const TYPE_POST        = 'post'; 

	private $_oldTags;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{materials}}';
	}

	public function rules()
	{
		return array(
			array('title, content, status', 'required'),
			array('status', 'in', 'range'=>array(
				self::STATUS_DRAFT,
				self::STATUS_PUBLISHED,
				self::STATUS_ARCHIVED)),
			array('type' , 'in', 'range'=>array(
				self::TYPE_NEWS,
				self::TYPE_POST)),
			array('title', 'length', 'max'=>128),
			array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 
				'message'=>'Tags can only contain word characters.'),
			array('tags', 'normalizeTags'),
			array('img', 'safe'),
			array('category_id', 'required', 'on' => 'post'),
			array('title, status', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'category'=> array(self::BELONGS_TO, 'Category', 'category_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'material_id',
			     'condition'=>'comments.status=:status',
			     'params' => array(':status' => Comment::STATUS_APPROVED),
			     'order'=>'comments.create_time DESC'),
			'commentCount' => array(self::STAT, 'Comment', 'material_id',
			     'condition'=>'status=:status',
			     'params' => array(':status' => Comment::STATUS_APPROVED)),
			'rating' => array(self::STAT, 'Vote', 'material_id', 'select'=>'SUM(value)',),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
			'content' => 'Content',
			'tags' => 'Tags',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'author_id' => 'Author',
			'category_id' => 'Category',
		);
	}

	public function getUrl()
	{
		return Yii::app()->createUrl($this->type.'/view', array(
			'id'=>$this->id,
			'title'=>$this->title,
		));
	}

	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('post/index', 'tag'=>$tag));
		return $links;
	}

	public function normalizeTags($attribute,$params)
	{
		$this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
	}

	public function addComment($comment)
	{
		if(Yii::app()->params['commentNeedApproval'])
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		return $comment->save();
	}

	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->tags;
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->type = self::TYPE_POST;
				$this->create_time=$this->update_time=time();
				$this->author_id=Yii::app()->user->id;
			}
			else
				$this->update_time=time();
			return true;
		}
		else
			return false;
	}

	protected function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->tags);
	}

	protected function afterDelete()
	{
		parent::afterDelete();
		Comment::model()->deleteAll('material_id='.$this->id);
		Tag::model()->updateFrequency($this->tags, '');
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('type', $this->type,true);

		return new CActiveDataProvider('Material', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'status, update_time DESC',
			),
		));
	}

	public function findRecentPosts($limit=10)
	{
		return $this->with('category')->findAll(array(
			'condition'=>'status="'.self::STATUS_PUBLISHED.'" AND type="'.self::TYPE_POST.'"',
			'order'=>'create_time DESC',
			'limit'=>$limit,
		));
	}
}
