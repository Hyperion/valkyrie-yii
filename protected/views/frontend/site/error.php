<?php
$this->pageTitle=Yii::app()->name . ' - Error';
?>
<div id="server-error">
	<h2 class="http"><?php echo $code; ?>,<br />ай-ай-ай</h2>
	<p><?php echo CHtml::encode($message); ?></p>
</div>