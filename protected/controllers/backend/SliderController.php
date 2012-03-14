<?php

use Imagine\Image\Box;
use Imagine\Image\Point;

class SliderController extends BackendController
{

    public function init()
    {
        parent::init();

        $this->cs->registerCssFile('http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css');
    }

    public function actionAdmin()
    {
        $files = Slider::model()->findAll();
        $this->render('admin', array('files' => $files));
    }

    public function actionUpload()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $path = realpath(Yii::app()->getBasePath() . "/../uploads/slider/") . '/';

            foreach(CUploadedFile::getInstancesByName('files') as $file)
            {
                $model = new Slider;
                $model->file = $file;
                $model->mime_type = $model->file->getType();
                $model->size = $model->file->getSize();
                $model->name = $model->file->getName();

                if($model->validate())
                {
                    if(!is_dir($path))
                        mkdir($path);
                    if(!is_dir($path . 'thumbs'))
                        mkdir($path . 'thumbs');
                    $model->file->saveAs($path . $model->name);
                    $image = Yii::app()->image->open($path . $model->name);
                    $image->thumbnail(new Box(940, 940))->crop(new Point(0, 0), new Box(940, 275))->save($path . $model->name);
                    $image->thumbnail(new Box(120, 80))->save($path . 'thumbs/' . $model->name);

                    $model->save();

                    $info[] = array(
                        'name'          => $model->name,
                        'type'          => $model->mime_type,
                        'size'          => $model->getReadableFileSize(),
                        'thumbnail_url' => $model->thumbnail_url,
                        'url'           => $model->url,
                        'delete_url'    => $this->createAbsoluteUrl('delete', array(
                            'id'          => $model->id
                        )),
                        'delete_type' => 'POST',
                    );
                }
                else
                    throw new CHttpException(500, "Could not upload file");
            }
            echo json_encode($info);
        }
    }

}
