<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //'keyPrefix' => 'myapp',		//唯一键的前缀
        ],
        'authManager' => [
        	'class' => 'yii\rbac\DbManager',
        ],
    ],
];
