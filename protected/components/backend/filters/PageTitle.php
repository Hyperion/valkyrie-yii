<?php

class PageTitle extends CFilter
{
    protected function preFilter($filterChain)
    {
        $controller = $filterChain->controller;
        $action_id = $controller->getAction()->getId();

        switch($action_id) {
            case 'admin':
            case 'create':
            case 'update':
            case 'view':
                $controller->pageTitle = Yii::t('application', ucfirst($action_id));
            break;
        }

        return true;
    }

    protected function postFilter($filterChain)
    {
        $controller = $filterChain->controller;

        if (!Yii::app()->request->isAjaxRequest && empty($controller->pageTitle)) {
            throw new CException('Название страницы пустое');
        }
    }
}
