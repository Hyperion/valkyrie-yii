<?php

class FieldsController extends AdminController
{
    const PAGE_SIZE=10;

    public function actionView()
    {
        $this->render('view',array(
            'model'=>$this->loadModel(),
        ));
    }

    public function actionCreate()
    {
        $model = new ProfileField;

        // add to group?
        if(isset($_GET['in_group']))
            $model->field_group_id=$_GET['in_group'];

        if(isset($_POST['ProfileField'])) {
            $model->attributes = $_POST['ProfileField'];

            $field_type = $model->field_type;
            if($field_type == 'DROPDOWNLIST')
                $field_type = 'INTEGER';

            if($model->validate()) {
                $sql = 'ALTER TABLE '.Profile::model()->tableName().' ADD `'.$model->varname.'` ';
                $sql .= $field_type;
                if ($field_type!='TEXT' && $field_type!='DATE')
                    $sql .= '('.$model->field_size.')';
                $sql .= ' NOT NULL ';
                if ($model->default)
                    $sql .= " DEFAULT '".$model->default."'";
                else
                    $sql .= (($field_type =='TEXT' || $model->field_type=='VARCHAR')?" DEFAULT ''":" DEFAULT 0");

                $model->dbConnection->createCommand($sql)->execute();
                $model->save();
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    public function actionUpdate()
    {
        $model=$this->loadModel();
        if(isset($_POST['ProfileField']))
        {
            $model->attributes=$_POST['ProfileField'];

            // ALTER TABLE `test` CHANGE `profiles` `field` INT( 10 ) NOT NULL
            // ALTER TABLE `test` CHANGE `profiles` `description` INT( 1 ) NOT NULL DEFAULT '0'
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel();
            $sql = 'ALTER TABLE '.Profile::model()->tableName().' DROP `'.$model->varname.'`';
            if($model->dbConnection->createCommand($sql)->execute())
                $model->delete();

            if(!isset($_POST['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('ProfileField', array(
            'pagination'=>array(
                'pageSize'=>self::PAGE_SIZE,
            ),
            'sort'=>array(
                'defaultOrder'=>'position',
            ),
        ));

        $this->render('admin',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    public function loadModel()
    {
        if(isset($_GET['id']))
            $model = ProfileField::model()->findByPk($_GET['id']);
        if($model === null)
            throw new CHttpException(404,'The requested User does not exist.');

        return $model;
    }
}
