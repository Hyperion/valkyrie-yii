<?php

class DefaultController extends Controller
{
	public function filters()
	{
		return array(
			array(
				'COutputCache',
				'duration'=>1000,
				'varyByParam'=>array('section', Yii::app()->language, 'page'),
			),
		);
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionView($section, $page, $language = false)
	{
		if(!$language)
			$language = Yii::app()->language;
		$model = new Page($section, $page, $language);
		
		if(!$model->loadPage())
			throw new CHttpException(404,'Запрашиваемая страница не существует.');

		if($model->isImage())
		{
			echo $model->content;
			return;
		}
		
		$this->render('view',array(
			'section' => $section,
			'title'   => $model->title,
			'content' => $model->content,
		));
	}
}