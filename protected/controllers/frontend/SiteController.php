<?php

class SiteController extends Controller
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
            {
                $this->body_class = 'server-error';
                $this->layout = 'main';
                $this->render('error', $error);
            }
        }
    }

    public function actionSearch()
    {
        $model = new SearchForm;
        if(isset($_POST['SearchForm']))
        {
            $model['attributes'] = $_POST['SearchForm'];
            if($model->validate())
            {
                $criteria = new CDbCriteria(array(
                    'condition' => 'status="'.Material::STATUS_PUBLISHED.'" AND type="'.Material::TYPE_POST.'"',
                    'order'     => 'update_time DESC',
                    'with'      => 'commentCount',
                ));
                $criteria->compare('title',$model['query'],true);
                $dataProvider = new CActiveDataProvider('Material', array(
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['postsPerPage'],
                    ),
                    'criteria'   => $criteria,
                ));
            }
        }
        $this->render('search',array(
            'model'        => $model,
            'dataProvider' => (isset($dataProvider)) ? $dataProvider : false,
        ));
    }
}
