<?php

class SiteController extends Controller
{
	public $layout='column1';

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
		$this->layout='column2';
	    
		$criteria=new CDbCriteria(array(
			'condition'=>'status="'.Material::STATUS_PUBLISHED.'" AND type="'.Material::TYPE_NEWS.'"',
			'order'=>'update_time DESC',
			'with'=>'commentCount',
		));
		if(isset($_GET['tag']))
			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Material', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

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
	        	$this->render('error', $error);
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
			'model'		   => $model,
			'dataProvider' => (isset($dataProvider)) ? $dataProvider : false,
		));
	}
}
