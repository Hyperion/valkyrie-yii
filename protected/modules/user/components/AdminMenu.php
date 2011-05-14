<?php

Yii::import('zii.widgets.CPortlet');

class AdminMenu extends CPortlet
{
	public function init()
	{
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
				array('label'=>'Users', 'items' => array(
						array('label'=> 'Statistics', 'url'=>array('//user/statistics/index')), 
						array('label' => 'Administration', 'url' => array('//user/user/admin')),
						array('label' => 'Create new user', 'url' => array('//user/user/create')),
						)
					),
				array('label'=>'Profiles', 'visible' => $this->module->enableProfiles, 'items' => array(
						array('label' => 'Manage profiles', 'url' => array('//user/profile/admin')),
						array('label' => 'Show profile visits', 'url' => array('//user/profile/visits')),
						array('label' => 'Manage profile fields', 'url' => array('//user/fields/admin')),
						array('label' => 'Create profile field', 'url' => array('//user/fields/create')),
						)
					),
				array('label' => 'Messages', 'visible' => $this->module->messageSystem != 'None', 'items' => array ( 
						array('label' => 'Admin inbox', 'url' => array('/user/messages/index')),
						array('label' => 'Sent messages', 'url' => array('/user/messages/sent')),
						array('label' => 'Write a message', 'url' => array('/user/messages/compose')),
						array('label' => 'Send message notifier emails', 'url' => array('/user/messages/sendDigest')),
						),
					),
				array('label' => 'Misc', 'items' => array(
						array('label' => 'Upload avatar for admin', 'url' => array('//user/avatar/editAvatar')),
						array('label' => 'Change admin Password', 'url' => array('//user/user/changePassword')),
						array('label' => 'Logout', 'url' => array('//user/user/logout')),
						)
					),
				);

	}
}
?>






