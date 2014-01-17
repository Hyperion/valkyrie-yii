<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/local-common/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/wow/wow.css"/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="<?= $this->body_class ?>">
<div id="wrapper">
    <div id="header">

        <h1 id="logo"><a href="/">World of Warcraft</a></h1>

        <div class="header-plate">
        </div>
    </div>
    <div id="content">
        <div class="content-top">
            <div class="content-trail">
                <?php
                $this->widget('WBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'htmlOptions' => array('class' => 'ui-breadcrumb'),
                ));
                ?>
            </div>
            <div class="content-bot"><?php echo $content; ?></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    //<![CDATA[
    $(function() {
        Menu.initialize('<?= Yii::app()->request->baseUrl ?>/data/menu.json');
    });
    //]]>
</script>
</body>
</html>
