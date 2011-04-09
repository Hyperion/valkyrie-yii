<?php

class CharacterController extends AdminController
{
    private $_mapper;

    public function init()
    {
        $this->_mapper = new CharacterMapper();
        parent::init();
    }

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $level = $model->level;
        $class = $model->class;

		if(isset($_POST['Character']))
		{
			$model->attributes=$_POST['Character'];
			if($this->_mapper->save($model))
            {
                if($level !== $model->level)
                    $this->_mapper->updateWeaponSkills($model);
                if($class !== $model->class)
                    $this->_mapper->deleteSpells($model);
				$this->redirect(array('view','id'=>$model->guid));
            }
		}

        if(isset($_GET['Character']))
            $this->_mapper->setSearchParams($_GET['Character']);

		$this->render('update',array(
			'model'=>$model,
            'mapper'=>$this->_mapper,
		));
	}

	public function actionIndex()
	{
        if(isset($_GET['Character']))
            $this->_mapper->setSearchParams($_GET['Character']);

        $this->render('admin',array(
            'model' => new Character(),
            'mapper' => $this->_mapper,
        ));
	}

	public function loadModel($id)
	{
        $model = $this->_mapper->findById((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
