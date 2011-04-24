<?php
$this->pageTitle=Yii::app()->name . ' - '.$title;

$this->breadcrumbs=array(
	'Documentation' => array('/doc'),
	ucfirst($section) => array('/doc/'.$section.'/toc'),
	$title,
);
?>

<?php
	$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
	echo $content;
	$this->endWidget();
?>