<?php

class GalleryModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'gallery.models.*',
            'gallery.components.*',
            'gallery.components.behaviors.*',
        ));

        Yii::app()->user->attachBehavior('gallery', 'BGalleryBehavior');   
        Yii::app()->onModuleCreate(new CEvent($this));
    }

    public static function t($str = '', $params = array(), $dic = 'wow')
    {
        return Yii::t("GalleryModule." . $dic, $str, $params);
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

}
