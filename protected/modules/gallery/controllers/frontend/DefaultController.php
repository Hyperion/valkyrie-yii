<?php

class DefaultController extends Controller
{

    public $subfolderVar = false;
    public $path;
    private $_subfolder;

    public function init()
    {
        parent::init();

        $baseUrl = Yii::app()->request->baseUrl;

        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.iframe-transport.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.fileupload.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.fileupload-ip.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/jquery.fileupload-ui.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/locale.js', CClientScript::POS_END);
        $this->_cs->registerScriptFile($baseUrl . '/js/fileupload-ui/main.js', CClientScript::POS_END);
        $this->_cs->registerCssFile($baseUrl . '/css/fileupload-ui/jquery.fileupload-ui.css');
        $this->_cs->registerCssFile('http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css');
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionUpload()
    {
        if(Yii::app()->request->isPostRequest)
        {
            Yii::import("ext.xupload.models.XUploadForm");

            $this->subfolderVar = 'parent_id';
            $this->path = realpath(Yii::app()->getBasePath() . "/../images/uploads");
            $model = new XUploadForm;
            if($this->subfolderVar !== false)
            {
                $this->_subfolder = Yii::app()->request->getQuery($this->subfolderVar, date("mdY"));
            }
            else
            {
                $this->_subfolder = date("mdY");
            }

            foreach(CUploadedFile::getInstancesByName('files') as $file)
            {
                $model->file = $file;
                $model->mime_type = $model->file->getType();
                $model->size = $model->file->getSize();
                $model->name = $model->file->getName();

                if($model->validate())
                {
                    $path = $this->path . "/" . $this->_subfolder . "/";
                    if(!is_dir($path))
                    {
                        mkdir($path);
                        mkdir($path. 'thumbs');
                    }
                    $model->file->saveAs($path . $model->name);
                    $image  = Yii::app()->image->load($path . $model->name);
                    $image->resize(120, 80);
                    $image->save($path . 'thumbs/' . $model->name);
                    $info[] = array(
                        'name'          => $model->name,
                        'type'          => $model->mime_type,
                        'size'          => $model->getReadableFileSize(),
                        'thumbnail_url' => '/images/uploads/' . $this->_subfolder . '/thumbs/' . $model->name,
                        'url'           => '/images/uploads/' . $this->_subfolder . '/' . $model->name,
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

}
