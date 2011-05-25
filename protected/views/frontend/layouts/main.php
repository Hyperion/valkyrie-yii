<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<?php $this->widget('WLogin'); ?>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $searchForm = new SearchForm; ?>
		<?php $form=$this->beginWidget('CActiveForm', array('action' => '/site/search')); ?>
        	<?=$form->textField($searchForm,'query'); ?>
			<?=CHtml::submitButton('Поиск'); ?>
		<?php $this->endWidget(); ?>
		<?php $this->widget('zii.widgets.CMenu',array(
			'encodeLabel'=>false,
			'items'=>$this->mainmenu)); ?>
	</div><!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Hyperion.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?><br/>
        Отпахало за <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?> с. Сожрано памяти: <?=round(memory_get_peak_usage()/(1024*1024),2)."MB"?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
