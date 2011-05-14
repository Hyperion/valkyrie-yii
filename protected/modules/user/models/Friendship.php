<?php

class Friendship extends CActiveRecord
{
	const FRIENDSHIP_NONE = 0; 
	const FRIENDSHIP_REQUEST = 1;
	const FRIENDSHIP_ACCEPTED = 2;
	const FRIENDSHIP_REJECTED = 3;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function requestFriendship($inviter, $invited, $message = null) {
		if(!is_object($inviter))
			$inviter = User::model()->findByPk($inviter);

		if(!is_object($invited))
			$invited = User::model()->findByPk($invited);

		if($inviter->id == $invited->id)
			return false;

		$friendship_status = $inviter->isFriendOf($invited);

		if($friendship_status !== false)  {
			if($friendship_status == 1)
				$this->addError('invited_id', Yii::t('UserModule.user', 'Friendship request already sent'));
			if($friendship_status == 2)
				$this->addError('invited_id', Yii::t('UserModule.user', 'Users already are friends'));
			if($friendship_status == 3)
				$this->addError('invited_id', Yii::t('UserModule.user', 'Friendship request has been rejected '));

			return false;
		}

		$this->inviter_id = $inviter->id;
		$this->friend_id = $invited->id;
		$this->acknowledgetime = 0;
		$this->requesttime = time();
		$this->updatetime = time();

		if($message !== null)
			$this->message = $message;
		$this->status = 1;
		return $this->save();
	} 

	// How many friendship requests have been made in month $month of year $year?
	public static function countRequest($month = null, $year = null) {
		$timestamp = mktime(0, 0, 0, $month, 1, $year);
		$timestamp2 = mktime(0, 0, 0, $month + 1, 1, $year);
		if($month === null) {
			$timestamp = 0;
			$timestamp2 = time();
		}


		$sql = "select count(*) from friendship where requesttime > {$timestamp} and requesttime < {$timestamp2}";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		return $result[0]['count(*)'];
	}

	public function acceptFriendship() {
		$this->acknowledgetime = time();
		$this->status = 2;
		if(isset($this->inviter->privacy) 
				&& $this->inviter->privacy->message_new_friendship) {
			Message::write($this->inviter, $this->invited,
					Yii::t('UserModule.user', 'Your friendship request has been accepted'),
					TextSettings::getText('text_friendship_confirmed', array(
							'{username}' => $this->inviter->username)));
		}
		return $this->save();
	} 

	public function getFriend() {
		if($this->friend_id == Yii::app()->user->id)
			return $this->inviter->username;
		else
			return $this->invited->username;
	}

	public function getStatus() {
		switch($this->status) {
			case '0':
				return Yii::t('UserModule.user', 'No friendship requested');
			case '1':
				return Yii::t('UserModule.user', 'Confirmation pending');
			case '2':
				return Yii::t('UserModule.user', 'Friendship confirmed');
			case '3':
				return Yii::t('UserModule.user', 'Friendship rejected');

		}
	}

	public function rejectFriendship() {
		$this->acknowledgetime = time();
		$this->status = 3;
		return($this->save());
	} 

	public function ignoreFriendship() {
		$this->acknowledgetime = time();
		$this->status = 0;
		return($this->save());
	} 

	public function tableName()
	{
		return '{{friendship}}';
	}

	public function rules()
	{
		return array(
				array('inviter_id, friend_id, status, requesttime, acknowledgetime, updatetime', 'required'),
				array('inviter_id, friend_id, status, requesttime, acknowledgetime, updatetime', 'numerical', 'integerOnly'=>true),
				array('message', 'length', 'max'=>255),
				array('inviter_id, friend_id, status, message, requesttime, acknowledgetime, updatetime', 'safe', 'on'=>'search'),
				);
	}

	public function relations()
	{
		return array(
				'inviter' => array(self::BELONGS_TO, 'User', 'inviter_id'),
				'invited' => array(self::BELONGS_TO, 'User', 'friend_id'),
				);
	}

	public function attributeLabels()
	{
		return array(
				'inviter_id' => Yii::t('UserModule.user', 'Inviter'),
				'friend_id' => Yii::t('UserModule.user', 'Friend'),
				'status' => Yii::t('UserModule.user', 'Status'),
				'message' => Yii::t('UserModule.user', 'Message'),
				'requesttime' => Yii::t('UserModule.user', 'Requesttime'),
				'acknowledgetime' => Yii::t('UserModule.user', 'Acknowledgetime'),
				'updatetime' => Yii::t('UserModule.user', 'Updatetime'),
				);
	}

	public function beforeSave() {
		$this->updatetime = time();

		// If the user has activated email receiving, send a email
		if($this->isNewRecord)
			if($user = User::model()->findByPk($this->friend_id))  {
					Message::write(
						$user,
						$this->inviter,
						Yii::t('UserModule.user', 
							'New friendship request from {username}',
							array('{username}' => $this->inviter->username)
						),
						TextSettings::getText('friendship_new', array(
							'{username}' => $this->inviter->username,
							'{link_friends}' => Yii::app()->controller->createUrl('//user/friendship/index'),
							'{link_profile}' => Yii::app()->controller->createUrl('//user/profile/view'),
							'{message}' => $this->message)
						)
					);
			}
		return parent::beforeSave();
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('inviter_id', $this->inviter_id);
		$criteria->compare('friend_id', $this->friend_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('message', $this->message, true);
		$criteria->compare('requesttime', $this->requesttime);
		$criteria->compare('acknowledgetime', $this->acknowledgetime);
		$criteria->compare('updatetime', $this->updatetime);

		return new CActiveDataProvider(get_class($this), array(
					'criteria'=>$criteria,
					));
	}

	public static function areFriends($uid1, $uid2) {
		if(is_numeric($uid1) && is_numeric($uid2)) {
			$friendship = Friendship::model()->find('status = 2 and inviter_id = '.$uid1 . ' and friend_id = '.$uid2);
			if($friendship)
				return true;

			$friendship = Friendship::model()->find('status = 2 and inviter_id = '.$uid2 . ' and friend_id = '.$uid1);
			if($friendship)
				return true;
		} 
		return false;

	}
}
