<script type="text/javascript">
/*<![CDATA[*/
updateForm = function(id){
        var settings = $.fn.yiiGridView.settings[id];
        var values = [];
        $('#'+id+' .'+settings.tableClass+' > tbody > tr.selected > td')
            .each(function(i){
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

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'account-ban-form-account-form',
    'enableAjaxValidation'=>false,
)); ?>

<table>
<tr>
<td colspan="2"><div class="row">
    <p class="note">
        Fields with <span class="required">*</span> are required.
    </p>
    <?php echo $form->errorSummary($model); ?>
</div></td>
</tr>
<tr>
<td width="50%"><div class="row">
    <?php echo $form->labelEx($model,'value'); ?>
    <?php echo $form->textField($model,'value', array(
        'class' => 'text-input large-input'
    )); ?>
    <?php echo $form->error($model,'value'); ?>
</div></td>
<td width="50%"><div class="row">
    <?php echo $form->labelEx($model,'method'); ?>
    <?php echo $form->dropDownList($model,'method',array(
        '0' => 'Ban by id',
        '1' => 'Ban by ip'
    )); ?>
    <?php echo $form->error($model,'method'); ?>
</div></td>
</tr>
<tr>
<td><div class="row">
    <?php echo $form->labelEx($model,'time'); ?>
    <?php echo $form->textField($model,'time', array(
        'class' => 'text-input large-input'
    )); ?>
    <?php echo $form->error($model,'time'); ?>
</div></td>
<td><div class="row">
    <?php echo $form->labelEx($model,'reason'); ?>
    <?php echo $form->textField($model,'reason', array(
        'class' => 'text-input large-input'
    )); ?>
    <?php echo $form->error($model,'reason'); ?>
</div></td>
</tr>
<tr>
<td colspan="2"><div class="row">
    <?php echo $form->labelEx($model,'active'); ?>
    <?php echo $form->dropDownList($model,'method',array(
        '0' => 'Active',
        '1' => 'Not Active'
    )); ?>
    <?php echo $form->error($model,'active'); ?>
</div></td>
</tr>
<tr>
<td colspan="2"><div class="row">
    <?php echo CHtml::submitButton('Banhammer!', array('class' => 'button')); ?>
</div></td>
</tr>
</table>
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
