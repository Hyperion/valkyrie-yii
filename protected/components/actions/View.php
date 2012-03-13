<?php

class View extends BAction
{

    public function run($id)
    {

        $this->init();

        $controller = $this->getController();
        $params     = $controller->getActionParams();
        $model      = $controller->loadModel($params['id']);

        if($this->_isAjaxRequest and Yii::app()->request->isPostRequest)
        {
            echo CJSON::encode(array(
                'status'  => 'render',
                'content' => $controller->renderPartial('_view', array(
                    'model' => $model), true, true),
                'buttons' => array(
                    CHtml::link('Закрыть', '#', array('class' => 'btn', 'data-dismiss' => 'modal')),
                )
            ));

            Yii::app()->end();
        }

        else
            $controller->render('view', array('model' => $model));
    }

}
