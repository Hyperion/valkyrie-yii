<?php

class Menu extends CActiveRecord
{

    public function behaviors()
    {
        return array(
            'nestedSetBehavior' => array(
                'class'          => 'ext.yiiext.behaviors.model.trees.NestedSetBehavior',
                'leftAttribute'  => 'lft',
                'rightAttribute' => 'rgt',
                'levelAttribute' => 'level',
            ),
        );
    }

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
        return 'menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 100),
            array('alt', 'safe'),
            array('url', 'url'),
            array('url', 'unique', 'message' => 'Запись с таким УРЛ уже существует.'),
        );
    }

}
