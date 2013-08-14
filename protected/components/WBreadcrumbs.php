<?php
Yii::import('zii.widgets.CBreadcrumbs');

class WBreadcrumbs extends CBreadcrumbs
{
    public function run()
    {
        if(empty($this->links))
            return;

        echo CHtml::openTag('ol',$this->htmlOptions)."\n";

        echo CHtml::openTag('li')."\n";
        if($this->homeLink===null)
            echo CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl, array('rel' => 'np'));
        else if($this->homeLink!==false)
            echo $this->homeLink;

        echo CHtml::closeTag('li');
        $i = 1;
        foreach($this->links as $label=>$url)
        {
            if($i < count($this->links))
                echo CHtml::openTag('li')."\n";
            else if($i == count($this->links))
                echo CHtml::openTag('li', array('class' => 'last'))."\n";
            echo CHtml::link($this->encodeLabel ? CHtml::encode($label) : $label, $url, array('rel' => 'np'));
            echo CHtml::closeTag('li');
            $i++;
        }

        echo CHtml::closeTag('ol');
    }
}