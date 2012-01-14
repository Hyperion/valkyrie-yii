<?php

class Breadcrumbs extends CFilter
{

    protected function preFilter($filterChain)
    {
        $controller = $filterChain->controller;
        $action_id = $controller->action->id;
        if(isset($controller->_class))
        {
            $model_human_id = trim(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $controller->_class));

            switch($action_id)
            {
                case 'admin':
                    $controller->breadcrumbs = array(
                        Yii::t('models', $model_human_id) => array('admin'),
                        Yii::t('application', 'Admin'),
                    );
                    break;

                case 'create':
                    $controller->breadcrumbs = array(
                        Yii::t('models', $model_human_id) => array('admin'),
                        Yii::t('application', 'Create'),
                    );
                    break;

                case 'update':
                    $controller->breadcrumbs = array(
                        Yii::t('models', $model_human_id) => array('admin'),
                        Yii::t('application', 'Update'),
                    );
                    break;

                case 'view':
                    $controller->breadcrumbs = array(
                        Yii::t('models', $model_human_id) => array('admin'),
                        Yii::t('application', 'View'),
                    );
                    break;
            }
        }
        elseif(isset($controller->title))
        {
            $controller->breadcrumbs = array(
                $controller->title
            );
        }

        return true;
    }

    protected function postFilter($filterChain)
    {
        $controller = $filterChain->controller;

        if(!Yii::app()->request->isAjaxRequest && empty($controller->breadcrumbs))
        {
            throw new CException('Навигация не должна быть пустой');
        }
    }

}
