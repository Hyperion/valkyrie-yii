<?php

class DefaultController extends AdminController
{
	public $menu=array(
		array('label'=>'Home', 'url'=>array('index')),
		array('label'=>'Access Log', 'url'=>array('log')),
	);
	
    public function actionIndex()
    {
		$model = AdminAccess::model()->find(array(
			'order'=> 'time DESC',
			'with' => 'user')
		);
		
        $this->render('index', array(
			'model'=>$model,
		));
    }
	
	public function actionLog()
	{
		$dataProvider=new CActiveDataProvider('AdminAccess', array( 
			'criteria'=>array(
				'order'=> 'time DESC',)
			)
		);
		$this->render('log',array(
                'dataProvider'=>$dataProvider
        ));
	}
}