<?php

class Database extends BActiveRecord
{

    static public $realm;
    static public $connection = array();
    static protected $_items = array(
        'type' => array(
            'realm'   => 'Realmlist',
            'char'    => 'Characters',
            'world'   => 'World'
        ),
        'adapter' => array('mysql' => 'MySql'),
    );

    public function tableName()
    {
        return 'wow_databases';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('host, name, type, adapter, host', 'required'),
            array('username, password', 'safe'),
            array('host, name, username, database', 'length', 'max' => 32),
            array('password', 'length', 'max' => 256),
            array('type', 'in', 'range' => array_keys(self::itemAlias('type'))),
            array('adapter', 'in', 'range' => array_keys(self::itemAlias('adapter'))),
            array('password', 'checkConnection'),
        );
    }

    public function checkConnection($attribute, $params)
    {
        if($this->$attribute)
            try
            {
                $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
                $db  = new PDO($dsn, $this->username, $this->password);
                $db  = null;
            }
            catch(PDOException $e)
            {
                $this->addError($attribute, $e->getMessage());
            }
    }

    public function attributeLabels()
    {
        return array(
            'id'       => '#',
            'name'     => WowModule::t('Name'),
            'host'     => WowModule::t('Host'),
            'username' => WowModule::t('User'),
            'password' => WowModule::t('Password'),
            'database' => WowModule::t('Database'),
            'adapter'  => WowModule::t('Adapter'),
            'type'     => WowModule::t('Type'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('adapter', $this->adapter);
        $criteria->compare('database', $this->database);
        $criteria->compare('host', $this->host);
        $criteria->compare('username', $this->username);

        return new CActiveDataProvider(get_class($this), array(
                'criteria' => $criteria,
            ));
    }

    public static function getConnection($name = 'Realmlist')
    {
        if(isset(self::$connection[$name]) and (self::$connection[$name] instanceof CDbConnection))
            return self::$connection[$name];

        $model = self::model()->find(array(
            'select'    => "*, AES_DECRYPT(password, 'cherepica') as password",
            'condition' => 'name = :name',
            'params'    => array(':name' => $name),
            ));

        $dsn = 'mysql:host=' . $model->host . ';dbname=' . $model->database;

        $db = new CDbConnection($dsn, $model->username, $model->password);
        $db->queryCachingDuration = 300;
        $db->schemaCachingDuration = 60*60*24*365;
        $db->active = true;
        $db->charset = 'utf8';
        if(YII_DEBUG)
        {
            $db->enableProfiling = true;
            $db->enableParamLogging = true;
        }
        self::$connection[$name] = $db;

        return $db;
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->password)
            {
                $this->password = new CDbExpression("AES_ENCRYPT('{$this->password}', 'cherepica')");
            }
            return true;
        }
        else
            return false;
    }

    protected function afterSave()
    {
        if($this->type == 'realm')
            foreach(Realmlist::model()->findAll() as $realmlist)
            {
                $model = new Database;
                $model->name = $realmlist->name;
                $model->host = $realmlist->address;
                $model->type = 'char';
                $model->adapter = $this->adapter;

                $model->save();
            }
    }
}
