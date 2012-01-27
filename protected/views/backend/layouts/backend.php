<?php $this->beginContent('//layouts/main'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/content/settings/main.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/content/settings/style.css" />
<div class="settings" id="settings">
    <div class="wrapper">
        <div class="grid3">
            <div class="titre">Backgrounds</div>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/bg.png)" class="backgroundChanger active" title="White"></a>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/dark-bg.png)" class="backgroundChanger dark" title="Dark"></a>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/wood.jpg) fixed" class="backgroundChanger dark" title="Wood"></a>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/altbg/smoothwall.png)" class="backgroundChanger" title="Smoothwall"></a>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/altbg/black_denim.png) fixed" class="backgroundChanger dark" title="black_denim"></a>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/altbg/carbon.gif) fixed" class="backgroundChanger dark" title="Carbon"></a>
            <a href="url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/altbg/double_lined.png) fixed" class="backgroundChanger" title="Double lined"></a>
            <div class="clear"></div>
        </div>
        <div class="grid3">
            <div class="titre">Bloc style</div>
            <a href="black" class="blocChanger" title="Black" style="background:url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/bloctitle.png);"></a>
            <a href="white" class="blocChanger active" title="White" style="background:url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/white-title.png);"></a>
            <a href="wood" class="blocChanger" title="Wood" style="background:url(<?php echo Yii::app()->request->baseUrl; ?>/css/img/wood-title.jpg);"></a>
            <div class="clear"></div>
        </div>
        <div class="grid3">
            <div class="titre">Sidebar style</div>
            <a href="grey" class="sidebarChanger active" title="Grey" style="background:#494949"></a>
            <a href="black" class="sidebarChanger" title="Black" style="background:#262626"></a>
            <a href="white" class="sidebarChanger" title="White" style="background:#EEEEEE"></a>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <a class="settingbutton" href="#">

    </a>
</div> 
<div id="head">
    <div class="left">
        <?php
        echo CHtml::link(
                '<img src="' . Yii::app()->request->baseUrl . '/img/icons/top/huser.png" alt="" />', array('user/user/view', 'id' => Yii::app()->user->id), array('class' => 'button profile'));
        ?>
        Hi, 
        <?php echo CHtml::link(Yii::app()->user->name, array('user/user/view', 'id' => Yii::app()->user->id)); ?>
        |
        <a href="/" title="View the Site">View the Site</a> | <?php echo CHtml::link('Logout', array('/user/logout')); ?>
    </div>
    <div class="right">
        <form action="#" id="search" class="search placeholder">
            <label>Looking for something ?</label>
            <input type="text" value="" name="q" class="text"/>
            <input type="submit" value="rechercher" class="submit"/>
        </form>
    </div>
</div>

<div id="sidebar">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => $this->menu,
    ));
    ?>
    <a href="#collapse" id="menucollapse">&#9664; Collapse sidebar</a>
</div>
<div id="content" class="white">
    <?php
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
    ));
    ?>
    <?php echo $content; ?>
</div>
<?php $this->endContent(); ?>
