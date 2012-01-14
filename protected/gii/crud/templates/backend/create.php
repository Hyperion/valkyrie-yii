<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('admin'),
	'Добавить',
);\n";
?>

?>

<h1>Добавить <?php echo $this->modelClass; ?></h1>
<div class="bloc">
    <div class="title"><?php echo $this->modelClass; ?></div>
    <div class="content">
<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
    </div>
</div>