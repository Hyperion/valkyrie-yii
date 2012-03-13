<?php

class SiteController extends Controller
{

    public function actions()
    {
        return array(
            'captcha' => array(
                'class'     => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    public function allowedActions()
    {
        return '*';
    }

    public function actionIndex()
    {
        $this->cs->registerScriptFile('/js/easySlider1.7.js');
        $files = Slider::model()->findAll();
        $this->render('index', array('files' => $files));
    }

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

    public function actionPage($url)
    {
        $this->_model = Page::model()->findByAttributes(array('url' => $url));

        $this->render('page', array(
            'model' => $this->_model,
        ));
    }
}
