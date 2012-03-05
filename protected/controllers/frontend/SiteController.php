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

    public function actionIndex()
    {
        $this->_cs->registerScriptFile('/js/easySlider1.7.js');
        $files = Slider::model()->findAll();
        $this->render('index', array('files' => $files));
    }

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if($error)
        {
            if(Yii::app()->request->isAjaxRequest)
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

    public function actionContact()
    {
        $model = new ContactForm;
        if(isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if($model->validate())
            {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->config->get('adminEmail'), $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('success', 'Спасибо за обращение. В скором времени Вам ответят.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

}
