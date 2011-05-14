<?php

class RealmController extends AdminController
{
    public function actionIndex()
    {
        $form = new RealmlistForm();

        if(isset($_POST['RealmlistForm']))
        {
            $form->attributes=$_POST['RealmlistForm'];
            if($form->validate())
            {
                $db = new WowDatabase();
                $db->realmInfo = array('realmlist' => $form->attributes);
				$this->redirect('admin');
            }
        }

        $this->render('index',array('form'=>$form));
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
		$model=$this->loadModel($id);
		$form = new DatabaseForm();
		
		if(isset($_POST['DatabaseForm']))
        {
            $form->attributes=$_POST['DatabaseForm'];
            if($form->validate())
            {
                $db = new WowDatabase();
                $db->realmInfo = array(
					$model->name => CMap::mergeArray(
						array('host' => $model->address),
						$form->attributes
					)
				);
				$this->redirect('/admin/wow/realm/admin');
            }
        }
		
		$this->render('update',array(
			'form'  => $form,
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
