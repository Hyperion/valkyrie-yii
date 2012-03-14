<?php

class StatisticController extends Controller
{

    public function allowedActions()
    {
        return '*';
    }

    public function actionWarEffort()
    {
        $model = new WarEffort();
        $this->render('warEffort', array('model' => $model));
    }

    public function actionOnline($realm)
    {
        Database::$realm = (string) $realm;
        $model = new Character('online');
        $model->unsetAttributes();
        $model->online = 1;

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('online', array(
            'model' => $model,
        ));
    }

    public function actionPvp($realm)
    {
        Database::$realm = (string) $realm;
        $model = new Character('pvp');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
        {
            $model->attributes = $_GET['Character'];
        }

        $this->render('pvp', array(
            'model'   => $model,
            'current' => false,
        ));
    }

    public function actionPvpCurrent($realm)
    {
        Database::$realm = (string) $realm;
        $model = new Character('pvp_current');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('pvp', array(
            'model'   => $model,
            'current' => true,
        ));
    }

    public function actionBanned()
    {
        $ipBanned      = new IpBanned('search');
        $accountBanned = new AccountBanned('search');

        $ipBanned->unsetAttributes();
        $this->render('banned', array(
            'ipBanned'      => $ipBanned,
            'accountBanned' => $accountBanned,
        ));
    }

    public function actionStatus($realm)
    {
        Database::$realm = (string) $realm;

        $status = array();

        //TODO rewrite as component and add ip from database;
        $realmid = 1;
        $fp = @fsockopen("78.46.87.100", 8085);
        if($fp)
        {
            $status['online'] = true;
            $chars_db = Database::getConnection(Database::$realm);
            $status['players'] = $chars_db->createCommand("SELECT COUNT(*) FROM characters WHERE online = 1")->queryScalar();
        }
        else
        {
            $status['online'] = false;
            $status['players'] = 0;
        }

        $conn = Database::getConnection();

        $status['maxPlayers']    = $conn->createCommand("SELECT MAX(`maxplayers`) FROM uptime WHERE realmid = :realmid")->queryScalar(array(':realmid' => $realmid));
        $status['uptime'] = $conn->createCommand("SELECT `uptime` FROM `uptime` WHERE `starttime` = (SELECT MAX(`starttime`) FROM `uptime` WHERE realmid = :realmid)")->queryScalar(array(':realmid' => $realmid));
        $info = $conn->createCommand("SELECT `revision`, `name`, `address` FROM `realmlist` WHERE `id` = :realmid")->queryRow(true, array(':realmid' => $realmid));
        $status    = array_merge($status, (is_array($info)) ? $info : array());
        
        echo json_encode($status);
    }

}
