<?php
$this->breadcrumbs=array(
	$this->action->id,
);
?>
<h1>Welcome to Admin Panel!</h1>

<p>
Last logined: <?php echo $model->user->username; ?> from <?php echo $model->ip; ?> on <?php echo $model->time; ?><br />
Last URL: <?php echo $model->action; ?>
</p>
