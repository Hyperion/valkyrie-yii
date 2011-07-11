<?php

class Account extends CActiveRecord
{
    public $password;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Database::getConnection();
    }

    public function tableName()
    {
        return 'account';
    }

    public function rules()
    {
        return array(
            array('locale, gmlevel, mutetime, locked', 'numerical', 'integerOnly'=>true),
            array('username', 'length', 'max'=>32),
            array('username, password', 'required', 'on'=>'login'),
            array('password', 'authenticate', 'on'=>'login'),
            array('locale, email', 'required', 'on'=>'update, create, edit'),
            array('username, password', 'required', 'on'=>'create'),
            //array('username, email', 'recoveryInfo', 'on'=>'recovery'),
            array('gmlevel, mutetime, locked', 'required', 'on'=>'update'),
            array('username', 'safe', 'on'=>'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'sha_pass_hash' => 'Password',
            'gmlevel' => 'Gmlevel',
            'sessionkey' => 'Sessionkey',
            'v' => 'V',
            's' => 'S',
            'email' => 'Email',
            'joindate' => 'Joindate',
            'last_ip' => 'Last Ip',
            'failed_logins' => 'Failed Logins',
            'locked' => 'Locked',
            'last_login' => 'Last Login',
            'active_realm_id' => 'Active Realm',
            'mutetime' => 'Mutetime',
            'locale' => 'Locale',
            'loc_selection' => 'Loc Selection',
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('username',$this->username,true);
        $criteria->compare('sha_pass_hash',$this->sha_pass_hash,true);
        $criteria->compare('gmlevel',$this->gmlevel);
        $criteria->compare('sessionkey',$this->sessionkey,true);
        $criteria->compare('v',$this->v,true);
        $criteria->compare('s',$this->s,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('joindate',$this->joindate,true);
        $criteria->compare('last_ip',$this->last_ip,true);
        $criteria->compare('failed_logins',$this->failed_logins,true);
        $criteria->compare('locked',$this->locked);
        $criteria->compare('last_login',$this->last_login,true);
        $criteria->compare('active_realm_id',$this->active_realm_id,true);
        $criteria->compare('mutetime',$this->mutetime,true);
        $criteria->compare('locale',$this->locale);
        $criteria->compare('loc_selection',$this->loc_selection);

       return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    public function userRelated()
    {

        $criteria=new CDbCriteria;
        $criteria->addInCondition('id', Yii::app()->user->accounts);
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    protected function beforeSave()
    {
        if(parent::beforeSave())
        {
            if($this->password)
                $this->sha_pass_hash = strtoupper(sha1(strtoupper($this->username).":".strtoupper($this->password)));
            if($this->locale != 0)
                $this->loc_selection = 1;
            else
                $this->loc_selection = 0;
            return true;
        }
        else
            return false;
    }

    public function authenticate($attribute,$params)
    {
        $sha_pass_hash = strtoupper(sha1(strtoupper($this->username).":".strtoupper($this->password)));
        $model = self::model()->find('username=:username', array(':username'=>$this->username));
        if($model===null)
        {
            $this->addError('password','Incorrect username.');
            return;
        }
        $this->attributes = $model->attributes;
        $this->id = $model->id;
        if($sha_pass_hash != strtoupper($model->sha_pass_hash))
            $this->addError('password','Incorrect password.');

        $c = Yii::app()->db->createCommand()->select('count(1)')->from('{{user_accounts}}')->where('account_id = :id', array(':id' => $this->id))->queryScalar();
        if($c > 0)
            $this->addError('username','This account is already used!');

        $this->setIsNewRecord(false);
    }

    /*public function recoveryInfo($attribute,$params)
    {
        $model = self::model()->find('username=:username OR email=:email',
            array(':username'=>$this->username, ':email'=>$this->email));
        if($model===null)
        {
            $this->addError('password','Can not find username or email.');
            return;
        }
        $this->attributes = $model->attributes;
        $this->id = $model->id;
        $this->setIsNewRecord(false);
    }

    public static function generatePassword() {
        $consonants = array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
        $vocals = array("a","e","i","o","u");

        $password = '';

        srand((double) microtime() * 1000000);
        for ($i = 1; $i <= 4; $i++) {
            $password .= $consonants[rand(0, 19)];
            $password .= $vocals[rand(0, 4)];
        }
        $password .= rand(0, 9);

        return $password;
    }*/

    public function saveUserRelation()
    {
        $c = Yii::app()->db
            ->createCommand('INSERT INTO {{user_accounts}} (user_id, account_id) VALUES (:user_id, :account_id)');
        $userId = Yii::app()->user->id;
        $accountId = $this->id;
        $c->bindParam(':user_id', $userId);
        $c->bindParam(':account_id', $accountId);
        $c->execute();
    }
}
