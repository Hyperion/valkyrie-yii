<?php

class DefaultController extends AdminController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}