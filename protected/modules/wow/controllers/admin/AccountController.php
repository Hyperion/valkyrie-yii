<?php

class AccountController extends AdminController
{
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $model->setScenario('update');

        if(isset($_POST['Account']))
        {
            $model->attributes=$_POST['Account'];
            if($model->validate())
            {
                if($model->save())
                    $this->redirect(array('admin'));
            }
        }
        $this->render('update',array('model'=>$model));
    }

    public function actionView($id)
    {
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    public function actionIndex()
    {
        $model=new Account('search');
        $model->unsetAttributes();
        if(isset($_GET['Account']))
            $model->attributes=$_GET['Account'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionBan()
    {
        $model=new AccountBanForm;

        if(isset($_GET['id']))
        {
            $model->method = 0;
            $model->value = (int) $_GET['id'];
        }
        elseif(isset($_GET['ip']))
        {
            $model->method = 1;
            $model->value = $_GET['ip'];
        }

        $account=new Account('search');
        $account->unsetAttributes();  // clear any default values
        if(isset($_GET['Account']))
            $account->attributes=$_GET['Account'];

        if(isset($_POST['AccountBanForm']))
        {
            $model->attributes=$_POST['AccountBanForm'];
            if($model->validate())
            {
                if($model->method == 0)
                {
                    $ban = new AccountBanned();
                    $ban->active = $model->active;
                    $ban->id = $model->value;
                }
                elseif($model->method == 1)
                {
                    $ban = new IpBanned();
                    $ban->ip = $model->value;
                }
                else 
                    return;
                $ban->bandate = time();
                $ban->unbandate = time() + $model->time * 24 * 60 * 60;
                $ban->bannedby = Yii::app()->user->name;
                $ban->banreason = $model->reason;
                if($ban->save())
                    $this->redirect(array('admin'));
            }
        }
        $this->render('ban',array('model'=>$model,'account'=>$account));
    }

	public function loadModel($id)
	{
		$model=Account::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
