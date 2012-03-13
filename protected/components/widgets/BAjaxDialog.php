<?php

class BAjaxDialog extends CWidget
{

    public $options = array();
    public $preload = array();
    public $ajaxLinks = array();

    public function run()
    {

        $this->beginWidget('bootstrap.widgets.BootModal', array(
            'id'          => 'update-dialog',
            'htmlOptions' => array('class' => 'hide'),
        ));
        ?>
        <div class="modal-header">
            <a class="close" data-dismiss="modal">&times;</a>
            <h3></h3>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        </div>
        <?php
        $this->endWidget();

        $assets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.components.widgets.assets'));

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets . '/BAjaxDialog.js', CClientScript::POS_END);
        if($this->ajaxLinks !== array())
        {
            $js = '';
            foreach($this->ajaxLinks as $target)
                $js .= "jQuery('{$target}').on('click', ajaxDialogOpen);";
            $cs->registerScript('AjaxDialog', $js, CClientScript::POS_END);
        }
        if(Yii::app()->request->enableCsrfValidation)
        {
            $this->options['csrfTokenName'] = Yii::app()->request->csrfTokenName;
            $this->options['csrfToken'] = Yii::app()->request->csrfToken;
        }

        if($this->options !== array())
        {
            $js = '';
            foreach($this->options as $option => $value)
            {
                $value = CJavaScript::encode($value);
                $js .= "ajaxDialog.{$option} = {$value};";
            }

            $cs->registerScript('AjaxDialogOptions', $js, CClientScript::POS_END);
        }

        foreach($this->preload as $script)
            $cs->registerScriptFile($script, CClientScript::POS_END);
    }

}