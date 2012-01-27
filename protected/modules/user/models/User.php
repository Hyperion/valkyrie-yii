<?php

class User extends CActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_BANED    = -1;

    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var string $activkey
     * @var integer $createtime
     * @var integer $lastvisit
     * @var integer $superuser
     * @var integer $status
     */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
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
        return Yii::app()->getModule('user')->tableUsers;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.

        $rules = array();
        $rules[] = array('username', 'length', 'max'     => 20, 'min'     => 3, 'message' => UserModule::t("Incorrect username (length between 3 and 20 characters)."));
        $rules[] = array('password', 'length', 'max'     => 128, 'min'     => 4, 'message' => UserModule::t("Incorrect password (minimal length 4 symbols)."));
        $rules[] = array('email', 'email');
        $rules[] = array('username', 'unique', 'message' => UserModule::t("This user's name already exists."));
        $rules[] = array('email', 'unique', 'message' => UserModule::t("This user's email address already exists."));
        $rules[] = array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => UserModule::t("Incorrect symbols (A-z0-9)."));
        if (Yii::app()->getModule('user')->isAdmin())
        {
            $rules[] = array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANED));
            $rules[] = array('superuser', 'in', 'range' => array(0, 1));
            $rules[] = array('username, email, createtime, lastvisit, superuser, status', 'required');
            $rules[] = array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly' => true);
        }
        elseif (Yii::app()->user->id == $this->id)
            $rules[] = array('username, email', 'required');
        return $rules;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
        );
        if (isset(Yii::app()->getModule('user')->relations))
            $relations = array_merge($relations, Yii::app()->getModule('user')->relations);
        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'username'       => UserModule::t("username"),
            'password'       => UserModule::t("password"),
            'verifyPassword' => UserModule::t("Retype Password"),
            'email'          => UserModule::t("E-mail"),
            'verifyCode'     => UserModule::t("Verification Code"),
            'id'             => UserModule::t("Id"),
            'activkey'       => UserModule::t("activation key"),
            'createtime'     => UserModule::t("Registration date"),
            'lastvisit'      => UserModule::t("Last visit"),
            'superuser'      => UserModule::t("Superuser"),
            'status'         => UserModule::t("Status"),
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'status='.self::STATUS_ACTIVE,
            ),
            'notactvie' => array(
                'condition' => 'status='.self::STATUS_NOACTIVE,
            ),
            'banned'    => array(
                'condition' => 'status='.self::STATUS_BANED,
            ),
            'superuser' => array(
                'condition' => 'superuser=1',
            ),
            'notsafe'   => array(
                'select' => 'id, username, password, email, activkey, createtime, lastvisit, superuser, status',
            ),
        );
    }

    public function defaultScope()
    {
        return array(
            'select' => 'id, username, email, createtime, lastvisit, superuser, status',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => UserModule::t('Not active'),
                self::STATUS_ACTIVE   => UserModule::t('Active'),
                self::STATUS_BANED    => UserModule::t('Banned'),
            ),
            'AdminStatus'         => array(
                '0' => UserModule::t('No'),
                '1' => UserModule::t('Yes'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

}