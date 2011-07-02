<?php

class Message extends CActiveRecord
{
    const MSG_NONE = 'None';
    const MSG_PLAIN = 'Plain';
    const MSG_DIALOG = 'Dialog';

    public $omit_mail = false;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function beforeValidate()
    {
        if(parent::beforeValidate())
        {
            $this->timestamp = time();
            return true;
        }
        return false;
    }

    public static function write($to, $from, $subject, $body, $mail = true) {
        $message = new Message();

        if(!$mail)
            $message->omit_mail = true;

        if(is_object($from))
            $message->from_user_id = (int) $from->id;
        else if(is_numeric($from))
            $message->from_user_id = $from;
        else if(is_string($from)
                && $user = User::model()->find("username = '{$from}'"))
            $message->from_user_id = $user->id;
        else
            return false;

        if(is_object($to))
            $message->to_user_id = (int) $to->id;
        else if(is_numeric($to))
            $message->to_user_id = $to;
        else if(is_string($to)
                && $user = User::model()->find("username = '{$to}'"))
            $message->to_user_id = $user->id;
        else
            return false;

        $message->title = $subject;
        $message->message = $body;

        return $message->save();
    }

    public static function countWritten($month = null, $year = null) {
        $timestamp = mktime(0, 0, 0, $month, 1, $year);
        $timestamp2 = mktime(0, 0, 0, $month + 1, 1, $year);
        if($month === null) {
            $timestamp = 0;
            $timestamp2 = time();
        }

        $sql = "select count(*) from messages where timestamp > {$timestamp} and timestamp < {$timestamp2}";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        return $result[0]['count(*)'];
    }

    public function search($sent = false) {
        $criteria = new CDbCriteria;

        if(!isset($_GET['Message_sort']))
            $criteria->order = 'timestamp DESC';

        if($sent)
            $criteria->addCondition('from_user_id = '. Yii::app()->user->id);
        else
            $criteria->addCondition('to_user_id = '. Yii::app()->user->id);

        return new CActiveDataProvider('Message', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->controller->module->pageSize,
                        ),
                    ));
    }

    public function tableName()
    {
        return 'messages';
    }

    public function rules()
    {
        return array(
                array('from_user_id, to_user_id, title', 'required'),
                array('from_user_id, draft, message_read, answered', 'numerical', 'integerOnly'=>true),
                array('title', 'length', 'max'=>255),
                array('message', 'safe'),
                );
    }

    public function getTitle()
    {
        if($this->message_read)
            return $this->title;
        else
            return '<strong>' . $this->title . '</strong>';
    }

    public function getStatus() {
        if($this->from_user_id == Yii::app()->user->id)
            return Yii::t('UserModule.user', 'sent');
        if($this->answered)
            return Yii::t('UserModule.user', 'answered');
        if($this->message_read)
            return Yii::t('UserModule.user', 'read');
        else
            return Yii::t('UserModule.user', 'new');
    }

    public function unread($id = false)
    {
        if(!$id)
            $id = Yii::app()->user->id;

        $this->getDbCriteria()->mergeWith(array(
            'condition' => "to_user_id = {$id} and message_read = 0"
        ));
        return $this;
    }

    public function scopes() {
        $id = Yii::app()->user->id;
        return array(
            'all' => array(
                'condition' => "to_user_id = {$id} or from_user_id = {$id}"),
            'read' => array(
                'condition' => "to_user_id = {$id} and message_read = 1"),
            'sent' => array(
                'condition' => "from_user_id = {$id}"),
            'answered' => array(
                'condition' => "to_user_id = {$id} and answered = 1"),
        );
    }

    public function limit($limit=10)
    {
        $this->getDbCriteria()->mergeWith(array(
            'order'=>'timestamp DESC',
            'limit'=>$limit,
        ));
        return $this;
    }

    public function getDate()
    {
        return date(Yii::app()->getModule('user')->dateTimeFormat, $this->timestamp);
    }

    public function beforeDelete() {
        if($this->to_user_id != Yii::app()->user->id)
            throw new CHttpException(403);
        return parent::beforeDelete();
    }

    public function relations()
    {
        return array(
            'from_user' => array(self::BELONGS_TO, 'User', 'from_user_id'),
            'to_user' => array(self::BELONGS_TO, 'User', 'to_user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('UserModule.user', '#'),
            'from_user_id' => Yii::t('UserModule.user', 'From'),
            'to_user_id' => Yii::t('UserModule.user', 'To'),
            'title' => Yii::t('UserModule.user', 'Title'),
            'message' => Yii::t('UserModule.user', 'Message'),
            'timestamp' => Yii::t('UserModule.user', 'Time sent'),
        );
    }
}
