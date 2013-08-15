<?php

class SiteController extends Controller
{

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if($error)
        {
            if($this->isAjax)
                echo $error['message'];
            else
            {
                $this->layout = 'main';
                $this->render('error', $error);
            }
        }
    }
}
