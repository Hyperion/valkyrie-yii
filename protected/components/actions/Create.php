<?php

class Create extends BAction
{

    public function run()
    {
        $this->messages = array('success' => Yii::t('app', 'Successfully created'));

        $this->init();

        $controller = $this->getController();
        $model      = new $controller->class();

        if(isset($_POST[$controller->class]))
        {
            $model->attributes = $_POST[$controller->class];

            if($model->save())
            {
                if($this->_isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'  => 'success',
                        'model'   => $model->attributes,
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
                'content' => $controller->renderPartial('_form', array('model'   => $model), true, true),
                'buttons' => array(
                    CHtml::link('Закрыть', '#', array('class'        => 'btn', 'data-dismiss' => 'modal')),
                    CHtml::link('<i class="icon-white icon-plus"></i> Добавить', '#', array('class' => 'btn btn-primary', 'type'  => 'submit')),
                )
            ));

            Yii::app()->end();
        }

        else
            $controller->render('create', array('model' => $model));
    }

}
