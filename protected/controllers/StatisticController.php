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
        if (isset($_GET['json']))
        {
            Yii::import('ext.yii-json-dataprovider.JSonActiveDataProvider');

            $dataProvider = new JSonActiveDataProvider('Character', array(
                'attributes' => array('name', 'level', 'class_id', 'race', 'zone'),
                'criteria' => array(
                    'condition' => 'online=1 AND account > 0'
                ),
                'pagination' => false,
                'includeDataProviderInformation' => false
            ));

            $this->layout = false;
            header('Content-type: application/json');
            echo $dataProvider->getJsonData();
            Yii::app()->end();
        }

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
        $model = new Character('pvp_current');
        $model->unsetAttributes();

        if(isset($_GET['Character']))
            $model->attributes = $_GET['Character'];

        $this->render('pvp', array(
            'model'   => $model,
            'current' => true,
        ));
    }

    /*public function actionBanned()
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
        $model = Realmlist::model()->find('name = :name', array(':name' => $realm));

        if($model)
        {
            $status = array();

            $status['online'] = (bool) @fsockopen($model->address, $model->port);
            if($status['online'])
                $status['players'] = $model->players;
            else
                $status['players'] = 0;

            $status['maxPlayers'] = $model->maxPlayers;
            $status['uptime'] = $model->uptime;

            $status    = array_merge($status, $model->attributes);

            echo json_encode($status);
        }
    }*/

}
