<?php

class WowModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'wow.models.*',
            'wow.components.*',
        ));

        //Yii::app()->db_world->active = true;

        $assets  = __DIR__ . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if(is_dir($assets) and !Yii::app()->request->isAjaxRequest)
        {
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/page.js');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/tooltip.js');
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/wow.js');
            if(Yii::app()->request->enableCsrfValidation)
            {
                $csrfTokenName = CJavaScript::encode(Yii::app()->request->csrfTokenName);
                $csrfToken = CJavaScript::encode(Yii::app()->request->csrfToken);
                Yii::app()->clientScript->registerScript('TooltipAjax', "Tooltip.csrfToken=$csrfToken;Tooltip.csrfTokenName=$csrfTokenName;", CClientScript::POS_END);
            }
            
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/init.js');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/wow.css');
        }

        Yii::app()->onModuleCreate(new CEvent($this));
    }

    public static function t($str = '', $params = array(), $dic = 'wow')
    {
        return Yii::t("WowModule." . $dic, $str, $params);
    }

    public static function charUrl($model)
    {
        return CHtml::link(
                "<span class=\"icon-frame frame-18\">" . /* CHtml::image("/images/wow/2d/avatar/$data->race-$data->gender.jpg", "", array("height" => 18, "width" => 18)). */"</span><strong>$model->name</strong>"
                , array("/wow/character/view/", "realm" => Database::$realm, "name"  => $model->name), array("class" => "item-link color-c$model->class"));
    }

}
