<?php
class WebUser extends CWebUser
{
	public function data() {
		if($model = User::model()->findByPk($this->id))
			return $model;
		else
			return new User();
	}

	/**
	 * Checks if this (non-admin) User can administrate some users
	 */
	public static function hasUsers($uid = 0)
	{
		if($uid == 0)
			$uid = Yii::app()->user->id;

		$user = User::model()->findByPk($uid);

		return isset($user->users) && $user->users !== array();
	}

	public static function hasRoles($uid = 0)
	{
		if($uid == 0)
			$uid = Yii::app()->user->id;

		$user = User::model()->findByPk($uid);

		$flag = false;
		if(isset($user->roles))
			foreach($user->roles as $role) 
				if (isset($role->roles) && $role->roles !== array())
					$flag = true;

		return $flag;
	}

	/**
	 * Checks if this (non-admin) User can administrate the given user
	 */
	public static function hasUser($username, $uid = 0)
	{
		if($uid == 0)
			$uid = Yii::app()->user->getId();

		// Every user can modify himself
		if($username == $uid)
			return true;

		$user = User::model()->findByPk($uid);

		if(!is_array($username))
			$username = array ($username);

		if(isset($user->users)) 
			foreach($user->users as $userobj) 
			{
				if(in_array($userobj->username, $username) ||
					in_array($userobj->id, $username))
					return true;
			}
		return false;
	}

	/**
	 * Checks if the user has the given Role
	 * @mixed Role string or array of strings that should be checked
	 * @int (optional) id of the user that should be checked 
	 * @return bool Return value tells if the User has access or hasn't access.
	 */
	public static function hasRole($role, $uid = 0) {
		if($uid == 0)
			$uid = Yii::app()->user->id;

		if(!is_array($role))
			$role = array ($role);

		if($user = User::model()->findByPk($uid)) {
			// Check if a user has a active membership and, if so, add this
			// to the roles
			$roles = array_merge($user->roles, $user->getActiveMemberships());

			if(isset($roles)) 
				foreach($roles as $roleobj) {
					if(in_array($roleobj->title, $role) ||
							in_array($roleobj->id, $role))
						return true;
				}

		}

		return false;
	}

	/**
	 * Return admin status.
	 * @return boolean
	 */
	public function isAdmin() {
		if($this->isGuest)
			return false;
		else 
			return Yii::app()->user->data()->superuser;
	}
}

