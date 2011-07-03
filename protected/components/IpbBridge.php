<?php

class IpbBridge extends externalBridge
{
    public function getUserData($username, $password)
    {
        $this->_password = $password;
        $password = md5($this->_password);

        $c = $this->db->createCommand(
            'SELECT
                name,
                email,
                members_pass_hash,
                members_pass_salt,
                member_group_id
            FROM {{members}}
            WHERE
                email = :email
            OR
                name  = :name
            LIMIT 1');
        $c->bindParam(':email', $username);
        $c->bindParam(':name',  $username);
        $this->_data = $c->queryRow();

        if($this->_data['members_pass_hash'] == self::generateCompiledPasshash($this->_data['members_pass_salt'], $password))
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
        return $this->_data['name'];
    }

    public function getUserRole()
    {
        switch($this->_data['member_group_id'])
        {
            case '6': return 1; break;
            case '4':
            case '3': default: return 0; break;
        }
    }

    static public function generateCompiledPasshash($salt, $password)
    {
        return md5(md5($salt) . $password);
    }
}
