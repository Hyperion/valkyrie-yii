<?php

class User extends CActiveRecord
{
    const STATUS_NOTACTIVE = 0;
    const STATUS_ACTIVATED = 1;
    const STATUS_ACTIVE_FIRST_VISIT = 2;
    const STATUS_ACTIVE = 3;
    const STATUS_BANNED = -1;
    const STATUS_REMOVED = -2;

    public $username;
    public $password;
    public $email;
    public $activationKey;
    public $password_changed = false;
    private $_friendshipTable;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function isOnline()
    {
        return $this->lastaction > time() - Yii::app()->getModule('user')->offlineIndicationTime;
    }

    public function setLastAction()
    {
        if(Yii::app()->user->isGuest)
        {
            $this->lastaction = time();
            return $this->save();
        }
    }

    public function getLogins()
    {
        $sql = "SELECT COUNT(*) FROM ACTIVITIES WHERE user_id = {$this->id} AND action = 'login'";
        $result = Yii::app()->db->createCommand($sql)->queryScalar();
        return $result;
    }

    public function logout()
    {
        if(!Yii::app()->user->isGuest) {
            $this->lastaction = 0;
            $this->save('lastaction');
        }
    }

    // This function tries to generate a as human-readable password as possible
    public static function generatePassword()
    {
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
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->together = true;
        $criteria->with = array('profile');
        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.username', $this->username, true);
        if ($this->profile)
            $criteria->compare('profile.email', $this->profile->email, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.superuser', $this->superuser);
        $criteria->compare('t.createtime', $this->createtime, true);
        $criteria->compare('t.lastvisit', $this->lastvisit, true);
        if (strlen($this->email))
            $criteria->addSearchCondition('profile.email',$this->email,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20),
        ));
    }

    public function beforeValidate()
    {
        if($this->isNewRecord)
            $this->createtime = time();

        return true;
    }

    public function setPassword($password)
    {
        if ($password != '') {
            $this->password = User::encrypt($password);
            $this->lastpasswordchange = time();
            $this->password_changed = true;
            return $this->save();
        }
    }

    public function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        $passwordRequirements = Yii::app()->getModule('user')->passwordRequirements;
        $usernameRequirements = Yii::app()->getModule('user')->usernameRequirements;

        $passwordrule = array_merge(array('password', 'PasswordValidator'), $passwordRequirements);

        $rules[] = $passwordrule;

        $rules[] = array('username', 'length',
                'max' => $usernameRequirements['maxLen'],
                'min' => $usernameRequirements['minLen'],
                'message' => Yii::t('UserModule.user',
                    'Username length needs to be between {minLen} and {maxlen} characters', array(
                        '{minLen}' => $usernameRequirements['minLen'],
                        '{maxLen}' => $usernameRequirements['maxLen'])));

        $rules[] = array('username',
                'unique',
                'message' => Yii::t('UserModule.user', "This user's name already exists."));
        $rules[] = array(
                'username',
                'match',
                'pattern' => $usernameRequirements['match'],
                'message' => Yii::t('UserModule.user', $usernameRequirements['dontMatchMessage']));
        $rules[] = array('status', 'in', 'range' => array(0, 1, 2, 3, -1, -2));
        $rules[] = array('superuser', 'in', 'range' => array(0, 1));
        $rules[] = array('username, createtime, lastvisit, lastpasswordchange, superuser, status', 'required');
        $rules[] = array('notifyType, avatar', 'safe');
        $rules[] = array('password', 'required', 'on' => array('insert'));
        $rules[] = array('createtime, lastvisit, lastaction, superuser, status', 'numerical', 'integerOnly' => true);

        $rules[] = array('avatar', 'required', 'on' => 'avatarUpload');

        $rules[] = array('avatar', 'EPhotoValidator',
                'allowEmpty' => true,
                'mimeType' => array('image/jpeg', 'image/png', 'image/gif'),
                'maxWidth' => Yii::app()->getModule('user')->avatarMaxWidth,
                'maxHeight' => Yii::app()->getModule('user')->avatarMaxWidth,
                'minWidth' => 50,
                'minHeight' => 50,
                'on' => 'avatarSizeCheck');
        return $rules;
    }

    public function relations()
    {
        return array(
                'messages' => array(self::HAS_MANY, 'Message', 'to_user_id', 'order' => 'messages.id DESC'),
                'sent_messages' => array(self::HAS_MANY, 'Message', 'from_user_id'),
                'visits' => array(self::HAS_MANY, 'ProfileVisit', 'visited_id'),
                'visited' => array(self::HAS_MANY, 'ProfileVisit', 'visitor_id'),
                'profile' => array(self::HAS_ONE, 'Profile', 'user_id' ),
                'friendships' => array(self::HAS_MANY, 'Friendship', 'inviter_id'),
                'friendships2' => array(self::HAS_MANY, 'Friendship', 'friend_id'),
                'friendship_requests' => array(self::HAS_MANY, 'Friendship', 'friend_id', 'condition' => 'status = 1'), // 1 = FRIENDSHIP_REQUEST
                );
    }

    public function isFriendOf($invited_id)
    {
        foreach ($this->getFriendships() as $friendship)
        {
            if ($friendship->inviter_id == $this->id && $friendship->friend_id == $invited_id)
                return $friendship->status;
        }

        return false;
    }

    public function getFriendships()
    {
        $condition = 'inviter_id = :uid or friend_id = :uid';
        return Friendship::model()->findAll($condition, array(
            ':uid' => $this->id));
    }

    // Friends can not be retrieve via the relations() method because a friend
    // can either be in the invited_id or in the friend_id column.
    // set $everything to true to also return pending and rejected friendships
    public function getFriends($everything = false)
    {
        if ($everything)
            $condition = 'inviter_id = :uid';
        else
            $condition = 'inviter_id = :uid and status = 2';

        $friends = array();
        $friendships = Friendship::model()->findAll($condition, array(
                    ':uid' => $this->id));
        if ($friendships != NULL && !is_array($friendships))
            $friendships = array($friendships);

        if ($friendships)
            foreach ($friendships as $friendship)
                $friends[] = User::model()->findByPk($friendship->friend_id);

        if ($everything)
            $condition = 'friend_id = :uid';
        else
            $condition = 'friend_id = :uid and status = 2';

        $friendships = Friendship::model()->findAll($condition, array(
                    ':uid' => $this->id));

        if ($friendships != NULL && !is_array($friendships))
            $friendships = array($friendships);


        if ($friendships)
            foreach ($friendships as $friendship)
                $friends[] = User::model()->findByPk($friendship->inviter_id);

        return $friends;
    }

    public function register($username=null, $password=null, $profile)
    {
        if ($username !== null && $password !== null)
        {
            $this->username = $username;
            $this->password = $this->encrypt($password);
        }

        $this->activationKey = $this->generateActivationKey(false, $password);
        $this->createtime = time();
        $this->superuser = 0;

        $this->status = User::STATUS_ACTIVATED;

        if($this->save())
        {
            $profile->user_id = $this->id;
            $profile->save();
            return true;
        }

        return false;
    }

    public function isPasswordExpired() {
        $distance = Yii::app()->getModule('user')->password_expiration_time * 60 * 60;
        return $this->lastpasswordchange - $distance > time();
    }

    public function activate($email=null, $key=null) {
        if ($email != null && $key != null) {
            if($profile = Profile::model()->find("email = '{$email}'")) {
                if($user = $profile->user) {
                    if ($user->status != self::STATUS_NOTACTIVE)
                        return false;
                    if ($user->activationKey == $key) {
                        $user->activationKey = $user->generateActivationKey(true);
                        $user->status = self::STATUS_ACTIVATED;
                        if($user->save(false, array('activationKey', 'status'))) {
                            Message::write($user, 1,
                                    Yii::t('UserModule.user', 'Your activation succeeded'),
                                    TextSettings::getText('text_email_activation', array(
                                            '{username}' => $user->username,
                                            '{link_login}' =>
                                            Yii::app()->controller->createUrl('//user/user/login'))));
                        }
                        return $user;
                    }
                }
            }
        }
        return false;
    }

    public function generateActivationKey($activate=false, $password='', array $params=array()) {
        return $activate ? User::encrypt(microtime()) : User::encrypt(microtime() . $this->password);
    }

    public function attributeLabels() {
        return array(
                'id' => Yii::t('UserModule.user', '#'),
                'username' => Yii::t('UserModule.user', "Username"),
                'password' => Yii::t('UserModule.user', "Password"),
                'verifyPassword' => Yii::t('UserModule.user', "Retype password"),
                'verifyCode' => Yii::t('UserModule.user', "Verification code"),
                'activationKey' => Yii::t('UserModule.user', "Activation key"),
                'createtime' => Yii::t('UserModule.user', "Registration date"),
                'lastvisit' => Yii::t('UserModule.user', "Last visit"),
                'lastaction' => Yii::t('UserModule.user', "Online status"),
                'superuser' => Yii::t('UserModule.user', "Superuser"),
                'status' => Yii::t('UserModule.user', "Status"),
                'avatar' => Yii::t('UserModule.user', "Avatar image"),
                );
    }

    public static function encrypt($string = "") {
        $salt = Yii::app()->getModule('user')->salt;
        $hashFunc = Yii::app()->getModule('user')->hashFunc;
        $string = sprintf("%s%s", $string, $salt);

        if (!function_exists($hashFunc))
            throw new CException('Function `' . $hashFunc . '` is not a valid callback for hashing algorithm.');

        return $hashFunc($string);
    }

    public function scopes() {
        return array(
            'active' => array('condition' => 'status=' . self::STATUS_ACTIVE,),
            'activefirstvisit' => array('condition' => 'status=' . self::STATUS_ACTIVE_FIRST_VISIT,),
            'notactive' => array('condition' => 'status=' . self::STATUS_NOTACTIVE,),
            'banned' => array('condition' => 'status=' . self::STATUS_BANNED,),
            'superuser' => array('condition' => 'superuser=1',),
        );
    }

    public static function itemAlias($type, $code=NULL) {
        $_items = array(
            'UserStatus' => array(
                '0' => Yii::t('UserModule.user', 'Not active'),
                '1' => Yii::t('UserModule.user', 'Activated, not yet logged in once'),
                '2' => Yii::t('UserModule.user', 'Active - first visit'),
                '3' => Yii::t('UserModule.user', 'Active'),
                '-1' => Yii::t('UserModule.user', 'Banned'),
                '-2' => Yii::t('UserModule.user', 'Deleted'),
            ),
            'AdminStatus' => array(
                '0' => Yii::t('UserModule.user', 'No'),
                '1' => Yii::t('UserModule.user', 'Yes'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    public static function getAdmins() {
        $admins = User::model()->active()->superuser()->findAll();
        $returnarray = array();
        foreach ($admins as $admin)
            array_push($returnarray, $admin->username);
        return $returnarray;
    }

    public function getAvatar($thumb = false) {
        if($this->profile) {
            $return = '<div class="avatar">';

            $options = array();
            if ($thumb)
                $options = array('style' => 'width: 50px; height:50px;');
            else
                $options = array('style' => 'width: '.Yii::app()->getModule('user')->avatarDisplayWidth.'px;');

            if (isset($this->avatar) && $this->avatar)
                $return .= CHtml::image(Yii::app()->baseUrl . '/'
                        . $this->avatar, 'Avatar', $options);
            else
                $return .= CHtml::image(Yii::app()->getAssetManager()->publish(
                            Yii::getPathOfAlias('application.modules.user.assets.images') . ($thumb ? '/no_avatar_available_thumb.jpg' : '/no_avatar_available.jpg'),
                            Yii::t('UserModule.user', 'No image available'), array(
                                'title' => Yii::t('UserModule.user', 'No image available'))));
            $return .= '</div><!-- avatar -->';
            return $return;
        }
    }
}
