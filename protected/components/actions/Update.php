<?php

class Update extends BAction
{
    public function run()
    {
        $this->messages = array('success' => Yii::t('app', 'Successfully updated'));
        
        $this->init();

        $controller = $this->getController();
        $params     = $controller->getActionParams();
        $model      = $controller->loadModel($params['id']);

        if(isset($_POST[$controller->class]))
        {
            $model->attributes = $_POST[$controller->class];

            if($model->save())
            {
                if($this->_isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'  => 'success',
                        'content' => $this->messages['success'],
                    ));

                    Yii::app()->end();
                }
                else
                {
                    Yii::app()->user->setFlash('success', $this->messages['success']);
                    $controller->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        if($this->_isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'  => 'render',
                'content' => $controller->renderPartial('_form', array(
                    'model' => $model), true, true),
                'buttons' => array(
                    CHtml::link('Закрыть', '#', array('class' => 'btn', 'data-dismiss' => 'modal')),
                    CHtml::link('<i class="icon-white icon-edit"></i> Редактировать', '#', array('class' => 'btn btn-primary', 'type' => 'submit')),
                )
            ));

            Yii::app()->end();
        }

        else
            $controller->render('update', array('model' => $model));
    }
}
