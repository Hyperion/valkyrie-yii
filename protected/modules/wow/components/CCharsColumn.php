<?php
Yii::import('zii.widgets.grid.CGridColumn');

class CCharsColumn extends CGridColumn
{
    public $name;
    public $value;
    
    protected function renderHeaderCellContent()
	{
		echo CHtml::encode($this->name);
	}
    
    protected function renderDataCellContent($row,$data)
	{
        foreach($data->characters as $server => $chars):
            echo '<ul>'.CHtml::encode($server);
            foreach($chars as $char):
                echo '<li>'.CHtml::link($char['name'],
					array('/wow/character/simple/', 'realm' => $server, 'name' => $char['name'])).'</li>';
            endforeach;
            echo '</ul>';
        endforeach;
	}
}
