<?php
class WebUser extends CWebUser
{
    /*protected function restoreFromCookie()
    {
        $app=Yii::app();
        $cookie=$app->getRequest()->getCookies()->itemAt($this->getStateKeyPrefix());
        if($cookie && !empty($cookie->value) && ($data=$app->getSecurityManager()->validateData($cookie->value))!==false)
        {
            $data=@unserialize($data);
            if(is_array($data) && isset($data[0],$data[1],$data[2],$data[3]))
            {
                list($id,$name,$duration,$states)=$data;
                if($this->beforeLogin($id,$states,true))
                {
                    $this->changeIdentity($id,$name,$states);
                    if($this->autoRenewCookie)
                    {
                        $cookie->expire=time()+$duration;
                        $app->getRequest()->getCookies()->add($cookie->name,$cookie);
                    }
                    $this->afterLogin(true);
                }
            }
        }
        else
            $this->checkRemote();
    }

    private function checkRemote()
    {
        $client = new SingleSignOn();
        $client->server = 'http://127.0.0.1/auth/index.php';
        $client->client = 'http://'.$_SERVER['HTTP_HOST'];
        if(isset($_GET['responce']))
        {
            if($_GET['responce'] != '0')
                $client->processAuthResponse($_GET['responce']);
            $this->changeIdentity($client->userId, $client->userName,$client->userStates);
        }
        else
        {
            $client->returnUrl = $_SERVER['REQUEST_URI'];
            $client->generateAuthRequest();
            Yii::app()->end();
        }
    }

    protected function afterLogout()
    {
        $client = new SingleSignOn();
        $client->server = 'http://127.0.0.1/auth/index.php/index/logout';
        $client->client = 'http://'.$_SERVER['HTTP_HOST'];
        if(isset($_GET['responce']))
        {
            if($_GET['responce'] != '0')
                $client->processAuthResponse($_GET['responce']);
            $this->changeIdentity($client->userId, $client->userName,$client->userStates);
        }
        else
        {
            $client->returnUrl = $_SERVER['REQUEST_URI'];
            $client->generateAuthRequest();
            Yii::app()->end();
        }
    }*/

    public function data() {
        if($model = User::model()->findByPk($this->id))
            return $model;
        else
            return new User();
    }

    public function getEmail()
    {
        return User::model()->findByPk($this->id)->getEmail();
    }

    /**
     * Return admin status.
     * @return boolean
     */
    public function isAdmin()
    {
        if($this->isGuest)
            return false;
        else
            return Yii::app()->user->data()->superuser;
    }
}

