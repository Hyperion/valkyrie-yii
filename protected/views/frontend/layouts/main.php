<!doctype html>
<html>
    <head>
        <meta charset=utf-8>
        <?php $this->_cs->registerCssFile(Yii::app()->request->baseUrl . '/css/main.css'); ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <?php
        $this->widget('BootNavbar', array(
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.BootMenu',
                    'items' => MenuTree::getItems(),
                ),
                array(
                    'class'       => 'bootstrap.widgets.BootMenu',
                    'htmlOptions' => array('class' => 'pull-right'),
                    'items' => array(
                        array('label' => 'Login', 'url'   => array('/user/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'My profile', 'url'   => array('/user/profile'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url'   => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest)
                )))
        ));
        ?>
        <div class="container">

            <div class="content">
                <?php
                $this->widget('BootCrumb', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
                <?php echo $content; ?>
            </div>
            <footer>
                <div  id="language-selector" style="float:right; margin:5px;">
                    <?php $this->widget('application.components.widgets.LanguageSelector'); ?>
                </div>
                Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
                All Rights Reserved.<br/>
                <?php echo Yii::powered(); ?>
            </footer><!-- footer -->

        </div><!-- page -->
    </body>
</html>
