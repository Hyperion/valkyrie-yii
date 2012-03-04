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

<?php $form=$this->beginWidget('BootActiveForm', array(
    'id'=>'account-ban-form-account-form',
    'enableAjaxValidation'=>false,
)); ?>

<table width="100%">
<tr>
<td colspan="2">
    <p class="note">
        Fields with <span class="required">*</span> are required.
    </p>
    <?php echo $form->errorSummary($model); ?>
</td>
</tr>
<tr>
<td width="50%">
    <?php echo $form->textFieldRow($model,'value'); ?>
</td>
<td width="50%">
    <?php echo $form->dropDownListRow($model,'method',array(
        '0' => 'Ban by id',
        '1' => 'Ban by ip'
    )); ?>
</td>
</tr>
<tr>
<td>
    <?php echo $form->textFieldRow($model,'time'); ?>
</td>
<td>
    <?php echo $form->textFieldRow($model,'reason'); ?>
</td>
</tr>
<tr>
<td colspan="2">
    <?php echo $form->dropDownListRow($model,'method',array(
        '0' => 'Active',
        '1' => 'Not Active'
    )); ?>
</td>
</tr>
<tr>
<td colspan="2"><div class="form-actions">
    <?php echo CHtml::submitButton('Banhammer!', array('class' => 'btn btn-danger')); ?>
</div></td>
</tr>
</table>
<?php $this->endWidget(); ?>

<?php
    $model->unsetAttributes();
    $this->widget('BootGridView', array(
        'id'=>'characters-grid',
        'dataProvider'=>$account->search(),
        'filter'=>$account,
        'columns'=>array(
            'id',
            'username',
            'email',
            'last_ip'
        ),
        'selectionChanged' => 'updateForm',
)); ?>
