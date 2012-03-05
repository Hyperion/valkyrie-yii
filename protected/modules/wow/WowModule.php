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

        Yii::app()->onModuleCreate(new CEvent($this));
    }

    public static function t($str = '', $params = array(), $dic = 'wow')
    {
        return Yii::t("WowModule.".$dic, $str, $params);
    }
    
    public static function charUrl($model)
    {
        return CHtml::link(
            	"<span class=\"icon-frame frame-18\">"./*CHtml::image("/images/wow/2d/avatar/$data->race-$data->gender.jpg", "", array("height" => 18, "width" => 18)).*/"</span><strong>$model->name</strong>"
            	,array("/wow/character/view/", "realm" => Database::$realm, "name" => $model->name),
            	array("class"=>"item-link color-c$model->class"));
    }

}
