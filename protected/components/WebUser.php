<?php

class WebUser extends CWebUser
{
    private $_model = null;
 
    function getRole()
    {
        if($user = $this->getModel())
        {
            return $user->role;
        }
    }

    function getAccounts()
    {
        
        if(!$this->isGuest)
        {
            $accounts = array();

            $c = Yii::app()->db->createCommand()->select('account_id')->from('{{user_accounts}}')->where('user_id = :id', array(':id' => $this->id));
            $data = $c->queryAll();
            foreach($data as $element)
                $accounts[] = $element['account_id'];
            return $accounts;
        }
    }

    function getEmail()
    {
        if($user = $this->getModel())
        {
            return $user->email;
        }
    }

    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null)
        {
            $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }
}