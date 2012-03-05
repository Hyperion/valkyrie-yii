<?php

class SliderController extends BackendController
{

    public function init()
    {
        parent::init();

        $baseUrl = '';

        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.iframe-transport.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.fileupload.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.fileupload-ip.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.fileupload-ui.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/locale.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/main.js', CClientScript::POS_END);
        $this->_cs->registerCssFile($baseUrl . '/css/fileupload-ui/jquery.fileupload-ui.css');
        $this->_cs->registerCssFile('http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css');
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
            Yii::import("ext.xupload.models.XUploadForm");

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
                    {
                        mkdir($path);
                        mkdir($path . 'thumbs');
                    }
                    $model->file->saveAs($path . $model->name);
                    $image = Yii::app()->image->load($path . $model->name);
                    $image->crop(940, 275)->save();
                    $image->resize(120, 80);
                    $image->save($path . 'thumbs/' . $model->name);

                    $model->save();

                    $info[] = array(
                        'name'          => $model->name,
                        'type'          => $model->mime_type,
                        'size'          => $model->getReadableFileSize(),
                        'thumbnail_url' => $model->thumbnail_url,
                        'url'           => $model->url,
                        'delete_url'    => $this->createAbsoluteUrl('delete', array('id'          => $model->id)),
                        'delete_type' => 'DELETE',
                    );
                }
                else
                {
                    echo CVarDumper::dumpAsString($model->getErrors());
                    Yii::log("XUploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "application.extensions.xupload.actions.XUploadAction");
                    throw new CHttpException(500, "Could not upload file");
                }
            }
            echo json_encode($info);
        }
    }

    public function actionDelete($id)
    {
        if(Yii::app()->request->isDeleteRequest)
        {
            $this->loadModel($id)->delete();
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

}
