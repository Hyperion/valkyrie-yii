<?php
$this->breadcrumbs=array(
    'Accounts',
);

$this->menu=array(
    array('label'=>'create account', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('add', "
$('.add-button').click(function(){
    $('.add-form').toggle();
    return false;
});
$('.add-form form').submit(function(){
    $.fn.yiiGridView.update('accounts-list', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Accounts</h1>

<?php echo CHtml::link('Add Account','#',array('class'=>'add-button')); ?>
<div class="add-form" style="display:none">
<?php $this->renderPartial('_login',array(
    'model'=>$model,
)); ?>
</div>

<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'accounts-list',
    'dataProvider' => $model->userRelated(),
    'itemView'=>'_view',
)); ?>