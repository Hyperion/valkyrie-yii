<?php
Yii::import('application.modules.user.components.WebUser');
class WowUser extends WebUser
{

    public function getAccounts()
    {
        return Yii::app()->db
            ->createCommand("
                SELECT account_id
                FROM user_accounts
                WHERE user_id = ".$this->id)
            ->queryColumn();
    }

    public function haveAccount()
    {
        return in_array($_GET['id'], $this->accounts);
    }
}

