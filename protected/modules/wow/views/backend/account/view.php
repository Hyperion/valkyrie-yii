<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    $model->id,
);

?>

<h1>View Account #<?php echo $model->id; ?></h1>

<?php $this->widget('BootDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'username',
        'gmlevel',
        'email',
        'joindate',
        'last_ip',
        'failed_logins',
        'locked',
        'last_login',
        'active_realm_id',
        'mutetime',
        'locale',

    ),
)); ?>
