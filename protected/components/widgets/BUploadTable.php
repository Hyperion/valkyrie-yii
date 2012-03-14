<?php

class BUploadTable extends CWidget
{

    public $files = array();
    public $info = array();

    public function run()
    {
        if(!Yii::app()->getComponent('request')->getIsAjaxRequest())
        {
            $assets  = Yii::getPathOfAlias('application.components.widgets.assets.fileupload-ui');
            $baseUrl = Yii::app()->getComponent('assetManager')->publish($assets);
            if(is_dir($assets))
            {
                $cs = Yii::app()->getClientScript();

                $cs->registerScriptFile($baseUrl . '/jquery.iframe-transport.js', CClientScript::POS_END);
                $cs->registerScriptFile($baseUrl . '/jquery.fileupload.js', CClientScript::POS_END);
                $cs->registerScriptFile($baseUrl . '/jquery.fileupload-ip.js', CClientScript::POS_END);
                $cs->registerScriptFile($baseUrl . '/jquery.fileupload-ui.js', CClientScript::POS_END);
                $cs->registerScriptFile($baseUrl . '/locale.js', CClientScript::POS_END);
                $cs->registerCssFile($baseUrl . '/jquery.fileupload-ui.css');

                if(Yii::app()->getComponent('request')->enableCsrfValidation)
                {
                    $js = array();
                    $options['csrfTokenName'] = CJavaScript::encode(Yii::app()->getComponent('request')->csrfTokenName);
                    $options['csrfToken']     = CJavaScript::encode(Yii::app()->getComponent('request')->csrfToken);

                    foreach($options as $key => $value)
                        $js[] = "{$key}:{$value}";

                    $js = '{' . implode(',', $js) . '}';
                }
                else
                    $js = '';
                
                $cs->registerScript('FileUpload', "$('#fileupload').fileupload({$js});", CClientScript::POS_END);
            }
        }

        $this->render('BUploadTable', array('files' => $this->files, 'info' => $this->info));
    }

}