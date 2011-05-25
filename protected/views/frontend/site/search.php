<?php
$this->pageTitle=Yii::app()->name . ' - Seaarch';
$this->breadcrumbs=array(
	'Search',
);
?>

<h1>Search</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'query'); ?>
		<?php echo $form->textField($model,'query'); ?>
	</div>

	<div class="row submit">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>
<? if($dataProvider): 

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'/post/_view',
    'template'=>"{items}\n{pager}",
));

endif; ?>
