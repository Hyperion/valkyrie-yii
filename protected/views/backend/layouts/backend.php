<?php $this->beginContent('//layouts/main'); ?>
<?php
$this->widget('BootNav', array(
    'type'         => 'fluid',
    'primaryItems' => array(
        array('label'          => 'View the site', 'url'            => '/'),
    ),
    'secondaryItems' => array(
        array('label' => 'Hi, '.Yii::app()->user->name.'!', 'url'   => array('/user/user/view', 'id' => Yii::app()->user->id)),
        array('label' => 'Logout', 'url'   => array('/user/logout')),
    ),
));
?>
<div class="container-fluid">
    <div class="sidebar">
        <div class="well">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => $this->menu,
            ));
            ?>
        </div>
    </div>
    <div class="content">
        <?php
        $this->widget('BootCrumb', array(
            'links' => $this->breadcrumbs,
        ));
        ?>
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
<?php $this->endContent(); ?>
