<?php
// This is the entry script of the Yii User Management Module
// You can see all default configuration options defined here

class UserModule extends CWebModule {

	// After how much seconds without an action does a user gets indicated as 
	// offline? Note that, of course, clicking the Logout button will indicate
	// him as offline instantly anyway.
	public $offlineIndicationTime = 3600; // 5 Minutes

	// Whether to confirm the activation of an user by email
	public $enableActivationConfirmation = true; 

	// set to false to enable case insensitive users.
  // for example, demo and Demo would be the same user then
	public $caseSensitiveUsers = true;

	// Where to save the avatar images? (Yii::app()->baseUrl . $avatarPath)	
	public $avatarPath = 'images';

	// Maximum width of avatar in pixels. Correct aspect ratio should be set up
	// by CImageModifier automatically
	// Set to 0 to disable image size check
	public $avatarMaxWidth = 200;
	public $avatarThumbnailWidth = 50; // For display in user browse, friend list
	public $avatarDisplayWidth = 200;

	public $password_expiration_time = 30; // days
	public $activationPasswordSet = false;
	public $autoLogin = false;
	public $activateFromWeb = true;
	public $recoveryFromWeb = false;
	public $mailer = 'yum'; // set to swift to active emailing by swiftMailer or PHPMailer to use PHPMailer as emailing lib.
	public $phpmailer = null; // PHPMailer array options.

	public $registrationEmail='register@website.com';
	public $recoveryEmail='restore@website.com';
	public $facebookConfig = false;
	public $pageSize = 10;

	// System-wide configuration option on how users should be notified about
  // new internal messages by email. Available options:
  // None, Digest, Instant, User, Treshhold
	// 'User' means to use the user-specific option in the user table
	public $notifyType = 'user';

	// Send a message to the user if the email changing has been succeeded
	public $notifyEmailChange = true;

	// if you want the users to be able to edit their profile TEXTAREAs with an
	// rich text Editor like CKEditor, set that here
	public $rtepath = false; // Don't use an Rich text Editor
	public $rteadapter = false; // Don't use an Adapter


	// Messaging System can be MSG_NONE, MSG_PLAIN or MSG_DIALOG
	public $messageSystem = Message::MSG_DIALOG;

	public $salt = '';
	 // valid callback function for password hashing ie. sha1
	public $hashFunc = 'md5';

	public static $dateFormat = "m-d-Y";  //"d.m.Y H:i:s"
	public $dateTimeFormat = 'm-d-Y G:i:s';  //"d.m.Y H:i:s"

	// LoginType :
	const LOGIN_BY_USERNAME		= 1;
	const LOGIN_BY_EMAIL		= 2;
	const LOGIN_BY_OPENID		= 4;
	const LOGIN_BY_FACEBOOK		= 8;
	// Allow username and email login by default
	public $loginType = 3;

	/**
	 * Whether to use captcha e.g. in registration process
	 * @var boolean
	 */
	public $enableCaptcha = true;

	public $passwordRequirements = array(
			'minLen' => 8,
			'maxLen' => 32,
			'minLowerCase' => 1,
			'minUpperCase'=>0,
			'minDigits' => 1,
			'maxRepetition' => 3,
			);

	public $usernameRequirements=array(
		'minLen'=>3,
		'maxLen'=>30,
		'match' => '/^[A-Za-z0-9_]+$/u',
		'dontMatchMessage' => 'Incorrect symbol\'s. (A-z0-9)',
	);

	public function init() {
		$this->setImport(array(
			'user.controllers.*',
			'user.models.*',
			'user.components.*',
		));
	}
}
