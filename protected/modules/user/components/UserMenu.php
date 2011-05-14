<?php
Yii::import('zii.widgets.CPortlet');

class UserMenu extends CPortlet {
	public function init() {
		$this->title = sprintf('%s <br /> %s: %s',
				Yii::t('UserModule.user', 'Usermenu'),
				Yii::t('UserModule.user', 'Logged in as'),
				Yii::app()->user->data()->username);

		$this->contentCssClass = 'menucontent';
		return parent::init();
	}

	public function run() {
		$this->widget('zii.widgets.CMenu', array(
					'items' => $this->getMenuItems()
					));

		parent::run();
	}

	public function getMenuItems() {
		return array( 
				array('label' => 'Profile', 'items' => array(
						array('label' => 'My profile', 'url' => array('/user/profile/view')),
						array('label' => 'Edit personal data', 'url' => array('/user/profile/update')),
						array('label' => 'Upload avatar image', 'url' => array('/user/avatar/editAvatar')),
						)
					),

				array('label' => 'Messages', 'items' => array ( 
						array('label' => 'My inbox', 'url' => array('/user/messages/index')),
						array('label' => 'Sent messages', 'url' => array('/user/messages/sent')),
						),
					),

				array('label' => 'Social', 'items' => array(
						array('label' => 'My friends', 'url' => array('/user/friendship/index'), 'visible' => $this->module->enableFriendship),
						array('label' => 'Browse users', 'url' => array('/user/user/browse')),
						)
					),
				array('label' => 'Misc', 'items' => array(
						array('label' => 'Change password', 'url' => array('//user/user/changePassword')),
						array('label' => 'Delete account', 'url' => array('//user/user/delete')),
						array('label' => 'Logout', 'url' => array('//user/user/logout')),
						)
					),
				);
	}
}
