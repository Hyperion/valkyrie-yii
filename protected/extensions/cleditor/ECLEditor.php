<?php

class ECLEditor extends CInputWidget
{

    public $options = array();

    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        if(isset($this->htmlOptions['id']))
            $id   = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if(isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];
        else
            $this->htmlOptions['name'] = $name;

        if($this->hasModel())
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);

        $options = CJavaScript::encode($this->options);
        Yii::app()->clientScript->registerScript($id, "
			$('#{$id}').cleditor({$options});
		");
    }
}