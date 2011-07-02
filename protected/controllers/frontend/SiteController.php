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
        $criteria=new CDbCriteria(array(
            'condition'=>'status="'.Material::STATUS_PUBLISHED.'" AND type="'.Material::TYPE_NEWS.'"',
            'order'=>'update_time DESC',
            'with'=>'commentCount',
        ));

        $dataProvider=new CActiveDataProvider('Material', array(
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['postsPerPage'],
            ),
            'criteria'=>$criteria,
        ));

        $this->_cs->registerCssFile('/css/local-common/cms/homepage.css');
        $this->registerFiles();

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
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

    private function registerFiles()
    {
        //$this->_cs->registerCssFile('/css/local-common/cms/cms-common.css');
        $this->_cs->registerCssFile('/css/local-common/cms/blog.css');
        $this->_cs->registerCssFile('/css/wow/cms.css');
        //$this->_cs->registerScriptFile('/js/wow/profile.js', CClientScript::POS_END);
        //$this->_cs->registerScriptFile('/js/wow/character/summary.js', CClientScript::POS_END);
    }
}
