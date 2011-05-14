<?php

/**
 * YumMailer just implements the send() method that handles (guess what)
 * the mailing process of messages.
 * the first parameter can either be an array containing the Information 
 * or a string containing the recipient, or a object instance of YumUser.
 * In the YumUser case, the email will be sent to the E-Mail field of the
 * most actual profile.
 * @return true if sends mail, false otherwise
 */
class YumMailer {
	static public function send($to, $subject = null, $body = null, $header = null) {
		if($to instanceof YumUser)
			$to = $to->profile->email;

		if(!is_array($to)) 
			$to = array(
					'to' => $to,
					'subject' => $subject,
					'body' => $body);

		if($this->module->mailer == 'swift') {
			$sm = Yii::app()->swiftMailer;
			$mailer = $sm->mailer($sm->mailTransport());
			$message = $sm->newMessage($to['subject'])
				->setFrom($to['from'])
				->setTo($to['to'])
				->setBody($to['body']);
			return $mailer->send($message);
		} else if($this->module->mailer == 'PHPMailer') {
			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mailer = new JPhpMailer(true);
			if ($this->module->phpmailer['transport'])
				switch ($this->module->phpmailer['transport']) {
					case 'smtp':
						$mailer->IsSMTP();
						break;
					case 'sendmail':
						$mailer->IsSendmail();
						break;
					case 'qmail':
						$mailer->IsQmail();
						break;
					case 'mail':
					default:
						$mailer->IsMail();
				}
			else
				$mailer->IsMail();

			if ($this->module->phpmailer['html'])
				$mailer->IsHTML($this->module->phpmailer['html']);
			else
				$mailer->IsHTML(false);

			$mailerconf=$this->module->phpmailer['properties'];
			if(is_array($mailerconf))
				foreach($mailerconf as $key=>$value) {
					if(isset(JPhpMailer::${$key}))
						JPhpMailer::${$key} = $value;
					else
						$mailer->$key=$value;
				}
			$mailer->SetFrom($to['from'], $this->module->phpmailer['msgOptions']['fromName']); //FIXME
			$mailer->AddAddress($to['to'], $this->module->phpmailer['msgOptions']['toName']); //FIXME
			$mailer->Subject = $to['subject'];
			$mailer->Body = $to['body'];
			return $mailer->Send();
		} else {
			if($header == null) {
				$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From: ' . $this->module->registrationEmail . "\r\n";
			$header .= 'To: ' . $to['to'] . "\r\n";
}
			return mail($to['to'], $to['subject'], $to['body'], $header);
		}
	}
}
