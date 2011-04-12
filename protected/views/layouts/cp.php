<?php $this->beginContent('//layouts/main'); ?>
<div id="usermenu" class="prepend-1">
    <?php $this->widget('zii.widgets.CMenu',array('items'=>$this->usermenu)); ?>
</div>
<div class="container">
    <div class="span-5 prepend-1">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
	<div class="span-18 last">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>