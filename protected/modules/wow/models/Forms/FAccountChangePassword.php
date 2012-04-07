<?php

class FAccountChangePassword extends CFormModel
{
    public $username;
    public $oldPassword;
    public $newPassword;
    public $confirmNewPassword;

    public function rules()
    {
        return array(
            array('oldPassword, newPassword, confirmNewPassword', 'required'),
            array('newPassword', 'compare',
                'compareAttribute'=>'confirmNewPassword',
                'message' => 'Retype password is incorrect.'),
            array('oldPassword', 'authenticate'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'confirmNewPassword' => 'Подтвердите новый пароль'
        );
    }

    public function authenticate($attribute,$params)
    {
        $model = Account::model()->find('username = ?', array($this->username));
        if($model===null)
        {
            $this->addError('oldPassword','Не найден аккаунт.');
            return;
        }
        $sha_pass_hash = strtoupper(sha1(strtoupper($this->username).":".strtoupper($this->oldPassword)));
        if($sha_pass_hash != strtoupper($model->sha_pass_hash))
            $this->addError('oldPassword','Не верно введен старый пароль.');
    }
}
