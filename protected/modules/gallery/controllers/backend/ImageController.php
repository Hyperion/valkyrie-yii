<?php

class ImageController extends BackendController
{

    public function actionCreate()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'  => 'render',
                'content' => 'Вы не можете загружать файлы из админ панели',
                'buttons' => array(
                    CHtml::link('Закрыть', '#', array('class'        => 'btn', 'data-dismiss' => 'modal')),
                )
            ));

            Yii::app()->end();
        }
        else
        {
            throw new CHttpException(400, 'Вы не можете загружать файлы из админ панели');
        }
    }
    
    public function actionReport($id)
    {
        $model = $this->loadModel($id);
        $model->addReport('Trolololo');
        
        foreach($model->reports as $report)
        {
            echo $report->url . '\n' . $report->report_text;
        }
        
    }

}
