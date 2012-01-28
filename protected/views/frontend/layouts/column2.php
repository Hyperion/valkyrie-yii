<?php $this->beginContent('//layouts/main'); ?>
<?php if ($this->pageCaption !== '') : ?>
    <div class="page-header">
        <h1><?php echo CHtml::encode($this->pageCaption); ?> <small><?php echo CHtml::encode($this->pageDescription) ?></small></h1>
    </div>
<?php endif; ?>
<div class="row">
    <div class="span12">
        <?php echo $content; ?>
    </div>
    <div class="span4">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Operations',
        ));
        $this->widget('zii.widgets.CMenu', array(
            'items'       => $this->menu,
            'htmlOptions' => array('class' => 'operations'),
        ));
        $this->endWidget();
        ?>
    </div>
</div>
<?php $this->endContent(); ?>
