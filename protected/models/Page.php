<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $title
 * @property string $alt
 * @property string $url
 * @property string $short_text
 * @property string $text
 * @property string $meta
 * @property string $keywords
 */
class Page extends CActiveRecord
{

    public $russian = array("а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", "ь", "э", "ю", "я", ' ', '.', ',', '?', '/', '|', '\\', '%', '$', '@', '#', '*', '^', '(', ')', ';', ':', '"', '!');
    public $trans = array("a", "b", "v", "g", "d", "e", "yo", "zh", "z", "i", "j", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "c", "ch", "sh", "shh", "", "y", "", "e", "yu", "ya", '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
    
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
            array('meta, keywords', 'length', 'max' => 150),
            array('alt, url', 'safe'),
            array('url', 'unique', 'message' => 'Запись с таким ЧПУ уже существует.'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alt, url, text, meta, keywords', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'title'      => 'Название',
            'alt'        => 'Подсказка',
            'text'       => 'Текст',
            'meta'       => 'Meta-теги',
            'keywords'   => 'Ключевые слова',
            'url'        => 'ЧПУ',
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
        $criteria->compare('meta', $this->meta, true);
        $criteria->compare('keywords', $this->keywords, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria'   => $criteria,
                    'pagination' => (!$size) ? false : array(
                        'pageSize' => $size,
                            ),
                ));
    }

    protected function beforeValidate()
    {
        if (!$this->url)
            $this->url = str_ireplace($this->russian, $this->trans, mb_strtolower($this->title, 'utf8'));
        return parent::beforeValidate();
    }

}
