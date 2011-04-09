<?php

/**
 * This is the model class for table "{{blog_comments}}".
 *
 * The followings are the available columns in table '{{blog_comments}}':
 * @property integer $comment_id
 * @property integer $blog_id
 * @property integer $account
 * @property integer $character_guid
 * @property integer $realm_id
 * @property integer $postdate
 * @property string $comment_text
 * @property integer $answer_to
 */
class BlogComments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BlogComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{blog_comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('blog_id, account, realm_id, answer_to', 'required'),
			array('blog_id, account, character_guid, realm_id, postdate, answer_to', 'numerical', 'integerOnly'=>true),
			array('comment_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('comment_id, blog_id, account, character_guid, realm_id, postdate, comment_text, answer_to', 'safe', 'on'=>'search'),
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
            'blog' => array(self::BELONGS_TO, 'News', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'comment_id' => 'Comment',
			'blog_id' => 'Blog',
			'account' => 'Account',
			'character_guid' => 'Character Guid',
			'realm_id' => 'Realm',
			'postdate' => 'Postdate',
			'comment_text' => 'Comment Text',
			'answer_to' => 'Answer To',
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

		$criteria=new CDbCriteria;

		$criteria->compare('comment_id',$this->comment_id);
		$criteria->compare('blog_id',$this->blog_id);
		$criteria->compare('account',$this->account);
		$criteria->compare('character_guid',$this->character_guid);
		$criteria->compare('realm_id',$this->realm_id);
		$criteria->compare('postdate',$this->postdate);
		$criteria->compare('comment_text',$this->comment_text,true);
		$criteria->compare('answer_to',$this->answer_to);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}