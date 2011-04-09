<?php

class StatisticController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionWarEffort()
    {
        $model = new WarEffort();
        $this->render('warEffort',array('model' => $model));
    }

    public function actionOnline()
    {
        $mapper = new CharacterMapper();
        $mapper->setSearchParams(array('online' => true));

        if(isset($_GET['Character']))
        {
            $session = new CHttpSession;
            $session->open();
            foreach($_GET['Character'] as $key => $value)
                if($value != '')
                    $session[$key] = $value;
            $mapper->setSearchParams($session->toArray());
        }

        $this->render('online',array(
            'model' => new Character('online'),
            'mapper' => $mapper,
        ));
    }

    public function actionPvp()
    {
        $mapper = new CharacterMapper();
        $mapper->setSearchParams(array('pvp' => true));
        if(isset($_GET['Character']))
            $mapper->setSearchParams($_GET['Character']);

        $this->render('pvp',array(
            'model' => new Character('pvp'),
            'mapper' => $mapper,
        ));
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}