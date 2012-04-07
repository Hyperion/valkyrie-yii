<?php

class Page extends CActiveRecord
{

     /**
     * Returns the static model of the specified AR class.
     * @return Pages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, text', 'required', 'message' => '{attribute} - Не может быть пустым'),
            array('title', 'length', 'max' => 100),
            array('description, keywords', 'length', 'max' => 150),
            array('alt, url', 'safe'),
            array('url', 'unique', 'message' => 'Запись с таким ЧПУ уже существует.'),
            array('url','ext.yiiext.components.translit.ETranslitFilter','translitAttribute'=>'title'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alt, url, text, description, keywords', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'title'       => 'Название',
            'alt'         => 'Подсказка',
            'text'        => 'Текст',
            'description' => 'Описание',
            'keywords'    => 'Ключевые слова',
            'url'         => 'ЧПУ',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($size = 15)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('keywords', $this->keywords, true);

        return new CActiveDataProvider(get_class($this), array(
                'criteria'   => $criteria,
                'pagination' => (!$size) ? false : array(
                    'pageSize' => $size,
                    ),
            ));
    }
}
