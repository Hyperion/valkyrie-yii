<?php $this->beginContent('//layouts/main'); ?>
<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
    <div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

        <!-- Sidebar Profile links -->
        <div id="profile-links" style="padding-top: 221px;">
            Hello, <?php echo CHtml::link(Yii::app()->user->name, array('user/user/view', 'id' => Yii::app()->user->id)); ?><br />
            <br />
            <a href="/" title="View the Site">View the Site</a> | <?php echo CHtml::link('Sign Out', array('/user/auth/logout')); ?>
        </div>

<?php $this->widget('zii.widgets.CMenu', array(
    'id'=>'main-nav',
    'items'=>$this->menu,
));
?>
    </div></div> <!-- End #sidebar -->

        <div id="main-content"> <!-- Main Content Section with everything -->
            <noscript> <!-- Show a notification if the user has disabled javascript -->
                <div class="notification error png_bg">
                    <div>
                        Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                    </div>
                </div>
            </noscript>

            <!-- Page Head -->
            <h2>Welcome <?php echo Yii::app()->user->name; ?></h2>

<?php $this->widget('zii.widgets.CBreadcrumbs', array(
    'links'=>$this->breadcrumbs,
)); ?>
            <div class="clear"></div> <!-- End .clear -->
            <?php echo $content; ?>
            <div class="clear"></div>

            <div id="footer">
            </div><!-- End #footer -->

        </div> <!-- End #main-content -->

    </div>
<?php $this->endContent(); ?>
