<?php

class DefaultController extends Controller
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
}
