<?php

class Admin extends CAction
{

    public function run()
    {
        $controller = $this->getController();
        $model      = new $controller->class('search');
        $model->unsetAttributes();

        if(isset($_GET[$controller->class]))
        {
            $model->attributes = $_GET[$controller->class];
        }

        $controller->render('admin', array(
            'model' => $model,
        ));
    }

}