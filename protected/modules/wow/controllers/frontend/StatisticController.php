<?php

class StatisticController extends Controller
{
    public function actionWarEffort()
    {
        $model = new WarEffort();
        $this->render('warEffort',array('model' => $model));
    }

    public function actionOnline($realm)
    {
		Database::$realm = (string) $realm;
        $model = new Character('online');
        $model->unsetAttributes();
        $model->online = 1;

        if(isset($_GET['Character']))
			$model->attributes = $_GET['Character'];

        $this->render('online',array(
            'model' => $model,
        ));
    }

    public function actionPvp($realm)
    {
		Database::$realm = (string) $realm;
        $model = new Character('pvp');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('pvp',array(
            'model' => $model,
        ));
    }

    public function actionBanned()
    {
        $ipBanned = new IpBanned('search');
        $accountBanned = new AccountBanned('search');

        $ipBanned->unsetAttributes();
        $this->render('banned', array(
            'ipBanned'      => $ipBanned,
            'accountBanned' => $accountBanned,
        ));
    }
}
