<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GalleryModule
 *
 * @author gabriel
 */
class GalleryModule extends CWebModule
{

    public function init()
    {
        $this->setImport(array(
            'gallery.models.*',
            'gallery.components.*',
        ));

        Yii::app()->onModuleCreate(new CEvent($this));
    }
}
