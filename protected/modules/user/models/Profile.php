<?php

class Profile extends CActiveRecord
{
    const PRIVACY_PRIVATE = 'private';
    const PRIVACY_PUBLIC = 'public';

    static $fields=null;

    public function init()
    {
        parent::init();
        $this->loadProfileFields();
    }

    public function recentComments($count = 3)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id = ' .$this->id;
        $criteria->order = 'createtime DESC';
        $criteria->limit = $count;
        return ProfileComment::model()->findAll($criteria);
    }

    public function beforeValidate() {
        $this->timestamp = time();
        return parent::beforeValidate();
    }

    /**
     * @param string $className
     * @return Profile
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    // be obtained and returned for the use in the profile view
    public function getPublicFields()
    {
        $fields = array();

        foreach(ProfileField::model()->findAll() as $field) {
            if($field->visible != 0)
                $fields[] = $field;
        }

        return $fields;
    }

    public function tableName()
    {
        return 'profiles';
    }

    public function rules()
    {
        $required = array();
        $numerical = array();
        $rules = array();
        $safe = array();

        foreach (self::$fields as $field)
        {
            $field_rule = array();

            if ($field->required == 1)
                array_push($required, $field->varname);

            if ($field->field_type == 'int'
                    || $field->field_type == 'FLOAT'
                    || $field->field_type =='INTEGER')
                array_push($numerical,$field->varname);

            if ($field->field_type == 'DROPDOWNLIST')
                array_push($safe, $field->varname);

            if ($field->field_type =='VARCHAR'
                    ||$field->field_type=='TEXT')
            {
                $field_rule = array($field->varname,
                        'length',
                        'max'=>$field->field_size,
                        'min' => $field->field_size_min);

                if ($field->error_message)
                    $field_rule['message'] = Yii::t('UserModule.user', $field->error_message);
                array_push($rules,$field_rule);
            }

            if ($field->field_type=='DATE')
            {
                $field_rule = array($field->varname,
                        'type',
                        'type' => 'date',
                        'dateFormat' => 'yyyy-mm-dd');

                if ($field->error_message)
                    $field_rule['message'] = Yii::t('UserModule.user',  $field->error_message);
                array_push($rules,$field_rule);
            }

            if ($field->match)
            {
                $field_rule = array($field->varname,
                        'match',
                        'pattern' => $field->match);

                if ($field->error_message)
                    $field_rule['message'] = Yii::t('UserModule.user',  $field->error_message);
                array_push($rules,$field_rule);
            }
            if ($field->range)
            {
                // allow using commas and semicolons
                $range=explode(';',$field->range);
                if(count($range)===1)
                    $range=explode(',',$field->range);
                $field_rule = array($field->varname,'in','range' => $range);

                if ($field->error_message)
                    $field_rule['message'] = Yii::t('UserModule.user',  $field->error_message);
                array_push($rules,$field_rule);
            }

            if ($field->other_validator)
            {
                $field_rule = array($field->varname,
                        $field->other_validator);

                if ($field->error_message)
                    $field_rule['message'] = Yii::t('UserModule.user',  $field->error_message);
                array_push($rules, $field_rule);
            }

        }

        array_push($rules,
                array(implode(',',$required), 'required'));
        array_push($rules,
                array(implode(',',$numerical), 'numerical', 'integerOnly'=>true));
        array_push($rules,
                array(implode(',',$safe), 'safe'));

        $rules[] = array('allow_comments, show_friends', 'numerical');

        return $rules;
    }

    public function relations()
    {
        $relations = array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'comments' => array(self::HAS_MANY, 'ProfileComment', 'profile_id'),
        );

        $fields = Yii::app()->db->createCommand(
                "SELECT * FROM ".ProfileField::model()->tableName()." WHERE field_type = 'DROPDOWNLIST'")->queryAll();

        foreach($fields as $field) {
            $relations[ucfirst($field['varname'])] = array(
                    self::BELONGS_TO, ucfirst($field['varname']), $field['varname']);

        }

        return $relations;

    }

    public function getProfileCommentators()
    {
        $commentators = array();
        foreach($this->comments as $comment)
            if($comment->user_id != Yii::app()->user->id)
                $commentators[$comment->user_id] = $comment->user;

        return $commentators;
    }

    public function attributeLabels()
    {
        $labels = array(
            'id' => Yii::t('UserModule.user', 'Profile ID'),
            'user_id' => Yii::t('UserModule.user', 'User ID'),
            'show_friends' => Yii::t('UserModule.user', 'Show friends'),
            'allow_comments' => Yii::t('UserModule.user', 'Allow profile comments'),
        );

        if(self::$fields)
            foreach (self::$fields as $field)
                $labels[$field->varname] = Yii::t('UserModule.user', $field->title);

        return $labels;
    }

    public function loadProfileFields()
    {
        if(self::$fields===null)
        {
            self::$fields=ProfileField::model()->findAll();
            if(self::$fields==null)
                self::$fields=array();
        }
        return self::$fields;
    }
}
