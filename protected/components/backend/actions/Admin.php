<?php

class Admin extends CAction
{
    public function run()
    {
        $controller = $this->getController();
        $model = new $controller->_class('search');
        $model->unsetAttributes();

        if (isset($_GET[$controller->_class])) {
            $model->attributes = $_GET[$controller->_class];
        }

        if (method_exists($controller, 'onAdminBeforeRender')) {
            $controller->onAdminBeforeRender(get_defined_vars());
        }

        $controller->render('admin', array(
            'model' => $model,
        ));
    }
}
