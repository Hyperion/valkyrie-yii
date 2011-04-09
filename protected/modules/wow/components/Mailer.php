<?php

class Mailer
{
    static public function send($to, $subject = null, $body = null, $header = null)
    {
        if(!is_array($to)) 
            $to = array(
                    'to' => $to,
                    'subject' => $subject,
                    'body' => $body);

        if($mailer = Yii::app()->mailer)
        {
            $mailer->From($to['from']);
            $mailer->AddAddress($to['to']);
            $mailer->Subject = $to['subject'];
            $mailer->Body = $to['body'];
            return $mailer->Send();
        } else {
            if($header == null)
            {
                $header  = 'MIME-Version: 1.0' . "\r\n";
                $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                $header .= 'From: ' . Yum::module()->registrationEmail . "\r\n";
                $header .= 'To: ' . $to['to'] . "\r\n";
            }
            return mail($to['to'], $to['subject'], $to['body'], $header);
        }
    }
}
