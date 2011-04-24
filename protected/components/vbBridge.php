<?php

class vbBridge extends externalBribge
{
    public function getUserData($email, $password)
    {
		$this->_password = $password;
        $password = md5($password);

        $c = $this->_db->createCommand('SELECT username, usergroupid, password, email, salt FROM {{user}} WHERE email = :email LIMIT 1');
        $c->bindParam(':email', $email);
        $this->_data = $c->queryRow();

        if($this->_data['password'] == self::generateCompiledPasshash($this->_data['salt'], $password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getEmail()
    {
        return $this->_data['email'];
    }

    public function getUsername()
    {
        return $this->_data['username'];
    }

    public function getUserRole()
    {
        /*switch($this->_data['usergroupid'])
        {
            case '6': return User::ROLE_MODER; break;
            case '4': return User::ROLE_ADMIN; break;
            case '3': default: return User::ROLE_USER; break;
        }*/

        return User::ROLE_USER;
    }

    static public function generateCompiledPasshash($salt, $password)
    {
        return md5(md5($password) . $salt);
    }
}