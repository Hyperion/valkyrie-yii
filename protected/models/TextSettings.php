<?php
class TextSettings extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{text_settings}}';
	}

	public function rules()
	{
		return array(
			array('language, name, text', 'required'),
			array('language', 'length', 'max'=>2),
			array('name', 'length', 'max'=>50),
			array('id, language, name, text', 'safe', 'on'=>'search'),
		);
	}

    public static function getText($title, $trans = array(), $language = NULL)
	{
        if(!is_array($trans))
            return false;

        if(is_null($language))
            $language = Yii::app()->language;

        if($text = self::model()->find('language = :language AND title = :title', array(
                        ':language' => $language,
						':title'     => $title)));

        if(isset($text->text))
            return strtr($text->text, $trans);

        return false;
    }

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'language' => 'Language',
			'name' => 'Name',
			'text' => 'Text',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
