<?php
Yii::import('zii.widgets.CMenu');

class WProfileSidebarMenu extends CMenu
{
    public function init()
    {
    	$this->htmlOptions = array('class' => 'profile-sidebar-menu');
        $this->id = 'profile-sidebar-menu';
        $this->activeCssClass = 'active';
        parent::init();
    }
    
    protected function renderMenuItem($item)
    {
        if(isset($item['url']))
        {
            $label='<span class="arrow"><span class="icon">'.$item['label'].'</span></span>';
            return CHtml::link($label,$item['url'], array('rel' => 'np'));
        }
        else
            return CHtml::tag('span', array('rel' => 'np'), $item['label']);
    }
}