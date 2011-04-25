<?php

class StatisticController extends Controller
{
	public function init()
    {
		WowDatabase::$name = 'Valkyrie 1.12 Classic';
        parent::init();
    }
	
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

    public function actionBanned()
    {
        $ipBanned = new IpBanned('search');
        $accountBanned = new AccountBanned('search');
        $this->render('banned', array(
            'ipBanned'         => $ipBanned,
            'accountBanned' => $accountBanned,
        ));
    }
}