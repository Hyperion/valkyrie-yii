<?php

$this->breadcrumbs = array(
    UserModule::t('Users') => array('index'),
    $model->username,
);

$this->pageCaption = UserModule::t('View User').' "'.$model->username.'"';

$this->menu = array(
    array('label' => UserModule::t('List User'), 'url'   => array('index')),
    array('label' => UserModule::t('Profile'), 'url'   => array('/user/profile')),
);
// For all users
$attributes = array(
    'username',
);

$profileFields = ProfileField::model()->forAll()->sort()->findAll();
if ($profileFields)
{
    foreach ($profileFields as $field)
    {
        array_push($attributes, array(
            'label' => UserModule::t($field->title),
            'name'  => $field->varname,
            'value' => $model->profile->getAttribute($field->varname),
        ));
    }
}
array_push($attributes, array(
    'name'  => 'createtime',
    'value' => date("d.m.Y H:i:s", $model->createtime),
        ), array(
    'name'  => 'lastvisit',
    'value' => (($model->lastvisit) ? date("d.m.Y H:i:s", $model->lastvisit) : UserModule::t('Not visited')),
        )
);

$this->widget('BootDetailView', array(
    'data'       => $model,
    'attributes' => $attributes,
));