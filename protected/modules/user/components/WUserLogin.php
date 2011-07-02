<?php

class WUserLogin extends CWidget
{
    public $title='User login';
    public $visible=true;

    public function init()
    {
        if($this->visible)
        {

        }
    }

    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }

    protected function renderContent()
    {
        $form = new FLogin;
        /*if(isset($_POST['FLogin']))
        {
            $form->attributes=$_POST['FLogin'];
            if($form->validate() && $form->login()){
                $url = $this->controller->createUrl('user/index');
                $this->controller->redirect($url);
            }
        }*/
        $this->render('UserLogin',array('form'=>$form));
    }
}
