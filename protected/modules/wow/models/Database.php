<?php

/**
 * This is the model class for table "wow_databases".
 *
 * The followings are the available columns in table 'wow_databases':
 * @property string $id
 * @property string $title
 * @property string $dbname
 * @property string $host
 * @property string $user
 * @property string $password
 * @property string $type
 */

class Database extends CActiveRecord
{
	static public $realm;
	static public $connection = array();

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'wow_databases';
	}

	public function rules()
	{
		return array(
			array('host, dbname, user, password', 'required', 'on'=>'create'),
			array('title', 'length', 'max'=>255),
			array('host, dbname, user', 'length', 'max'=>32),
			array('password', 'length', 'max'=>256),
			array('type', 'in', 'range'=>array('realmlist', 'characters')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'ip' => 'Ip',
			'user' => 'User',
			'password' => 'Password',
			'type' => 'Type',
		);
	}

	public static function getConnection($realm = 'realmlist')
	{
		if(isset(self::$connection[$realm]) and (self::$connection[$realm] instanceof CDbConnection))
            return self::$connection[$realm];

		$model = self::findWithPass($realm);

        $dsn = 'mysql:host='.$model->host.';dbname='.$model->dbname;

        $db = new CDbConnection($dsn, $model->user, $model->password);
        $db->queryCachingDuration = 300;
        $db->active = true;
        $db->charset = 'utf8';
        
        self::$connection[$realm] = $db;

        return $db;
	}
 
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->password = new CDbExpression("AES_ENCRYPT('{$this->password}', 'cherepica')");
			return true;
		}
		else return false;
	}
	
	public static function findWithPass($title = 'realmlist')
	{
		return self::model()->find(array(
			'select' => "*, AES_DECRYPT(password, 'cherepica') as password",
			'condition'=>'title = :title',
    		'params'=>array(':title'=>$title),
		));
	}
}
