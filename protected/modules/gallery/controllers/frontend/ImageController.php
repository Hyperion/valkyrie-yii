<?php

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\Color;
use Imagine\Imagick\Font;

class ImageController extends Controller
{

    private $_path;
    private $_filename;
    private $_subfolder;
    private $_form;

    public function actionIndex()
    {
        foreach(Yii::app()->user->images as $id)
            echo CHtml::link("Delete $id", array('delete', 'id' => $id));
    }
    
    public function actionCreate()
    {
        $this->_form = new ImageParamsForm;

        if(isset($_POST['ImageParamsForm']))
        {
            $this->_form->attributes = $_POST['ImageParamsForm'];
            if(!$this->_form->validate())
            {
                echo json_encode($this->_form->errors);
                Yii::app()->end();
            }
        }
        if(!$this->_form->use_thumb_resize)
            $this->_form->thumb_resize = Yii::app()->config->get('gallery', 'thumb_size');

        if(Yii::app()->request->isPostRequest)
        {
            $this->_path = realpath(Yii::app()->getBasePath() . "/../uploads");

            $this->_subfolder = ($this->_form->album_id) ? $this->_form->album_id : date("mdY");
            $this->_path .= '/' . $this->_subfolder . '/';
            $info = array();

            foreach(CUploadedFile::getInstancesByName('files') as $file)
            {
                $model = new Image;
                $model->image = $file;
                $model->mime_type = $model->image->getType();

                if($model->validate())
                {
                    if(!is_dir($this->_path))
                    {
                        mkdir($this->_path);
                        mkdir($this->_path . 'thumbs');
                    }
                    $name = sha1($model->image->name . time()) . '.' . $model->image->extensionName;
                    $this->_filename = $this->_path . $name;

                    $model->image->saveAs($this->_filename);

                    $image = Yii::app()->image->open($this->_filename);
                    if($this->_form->use_resize)
                        $image = $image->thumbnail(
                                new Box((int) $this->_form->resize, (int) $this->_form->resize)
                            )->save((string) $this->_filename);

                    $model->height = $image->getSize()->getHeight();
                    $model->width = $image->getSize()->getWidth();

                    $image->thumbnail(
                        new Box((int) $this->_form->thumb_resize, (int) $this->_form->thumb_resize)
                    )->save((string) $this->_path . 'thumbs/' . $name);

                    if($this->_form->use_watermark)
                        $this->addWatermark($image);

                    $model->size = filesize($this->_filename);

                    $model->url = '/uploads/' . $this->_subfolder . '/' . $name;
                    $model->thumb_url = '/uploads/' . $this->_subfolder . '/thumbs/' . $name;

                    $model->album_id = $this->_form->album_id;

                    if($model->save())
                        $info[] = array(
                            'name'               => $model->image->name,
                            'type'               => $model->mime_type,
                            'size'               => $model->size,
                            'thumbnail_url'      => $model->thumb_url,
                            'url'                => $model->url,
                            'view_url'           => $model->viewUrl,
                            'absolute_url'       => $model->absoluteUrl,
                            'thumb_absolute_url' => $model->thumbAbsoluteUrl,
                            'html_code'          => $model->htmlCode,
                            'bb_code'            => $model->BBCode,
                            'delete_url'         => $this->createAbsoluteUrl('delete', array('id'          => $model->id)),
                            'delete_type' => 'POST',
                        );
                }
                else
                {
                    echo CVarDumper::dumpAsString($model->getErrors());
                    Yii::log("UploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "application.modules.gallery.controllers.DefaultController");
                    throw new CHttpException(500, "Could not upload file");
                }
            }
            echo json_encode($info);
            Yii::app()->end();
        }

        $this->render('create', array('model' => $this->_form));
    }
    
    public function actionView($id)
    {
        $model      = $this->loadModel($id);
        $model->saveCounters(array('visits'=>1));
        
        $this->render('view', array('model' => $model));
    }
    
    protected function addWatermark($image)
    {
        $imagick = new Imagick();
        $fonts   = ImageParamsForm::getFonts();
        $font    = Yii::app()->getBasePath() . '/../fonts/' . $fonts[$this->_form->watermark_font] . '.ttf';
        if(!file_exists($font))
            throw new CException(404, 'Font file doesn\'t exists!');

        $color = new Color((string) $this->_form->watermark_color, (int) $this->_form->watermark_alfa);

        $image->draw()->text(
            $this->_form->watermark, new Font($imagick, $font, $this->_form->watermark_size, $color), new Point($this->_form->watermark_left, $this->_form->watermark_top)
        );

        $image->save($this->_filename);
    }

}
