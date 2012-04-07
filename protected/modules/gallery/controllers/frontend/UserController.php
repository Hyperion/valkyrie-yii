<?php

class UserController extends Controller
{

    public function actions()
    {
        return array();
    }

    public function actionView($id)
    {
        $model = new Album('search');
        $model->unsetAttributes();
        $model->user_id = $id;
        $model->visible = 1;

        $this->render('view', array('model' => $model));
    }

}
