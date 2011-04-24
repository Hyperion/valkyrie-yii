<?php

class ModuleController extends AdminController
{
    public function actionIndex()
	{
 
        $model = new Resource();
 
		$moduleList = $model->getModuleList();
        $model->refreshModuleList($moduleList);
		
        $dataProvider=new CArrayDataProvider($moduleList, array());
		
		$menu = new Menu;
		$menu->refreshXmlMenu('admin');
		$menu->refreshXmlMenu('cp');
		
        $this->render('resources',array(
                'dataProvider'=>$dataProvider
        ));
    }
	
	public function actionInstall($resource)
	{
		$model = new Resource;
		
		$model->install($resource);
 
        Yii::app()->user->setFlash('success','Module <b>'.$resource.'</b> success installed.');
        $this->redirect(Yii::app()->createUrl('admin/core/module/index'));
	}
	
	public function actionUninstall($resource)
	{
		$model = Resource::model()->findByPk($resource);
		$model->delete();
 
        Yii::app()->user->setFlash('success','Module <b>'.$resource.'</b> success uninstalled.');
        $this->redirect(Yii::app()->createUrl('admin/core/module/index'));
	}
}