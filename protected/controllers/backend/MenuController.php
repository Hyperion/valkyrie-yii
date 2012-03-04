<?php

/**
 * Description of MenuController
 *
 * @author gabriel
 */
class MenuController extends BackendController
{

    public function actions()
    {
        return array();
    }

    public function actionAdmin()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/dynatree/jquery.dynatree.min.js');
        $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/contextmenu/jquery.contextMenu-custom.js');
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/js/contextmenu/jquery.contextMenu.css');
        $cs->registerCssFile(Yii::app()->request->baseUrl . '/js/dynatree/skin-vista/ui.dynatree.css');
        
        /*$root = new Menu();
        $root->title = 'Menu';
        $root->saveNode();*/

        $this->render('admin');
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if(isset($_POST['Menu']) and Yii::app()->request->isAjaxRequest)
        {
            $model->attributes = $_POST['Menu'];
            if($model->saveNode())
            {
                echo 'complete';
                Yii::app()->end();
            }
            else
            {
                echo CHtml::errorSummary($model);
                Yii::app()->end();
            }
        }
        echo $this->renderPartial('update', array('model' => $model), true);
    }

    public function actionCreate()
    {
        $model = new Menu();
        if(isset($_POST['Menu']) and Yii::app()->request->isAjaxRequest)
        {
            $model->attributes = $_POST['Menu'];
            $root = Menu::model()->findByPk((int) $_POST['root']);
            if($model->appendTo($root))
            {
                $data_json = array('id'    => $model->id, 'title' => $model->title);
                exit(json_encode($data_json));
            }
        }
        echo $this->renderPartial('create', array('model' => $model, 'root'  => $_POST['root']), true);
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            $this->loadModel((int) $_POST['id'])->deleteNode();
            exit('complete');
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionMove()
    {
        $node       = $_POST['node'];
        $sourceNode = $_POST['sourceNode'];
        $hitMode    = $_POST['hitMode'];

        $sourceNode = Menu::model()->findByPk($sourceNode['id']);
        $node       = Menu::model()->findByPk($node['id']);

        switch($hitMode)
        {
            case 'before':
                $sourceNode->moveBefore($node);
                break;
            case 'after':
                $sourceNode->moveAfter($node);
                break;
            case 'over':
                $sourceNode->moveAsFirst($node);
            default:
                break;
        }

        echo json_encode($_POST);
        exit;
    }

    public function actionJson()
    {
        $nodes = Menu::model()->findAll(array('order' => 'lft'));
        $level  = 1;

        $path = array();

        foreach($nodes as $f)
        {
            $isFolder = false;
            if($f->level > $level)
            {
                if($f->level != $level + 1 || !count($path[$level]))
                    throw new CHttpException(404, 'Netsed set error.');

                $path[$f->level]                                    = &$path[$level][count($path[$level]) - 1]['children'];
                if($level < 2)
                    $path[$level][count($path[$level]) - 1]['isFolder'] = true;
                else
                    $path[$level][count($path[$level]) - 1]['isFolder'] = false;
            }
            $path[$f->level][]                                  = array(
                'id'       => $f->id,
                'key'      => 'id' . $f->id,
                'isFolder' => $isFolder,
                'title'    => $f->title,
                'children' => array());
            $level = $f->level;
        }

        echo(json_encode($path[1]));
    }

}