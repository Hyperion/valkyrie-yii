<?php
Yii::import('zii.widgets.grid.CGridColumn');

class CLocationColumn extends CGridColumn
{
    public static $command;
    public $map;
    public $area;
    
    public function init()
    {
    	Yii::log('Init', 'info', 'grid');
    }
    
    protected function renderHeaderCellContent()
    {
        echo $this->grid->dataProvider->getSort()->link('map',$this->header);
    }
    
    protected function renderDataCellContent($row,$data)
    {
    	$column = 'name_'.Yii::app()->language;
        $connection = Yii::app()->db;
        $command = $connection->createCommand()
            ->select("m.$column AS map, a.name_en AS area")
            ->from('wow_maps m, wow_areas a');
        if($data->zone)
            $command->where('m.id = ? AND a.id = ?', array($data->map, $data->zone));
        else
            $command->where('m.id = ?', array($data->map));
        $command->limit(1);
        $row = $command->queryRow();
        $this->map = $row['map'];
        $this->area = $row['area'];
        
        printf('<b>%s</b><br />%s', $this->map, ($data->zone) ? $this->area : 'Undefined'); 
    }
}
