<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'theme' => 'wow',
        'components' => array(
            'errorHandler'=>array(
                'errorAction'=>'site/error',
            ),
            'user'=>array(
                'class' => 'application.modules.wow.components.WowUser',
                'allowAutoLogin'=>true,
                'loginUrl'=>array('/user/auth'),
            ),
            'urlManager'=>array(
                'urlFormat'=>'path',
                'rules'=>array(
                    '<_c:\w+>/<id:\d+>'=>'<_c>/view',
                    '<_m:\w+>/<_c:\w+>/<id:\d+>'=>'<_m>/<_c>/view',
                    'doc/<section>/<page>'=>'doc/default/view',
                    'wow/<_c:character|guild>/<_a:\w+>/<realm>/<name:\w+>'=>'wow/<_c>/<_a>',
                    'wow/<_c:statistic>/<_a:\w+>/<realm>'=>'wow/<_c>/<_a>',
                ),
                'showScriptName' => false,
            ),
        ),
    )
);
