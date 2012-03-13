<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class GalleryConfigForm extends CFormModel
{

    public $thumb_size;

    public function rules()
    {
        return array(
            array('thumb_size', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'thumb_size' => 'Размер превью по умолчанию',
        );
    }

}
