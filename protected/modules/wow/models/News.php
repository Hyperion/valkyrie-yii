<?php

/**
 * This is the model class for table "armory.wow_news".
 *
 * The followings are the available columns in table 'armory.wow_news':
 * @property integer $id
 * @property string $image
 * @property string $header_image
 * @property string $title_de
 * @property string $title_en
 * @property string $title_es
 * @property string $title_fr
 * @property string $title_ru
 * @property string $desc_de
 * @property string $desc_en
 * @property string $desc_es
 * @property string $desc_fr
 * @property string $desc_ru
 * @property string $text_de
 * @property string $text_en
 * @property string $text_es
 * @property string $text_fr
 * @property string $text_ru
 * @property string $author
 * @property integer $postdate
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return News the static model class
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
		return '{{news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image, header_image, title_de, title_en, title_es, title_fr, title_ru, desc_de, desc_en, desc_es, desc_fr, desc_ru, text_de, text_en, text_es, text_fr, text_ru, author, postdate', 'required'),
			array('postdate', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, image, header_image, title_de, title_en, title_es, title_fr, title_ru, desc_de, desc_en, desc_es, desc_fr, desc_ru, text_de, text_en, text_es, text_fr, text_ru, author, postdate', 'safe', 'on'=>'search'),
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
            'commentCount' => array(self::STAT, 'BlogComments', 'blog_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'Image',
			'header_image' => 'Header Image',
			'title_de' => 'Title De',
			'title_en' => 'Title En',
			'title_es' => 'Title Es',
			'title_fr' => 'Title Fr',
			'title_ru' => 'Title Ru',
			'desc_de' => 'Desc De',
			'desc_en' => 'Desc En',
			'desc_es' => 'Desc Es',
			'desc_fr' => 'Desc Fr',
			'desc_ru' => 'Desc Ru',
			'text_de' => 'Text De',
			'text_en' => 'Text En',
			'text_es' => 'Text Es',
			'text_fr' => 'Text Fr',
			'text_ru' => 'Text Ru',
			'author' => 'Author',
			'postdate' => 'Postdate',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('header_image',$this->header_image,true);
		$criteria->compare('title_de',$this->title_de,true);
		$criteria->compare('title_en',$this->title_en,true);
		$criteria->compare('title_es',$this->title_es,true);
		$criteria->compare('title_fr',$this->title_fr,true);
		$criteria->compare('title_ru',$this->title_ru,true);
		$criteria->compare('desc_de',$this->desc_de,true);
		$criteria->compare('desc_en',$this->desc_en,true);
		$criteria->compare('desc_es',$this->desc_es,true);
		$criteria->compare('desc_fr',$this->desc_fr,true);
		$criteria->compare('desc_ru',$this->desc_ru,true);
		$criteria->compare('text_de',$this->text_de,true);
		$criteria->compare('text_en',$this->text_en,true);
		$criteria->compare('text_es',$this->text_es,true);
		$criteria->compare('text_fr',$this->text_fr,true);
		$criteria->compare('text_ru',$this->text_ru,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('postdate',$this->postdate);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}