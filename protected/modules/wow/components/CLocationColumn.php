<?php
Yii::import('zii.widgets.grid.CGridColumn');

class CLocationColumn extends CGridColumn
{
    public $sortable = false;
    public $name = 'zone';
       
    public function init()
    {
    	parent::init();
    }
    
    protected function renderHeaderCellContent()
    {
        echo $this->grid->dataProvider->getSort()->link('map',$this->header);
    }
    
    protected function renderDataCellContent($row,$data)
    {
    	$column = 'name_'.Yii::app()->language;
        $connection = Yii::app()->db;
        $area = $connection
            ->createCommand("SELECT $column FROM wow_areas WHERE id = {$data->zone} AND mapID = {$data->map}")
            ->queryScalar();
        
        printf('<b>%s</b>', $area); 
    }
}
