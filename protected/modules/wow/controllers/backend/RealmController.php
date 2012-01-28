<?php

class RealmController extends BackendController
{
    public function actionIndex()
    {
        $model = new Database('create');
		$model->title = 'realmlist';		

        if(isset($_POST['Database']))
        {
            $model->attributes = $_POST['Database'];
			$model->type = 'realmlist';
			if($model->save())
				$this->redirect('/wow/realm/admin');
        }

        $this->render('index',array('model'=>$model));
    }
	
	public function actionAdmin()
	{
		$model = new Realmlist('search');
		$model->unsetAttributes();
        if(isset($_GET['Realmlist']))
            $model->attributes=$_GET['Realmlist'];
		
		$this->render('admin',array('model'=>$model));
	}
	
	public function actionUpdate($id)
	{
		$model = new Database('create');
		$realm = $this->loadModel($id);

		$model->title = $realm->name;
		$model->host = $realm->address;		
		
		if(isset($_POST['Database']))
        {
            $model->attributes = $_POST['Database'];
            $model->type = 'characters';
            if($model->save())
                $this->redirect('/wow/realm/admin');
        }
		
		$this->render('update',array(
			'model' => $model,));
	}
	
	public function loadModel($id)
	{
		$model=Realmlist::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
