<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest',
            'editOwnAccount',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Moderator',
        'children' => array(
            'user',          // позволим модератору всё, что позволено пользователю
        ),
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',
            'editAccount',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'editOwnAccount' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Edit own Account',
        'children' => array(
            'editAccount',
        ),
        'bizRule' => 'return in_array($_GET["id"], Yii::app()->user->accounts);',
        'data' => null,
    ),
    'editAccount' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Edit Account info',
        'bizRule' => null,
        'data' => null,
    ),
);