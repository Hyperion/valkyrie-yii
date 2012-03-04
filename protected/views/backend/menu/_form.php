<div class="form">

    <?php
    $form = $this->beginWidget('BootActiveForm', array(
        'enableAjaxValidation' => true,
        'type' => 'horizontal',
        'htmlOptions'          => array('enctype' => 'multipart/form-data', 'class'   => 'treenodeform'),
            ));
    ?>

    <p class="note">Объязательные поля помечены звездочкой: <span class="required">*</span>.</p>

    <?php echo CHtml::errorSummary($model); ?>
    <?php
    if(!$model->isNewRecord)
        echo $form->hiddenField($model, 'id');
    else
        echo Chtml::hiddenField('root', $root);
    ?>
    <?php echo $form->textFieldRow($model, 'title'); ?>
    <?php echo $form->textFieldRow($model, 'url'); ?>
    <?php echo $form->textFieldRow($model, 'alt'); ?>

    <div class="form-actions">
        <?php
        echo CHtml::button(
                $model->isNewRecord ? 'Создать' : 'Сохранить', array('class'   => 'btn btn-primary', 'onclick' => $model->isNewRecord ? 'createNode()' : 'updateNode()')
        );
        ?>
        <?php echo CHtml::button('Отмена', array('class'   => 'btn', 'onclick' => 'cancelNode()')); ?>
        <a class="btn" id="url_button" onclick='$("#mydialog").dialog("open"); return false;' style="display: inline-block; float:none;"><span>Связать</span></a>
    </div>

    <?php $this->endWidget(); ?>

</div>