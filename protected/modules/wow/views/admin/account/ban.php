<script type="text/javascript"> 
/*<![CDATA[*/
updateForm = function(id){
        var settings = $.fn.yiiGridView.settings[id];
        var values = [];
        $('#'+id+' .'+settings.tableClass+' > tbody > tr.selected > td').each(function(i){
                 values.push($(this).text());
        });
        if($('#AccountBanForm_method').val() == 0)
          $('#AccountBanForm_value').val(values[0]);
        else if($('#AccountBanForm_method').val() == 1)
          $('#AccountBanForm_value').val(values[5]);
    };
/*]]>*/
</script>

<?php
$this->breadcrumbs=array(
    'Accounts'=>array('index'),
    'Ban',
);

$this->menu=array(
    array('label'=>'Create Account', 'url'=>array('create')),
    array('label'=>'Manage Accounts', 'url'=>array('admin')),
);

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'account-ban-form-account-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'method'); ?>
		<?php echo $form->dropDownList($model,'method',array('0'=>'Ban by id', '1' => 'Ban by ip')); ?>
		<?php echo $form->error($model,'method'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason'); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model,'method',array('0'=>'Active', '1' => 'Not Active'));; ?>
		<?php echo $form->error($model,'active'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Banhammer!'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<?php
    $model->unsetAttributes();
    $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'characters-grid',
        'dataProvider'=>$account->search(),
        'filter'=>$account,
        'columns'=>array(
            'id',
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
        'selectionChanged' => 'updateForm', 
)); ?>