<?php

class ImageParamsForm extends CFormModel
{

    public $use_watermark = 0;
    public $watermark;
    public $watermark_font = 0;
    public $watermark_alfa = 0;
    public $watermark_size  = 80;
    public $watermark_top   = 80;
    public $watermark_left  = 80;
    public $use_resize = 0;
    public $resize;
    public $use_thumb_resize = 0;
    public $thumb_resize    = 200;
    public $album_id        = 0;
    public $watermark_color = 'ffffff';

    public function rules()
    {
        return array(
            array('use_watermark, use_resize, use_thumb_resize', 'boolean'),
            array('resize', 'numerical', 'integerOnly' => true, 'min'         => '150', 'max'         => '800', 'allowEmpty'  => true),
            array('thumb_resize', 'numerical', 'integerOnly' => true, 'min'         => '30', 'max'         => '300', 'allowEmpty'  => true),
            array('watermark_alfa', 'numerical', 'integerOnly' => true, 'min'         => '0', 'max'         => '100', 'allowEmpty'  => true),
            array('album_id, watermark_size, watermark_top, watermark_left', 'numerical', 'integerOnly' => true, 'allowEmpty'  => true),
            array('watermark_font, watermark, watermark_color', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'use_watermark'    => 'Использовать водяной знак',
            'use_resize'       => 'Изменить размер изображения',
            'resize'           => 'Максимальный размер нового изображения',
            'use_thumb_resize' => 'Изменить размер превью',
            'thumb_resize'     => 'Максимальный размер превью',
            'watermark'        => 'Водяной знак',
            'watermark_font'   => 'Шрифт',
            'watermark_alfa'   => 'Прозрачность в %',
            'watermark_size'   => 'Размер, в пикселях',
            'watermark_left'   => 'Отступ слева',
            'watermark_top'    => 'Отступ сверху',
            'watermark_color'  => 'Цвет',
            'album_id'         => 'Альбом',
        );
    }

    public static function getFonts()
    {
        $files = scandir(Yii::app()->getBasePath() . "/../fonts");
        $fonts = array();
        if($files)
            foreach($files as $file)
                if(strpos($file, '.ttf'))
                    $fonts[] = str_replace('.ttf', '', $file);
        return $fonts;
    }

}
