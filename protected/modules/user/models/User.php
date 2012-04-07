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
        if (Yii::app()->user->isSuperuser)
        {
            $rules[] = array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANED));
            $rules[] = array('username, email, createtime, lastvisit, status', 'required');
            $rules[] = array('createtime, lastvisit, status', 'numerical', 'integerOnly' => true);
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
            'status'         => UserModule::t("Status"),
            'last_ip' => UserModule::t('Last Ip'),
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
            'notsafe'   => array(
                'select' => 'id, username, password, email, activkey, createtime, lastvisit, status, last_ip',
            ),
        );
    }

    public function defaultScope()
    {
        return array(
            'select' => 'id, username, email, createtime, lastvisit, status, last_ip',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('last_ip', $this->last_ip, true);

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
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

}