<?php
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users') => array('index'),
    Yii::t('UserModule.user', 'Manage'));

if(Yii::app()->user->hasFlash('adminMessage'))
printf('<div class="errorSummary">%s</div>',
        Yii::app()->user->getFlash('adminMessage'));

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
    'filter' => $model,
        'columns'=>array(
            array(
                'name'=>'id',
                'filter' => false,
                'type'=>'raw',
                'value'=>'CHtml::link(CHtml::encode($data->id),
                array("update","id"=>$data->id))',
            ),
            array(
                'name'=>'username',
                'visible' => $this->module->loginType & UserModule::LOGIN_BY_USERNAME,
                'type'=>'raw',
                'value'=>'CHtml::link(CHtml::encode($data->username),
                array("view","id"=>$data->id))',
            ),
            array(
                'name'=>'email',
                'visible' => $this->module->loginType & UserModule::LOGIN_BY_EMAIL,
                'value'=> 'isset($data->profile) ? $data->profile->email : "No email set"',
            ),
            array(
                'name'=>'createtime',
                'filter' => false,
                'value'=>'date(UserModule::$dateFormat,$data->createtime)',
            ),
            array(
                'name'=>'lastvisit',
                'filter' => false,
                'value'=>'date(UserModule::$dateFormat,$data->lastvisit)',
            ),
            array(
                'name'=>'status',
                'filter' => false,
                'value'=>'User::itemAlias("UserStatus",$data->status)',
            ),
            array(
                'class'=>'CButtonColumn',
            ),
)));
