<?php
$this->breadcrumbs = array(
    UserModule::t("Users"),
);
$this->pageCaption = UserModule::t("List User");
$this->widget('BootGridView', array(
    'dataProvider' => $dataProvider,
    'columns'      => array(
        array(
            'name'  => 'username',
            'type'  => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
        ),
        array(
            'name'  => 'createtime',
            'value' => 'date("d.m.Y H:i:s",$data->createtime)',
        ),
        array(
            'name'  => 'lastvisit',
            'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
        ),
    ),
));