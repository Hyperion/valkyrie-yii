<?php
$this->breadcrumbs=array(
    Yii::t('UserModule.user', 'Profile fields')=>array('index'),
    $model->title=>array('view','id'=>$model->id),
    Yii::t('UserModule.user', 'Update'));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
