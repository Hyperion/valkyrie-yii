<?php

class Delete extends BAction
{

    const DELETE_RENDER  = 0;
    const DELETE_PROCEED = 1;
    const DELETE_CANCEL  = 2;

    private $_status = self::DELETE_RENDER;

    public function run()
    {
        $this->messages = array(
            'cancel'  => Yii::t('app', 'Deletion canceled'),
            'success' => Yii::t('app', 'Successfully deleted'),
        );

        $this->init();

        if(isset($_POST['deleteConfirmed']))
            $this->_status = self::DELETE_PROCEED;
        else if(isset($_POST['deleteCanceled']))
            $this->_status = self::DELETE_CANCEL;

        $controller = $this->getController();
        $params     = $controller->getActionParams();
        $model      = $controller->loadModel($params['id']);


        if($this->_status === self::DELETE_PROCEED)
        {
            if($model->delete())
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
                    $controller->redirect(array('admin'));
                }
            }
            else
                Yii::app()->user->setFlash('error', $this->messages['error']);
        }
        else if($this->_status === self::DELETE_CANCEL)
        {
            if($this->_isAjaxRequest)
            {
                echo CJSON::encode(array(
                    'status'  => 'succes',
                    'content' => $this->messages['cancel'],
                ));

                Yii::app()->end();
            }
            else
            {
                $controller->redirect(array('view', 'id' => $model->id));
            }
        }

        if($this->_isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'  => 'render',
                'content' => $controller->renderPartial('_delete', array(
                    'model'   => $model), true, true),
                'buttons' => array(
                    CHtml::link('Нет', '#', array('class' => 'btn', 'type'  => 'submit', 'name'  => 'deleteCanceled')),
                    CHtml::link('<i class="icon-trash icon-white"></i> Да', '#', array('class' => 'btn btn-danger', 'type'  => 'submit', 'name'  => 'deleteConfirmed')),
                )
            ));
            Yii::app()->end();
        }
        else
            $controller->render('delete', array(
                'model' => $model));
    }

}
