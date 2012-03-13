<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), array(
            'components' => array(
                'errorHandler' => array(
                    'errorAction' => 'site/error',
                ),
                'user'        => array(
                    'class' => 'RWebUser',
                    'allowAutoLogin' => true,
                    'loginUrl'       => array('/user/login'),
                ),
                'request' => array(
                    'enableCsrfValidation'   => true,
                    'enableCookieValidation' => true,
                ),
                'urlManager'             => array(
                    'urlFormat' => 'path',
                    'rules'     => array(
                        '<_c:\w+>/<id:\d+>'                                    => '<_c>/view',
                        '<_m:\w+>/<_c:\w+>/<id:\d+>'                           => '<_m>/<_c>/view',
                        'wow/<_c:character|guild>/<_a:\w+>/<realm>/<name:\w+>' => 'wow/<_c>/<_a>',
                        'wow/<_c:statistic>/<_a:\w+>/<realm>'                  => 'wow/<_c>/<_a>',
                        '<url:\w+>.html'                                       => 'site/page/url/<url>',
                    ),
                    'showScriptName'                                       => false,
                ),
            ),
                )
);
