<?php $this->beginContent('//layouts/main'); ?>
<?php
$this->widget('BootNavbar', array(
    'fluid' => true,
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.BootMenu',
            'items' => array(
                array('label' => 'View the site', 'url'   => '/'),
        )),
        array(
            'class'       => 'bootstrap.widgets.BootMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items' => array(
                array('label' => 'Hi, ' . Yii::app()->user->name . '!', 'url'   => array('/user/user/view', 'id' => Yii::app()->user->id)),
                array('label' => 'Logout', 'url'   => array('/user/logout')),
        )))
));
?>
<div class="container-fluid" style="padding-top: 60px">
    <div class="row-fluid">
        <div class="span3">
            <div class="well">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => $this->menu,
                ));
                ?>
            </div>
        </div>
        <div class="span9">
            <?php
            $this->widget('BootBreadcrumbs', array(
                'links' => $this->breadcrumbs,
            ));
            ?>
            <?php $this->widget('BootAlert'); ?>
            <?php echo $content; ?>
            <footer>
                <div  id="language-selector" style="float:right; margin:5px;">
                    <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                </div>
                Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
                All Rights Reserved.<br/>
                <?php echo Yii::powered(); ?>
            </footer>
        </div>
    </div>
</div>
<?php
$this->widget('application.components.widgets.BAjaxDialog', array(
    'ajaxLinks' => $this->ajaxLinks,
    'options'   => $this->ajaxOptions,
));
?>
<?php $this->endContent(); ?>