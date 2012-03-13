<?php

class Controller extends BController
{
    public $layout = '//layouts/column1';
    public $user_guid;
    private $_pageDescription = null;
    private $_pageKeywords    = null;
    private $_pageCaption     = null;

    public function allowedActions()
    {
        return 'index, create, view';
    }

    public function init()
    {
        parent::init();
        
        if(!$this->isAjax && Yii::app()->user->isGuest)
            $this->ajaxLinks = array('.ajax-login');

        if(isset(Yii::app()->request->cookies['user_guid']))
            $this->user_guid = Yii::app()->request->cookies['user_guid']->value;
        else
        {
            $cookie = new CHttpCookie('user_guid', uniqid());
            $cookie->expire = time() + 3600 * 24 * 30;
            Yii::app()->request->cookies['user_guid'] = $cookie;
            $this->user_guid = $cookie->value;
        }
    }

    protected function beforeRender($view)
    {
        $this->pageTitle = Yii::app()->config->get('system', 'title');

        if(is_object($this->_model))
        {
            if(isset($this->_model->title) && $this->_model->title)
            {
                $this->pageTitle .= ' - ' . $this->_model->title;
                $this->pageCaption = $this->_model->title;
            }
            if(isset($this->_model->description) && $this->_model->description)
                $this->pageDescription = $this->_model->description;
            if(isset($this->_model->keywords) && $this->_model->keywords)
                $this->pageKeywords = $this->_model->keywords;
        }

        if(!$this->pageDescription)
            $this->pageDescription = Yii::app()->config->get('system', 'description');
        if(!$this->pageKeywords)
            $this->pageKeywords = Yii::app()->config->get('system', 'keywords');

        return parent::beforeRender($view);
    }

    public function getPageDescription()
    {
        if($this->_pageDescription !== null)
            return $this->_pageDescription;
        else
        {
            return '';
        }
    }

    public function setPageDescription($value)
    {
        $this->_pageDescription = $value;
    }

    public function getPageKeywords()
    {
        if($this->_pageKeywords !== null)
            return $this->_pageKeywords;
        else
        {
            return '';
        }
    }

    public function setPageKeywords($value)
    {
        $this->_pageKeywords = $value;
    }

    public function getPageCaption()
    {
        if($this->_pageCaption !== null)
            return $this->_pageCaption;
        else
        {
            return '';
        }
    }

    public function setPageCaption($value)
    {
        $this->_pageCaption = $value;
    }

}
