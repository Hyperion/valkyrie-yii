<?php

return CMap::mergeArray(
        require(dirname(__FILE__) . '/main.php'), array(
        'components' => array(
            'errorHandler' => array(
                'errorAction' => 'site/error',
            ),
            'user'        => array(
                'class'          => 'RWebUser',
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
                    '<url:\w+>.html'                                       => 'site/page/url/<url>',
                    array('wow/<_c>/<_a>', 'pattern'=>'wow/<_c:statistic>/<realm>/<_a:\w+>', 'urlSuffix'=>'.json', 'caseSensitive'=>false),
                    array('wow/<_c>/<_a>', 'pattern'=>'wow/<_c:statistic>/<realm>/<_a:\w+>', 'urlSuffix'=>'.xml', 'caseSensitive'=>false),
                    array('wow/<_c>/<_a>', 'pattern'=>'wow/<_c:statistic>/<realm>/<_a:\w+>', 'caseSensitive'=>false),
                ),
                'showScriptName' => false,
            ),
        ),
        )
);
