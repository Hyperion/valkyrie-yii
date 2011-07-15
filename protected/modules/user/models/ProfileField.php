<?php
class ProfileField extends CActiveRecord
{
    const VISIBLE_NO=0;
    const VISIBLE_ONLY_OWNER=1;
    const VISIBLE_REGISTER_USER=2;
    const VISIBLE_ALL=4;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function isPublic($user = null) {
        if($user == null)
            $user = Yii::app()->user->id;

        if(!$this->visible)
            return false;

        if($privacy = User::model()->findByPk($user)->privacy) {
            if($privacy->public_profile_fields & pow(2, $this->id))
                return true;
        }

        return false;
    }

    public function tableName()
    {
        return 'profile_fields';
    }

    public function rules()
    {
        return array(
            array('varname, title, field_type', 'required'),
            array('varname', 'match', 'pattern' => '/^[a-z_0-9]+$/u','message' => Yii::t("UserModule.user", "Incorrect symbol's. (a-z)")),
            array('varname', 'unique', 'message' => Yii::t("UserModule.user", "This field already exists.")),
            array('varname, field_type', 'length', 'max'=>50),
            array('field_size, field_size_min, required, position, visible', 'numerical', 'integerOnly'=>true),
            array('hint','safe'),
            array('related_field_name, title, match, range, error_message, other_validator, default', 'length', 'max'=>255),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('UserModule.user', '#'),
            'varname' => Yii::t('UserModule.user', 'Variable name'),
            'title' => Yii::t('UserModule.user', 'Title'),
            'hint' => Yii::t('UserModule.user', 'Hint'),
            'field_type' => Yii::t('UserModule.user', 'Field type'),
            'field_size' => Yii::t('UserModule.user', 'Field size'),
            'field_size_min' => Yii::t('UserModule.user', 'Field size min'),
            'required' => Yii::t('UserModule.user', 'Required'),
            'match' => Yii::t('UserModule.user', 'Match'),
            'range' => Yii::t('UserModule.user', 'Range'),
            'error_message' => Yii::t('UserModule.user', 'Error message'),
            'other_validator' => Yii::t('UserModule.user', 'Other validator'),
            'default' => Yii::t('UserModule.user', 'Default'),
            'position' => Yii::t('UserModule.user', 'Position'),
            'visible' => Yii::t('UserModule.user', 'Visible'),
        );
    }

    public function scopes()
    {
        return array(
            'forAll'=>array(
                'condition'=>'visible='.self::VISIBLE_ALL,
            ),
            'forUser'=>array(
                'condition'=>'visible>='.self::VISIBLE_REGISTER_USER,
            ),
            'forOwner'=>array(
                'condition'=>'visible>='.self::VISIBLE_ONLY_OWNER,
            ),
            'forRegistration'=>array(
                'condition'=>'required>0',
            ),
            'sort'=>array(
                'order'=>'t.position ASC',
            ),

        );
    }


    public static function itemAlias($type,$code=NULL)
    {
        $_items = array(
            'field_type' => array(
                'INTEGER' => Yii::t('UserModule.user', 'INTEGER'),
                'VARCHAR' => Yii::t('UserModule.user',  'VARCHAR'),
                'TEXT'=> Yii::t('UserModule.user',  'TEXT'),
                'DATE'=> Yii::t('UserModule.user',  'DATE'),
                'DROPDOWNLIST' => Yii::t('UserModule.user', 'DROPDOWNLIST'),
                'FLOAT'=> Yii::t('UserModule.user', 'FLOAT'),
                'BOOL'=> Yii::t('UserModule.user', 'BOOL'),
                'BLOB'=> Yii::t('UserModule.user', 'BLOB'),
                'BINARY'=> Yii::t('UserModule.user', 'BINARY'),
                'FILE'=> 'FILE',
            ),
            'required' => array(
                '0' => Yii::t('UserModule.user', 'No'),
                '2' => Yii::t('UserModule.user', 'No, but show on registration form'),
                '1' => Yii::t('UserModule.user', 'Yes and show on registration form'),
            ),
            'visible' => array(
                self::VISIBLE_ALL => Yii::t('UserModule.user', 'For all'),
                self::VISIBLE_REGISTER_USER => Yii::t('UserModule.user', 'Registered users'),
                self::VISIBLE_ONLY_OWNER => Yii::t('UserModule.user', 'Only owner'),
                '0' => Yii::t('UserModule.user', 'Hidden'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}
