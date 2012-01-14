<?php

class Delete extends CAction
{
    public function run()
    {
        $controller = $this->getController();
        $params = $controller->getActionParams();

        if (Yii::app()->request->isPostRequest) {
            $controller->loadModel($params['id'])->delete();
            if (!Yii::app()->request->isAjaxRequest) {
                $controller->setFlash('default', 'Запись успешно удалена');
                $controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }
}
