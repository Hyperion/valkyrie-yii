<?php $this->beginContent('//layouts/main'); ?>
<?php if($this->pageCaption !== '') : ?>
    <div class="page-header">
        <h1><?php echo CHtml::encode($this->pageCaption); ?> <small><?php echo CHtml::encode($this->pageDescription) ?></small></h1>
    </div>
<?php endif; ?>
<div class="row">
    <div class="span9">
        <?php echo $content; ?>
    </div>
    <div class="span3">
        <?php
        $this->widget('BootMenu', array(
            'type'  => 'list',
            'items' => $this->menu,
        ));
        ?>
    </div>
</div>
<?php $this->endContent(); ?>
