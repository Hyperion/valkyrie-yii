<?php
Yii::import('zii.widgets.grid.CGridColumn');

class CCharsColumn extends CGridColumn
{
    public $name;
    public $value;
    public $sortable;
    
    protected function renderHeaderCellContent()
    {
        echo CHtml::encode($this->name);
    }
    
    protected function renderDataCellContent($row,$data)
    {
        foreach($data->characters as $server => $chars):
            echo '<ul>'.CHtml::encode($server);
            foreach($chars as $char):
                echo '<li>'.CHtml::link(
            	"<span class=\"icon-frame frame-18\">".CHtml::image("/images/wow/2d/avatar/$char->race-$char->gender.jpg", "", array("height" => 18, "width" => 18))."</span><strong>$char->name</strong>"
            	,array("/wow/character/simple/", "realm" => $server, "name" => $char->name),
            	array("class"=>"item-link color-c$char->class")).'</li>';
            endforeach;
            echo '</ul>';
        endforeach;
    }
}
