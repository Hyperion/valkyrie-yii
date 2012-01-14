<?php

class View extends CAction
{
    public function run($id)
    {
        $controller = $this->getController();
        $model = $controller->loadModel($id);

        $controller->render('view', array(
            'model' => $model,
        ));
    }
}
