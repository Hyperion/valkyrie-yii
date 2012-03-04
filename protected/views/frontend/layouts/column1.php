<?php $this->beginContent('//layouts/main'); ?>
<?php if($this->pageCaption !== '') : ?>
    <div class="page-header">
        <h1><?php echo CHtml::encode($this->pageCaption); ?> <small><?php echo CHtml::encode($this->pageDescription) ?></small></h1>
    </div>
<?php endif; ?>

<?php echo $content; ?>

<?php $this->endContent(); ?>