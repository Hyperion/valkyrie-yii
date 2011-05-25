<?php
$this->breadcrumbs=array(
	'Statistic'=>array('index'),
    'Ahn\'Qiraj War Effort',
);?>
<h1>Ahn'Qiraj War Effort</h1>

Horde:<hr />
<?php foreach($model->fetch('horde') as $entry): ?>
<?php echo $entry['name'] ?> : <?php echo $entry['count']*$entry['complited'] ?> / <?php echo $entry['max'] ?>
<br />
<?php endforeach; ?>
<br />
Alliance:<hr />
<?php foreach($model->fetch('alliance') as $entry): ?>
<?php echo $entry['name'] ?> : <?php echo $entry['count']*$entry['complited'] ?> / <?php echo $entry['max'] ?>
<br />
<?php endforeach; ?>

