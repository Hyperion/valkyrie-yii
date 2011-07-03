<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'defaultController' => 'default',
        'components' => array(
            'errorHandler'=>array(
                'errorAction'=>'default/error',
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'rules'=>array(
                    '<_c:\w+>/<id:\d+>'=>'<_c>/view',
                    '<_m:\w+>/<_c:\w+>/<id:\d+>'=>'<_m>/<_c>/view',
                ),
                'showScriptName' => true,
            ),
            'user'=>array(
                'class' => 'application.modules.user.components.WebUser',
                'allowAutoLogin'=>false,
                'loginUrl'=>array('/user/auth'),
            ),
        ),
    )
);
