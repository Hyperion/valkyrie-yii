<?php

class CharacterController extends Controller
{
	public $layout='//layouts/column2';
    private $_mapper;

    public function init()
    {
		
        $this->_mapper = new CharacterMapper();
		WowDatabase::$name = 'Valkyrie 1.12 Classic';
        parent::init();
    }

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionIndex()
	{
        if(isset($_GET['Character']))
            $this->_mapper->setSearchParams($_GET['Character']);

        $this->render('index',array(
            'model' => new Character(),
            'mapper' => $this->_mapper,
        ));
	}

    public function actionSimple($realm, $name)
    {
        WowDatabase::$name = (string)$realm;
        $model = $this->_mapper->findByName((string)$name);
        
        $this->render('view',array(
			'model'=>$model,
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
