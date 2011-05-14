<?php
class Core
{ 
	public static function hint($message) 
	{
		return '<div class="hint">'.Yii::t('UserModule.user',$message).'</div>'; 
	}

	public static function setFlash($message) 
	{
		$_SESSION['yumflash'] = Yii::t('UserModule.user', $message);
	}

	public static function hasFlash() 
	{
		return(isset($_SESSION['yumflash']));
	}


	public static function getFlash() {
		if(isset($_SESSION['yumflash'])) {
			$message = $_SESSION['yumflash'];
			unset($_SESSION['yumflash']);
			return $message;
		}
	}

	public static function renderFlash()
	{
		if(isset($_SESSION['yumflash'])) {
			echo '<div class="info">';
			echo self::getFlash();
			echo '</div>';
		Yii::app()->clientScript->registerScript('fade',"
		setTimeout(function() { $('.info').fadeOut('slow'); }, 5000);	
"); 

		}
	}

	public static function p($string, $params = array()) {
		return '<p>'.Yii::t('UserModule.user', $string, $params).'</p>';
	}
}
