<?php

class BAction extends CAction
{

    protected $_isAjaxRequest;
    protected $_defaultMessages;
    public $messages    = array();

    protected function init()
    {
        $this->_defaultMessages = array(
            'error'       => Yii::t('app', 'There was an error while saving. Please try again.'),
            'postRequest' => Yii::t('app', 'Only post requests are allowed'),
        );

        if(is_array($this->messages))
            $this->messages = CMap::mergeArray($this->_defaultMessages, $this->messages);
        else
            throw new CException(Yii::t('app', 'Action messages need to be an array'));

        $this->_isAjaxRequest = Yii::app()->request->isAjaxRequest;

        if($this->_isAjaxRequest)
        {
            //TODO: implement module based scripts

            $disabledScripts = array(
                'jquery.js',
                'jquery.min.js',
                'jquery-ui.min.js',
                'jquery.cleditor.min.js',       
            );

            if(!is_array($disabledScripts))
                throw new CException(Yii::t('app', 'Disable scripts need to be an array.'));

            foreach($disabledScripts as $script)
                Yii::app()->clientScript->scriptMap[$script] = false;
        }
    }
}
