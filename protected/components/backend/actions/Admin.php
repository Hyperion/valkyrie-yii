<?php

class Admin extends CAction
{
    public function run()
    {
        $controller = $this->getController();
        $model = new $controller->class('search');
        $model->unsetAttributes();

        if (isset($_GET[$controller->class])) {
            $model->attributes = $_GET[$controller->class];
        }

        if (method_exists($controller, 'onAdminBeforeRender')) {
            $controller->onAdminBeforeRender(get_defined_vars());
        }

        $controller->render('admin', array(
            'model' => $model,
        ));
    }
}
