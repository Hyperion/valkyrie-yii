<?php $this->beginContent('//layouts/main'); ?>
<?php if($this->pageCaption !== '') : ?>
    <div class="page-header">
        <h1><?php echo CHtml::encode($this->pageCaption); ?> <small><?php echo CHtml::encode($this->pageDescription) ?></small></h1>
    </div>
<?php endif; ?>
<?php
$this->widget('BootMenu', array(
    'type'  => 'tabs',
    'items' => array(
        array(
            'label' => 'Сводка',
            'url'   => array('/wow/character/view', 'realm' => Database::$realm, 'name'  => $this->_model->name)
        ),
        array(
            'label' => 'Таланты',
            'url'   => array('/wow/character/talents', 'realm' => Database::$realm, 'name'  => $this->_model->name)
        ),
        array(
            'label' => 'Репутация',
            'url'   => array('/wow/character/reputation', 'realm' => Database::$realm, 'name'  => $this->_model->name)
        ),
        array(
            'label' => 'PvP',
            'url'   => array('/wow/character/pvp', 'realm' => Database::$realm, 'name'  => $this->_model->name)
        ),
        array(
            'label' => 'Лента новостей',
            'url'   => array('/wow/character/feed', 'realm' => Database::$realm, 'name'  => $this->_model->name)
    )),
));
?>
<?php echo $content; ?>
<?php $this->endContent(); ?>