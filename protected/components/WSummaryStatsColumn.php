<?php

class WSummaryStatsColumn extends CWidget
{
	public $items = array();
	public $htmlOptions = array();
	public $visible = true;
	public $title;

    public function init()
    {
    	$this->htmlOptions = array('class' => 'summary-stats-column');
		if(!$this->visible)
			$this->htmlOptions['style'] = 'display: none;';

		$this->items=$this->normalizeItems($this->items);
    }

   	public function run()
	{
		$this->renderMenu($this->items);
	}

	protected function renderMenu($items)
	{
		if(count($items))
		{
			echo CHtml::openTag('div', $this->htmlOptions)."\n";
			echo CHtml::tag('h4', array(), $this->title);
			echo CHtml::openTag('ul')."\n";
			$this->renderMenuRecursive($items);
			echo CHtml::closeTag('ul');
			echo CHtml::closeTag('div');
		}
	}
	
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();

			echo CHtml::openTag('li', $options)."\n";
			$this->renderMenuItem($item);
			echo CHtml::closeTag('li')."\n";
		}
	}

    protected function renderMenuItem($item)
    {
		if(isset($item['htmlOptions']['class']))
			$item['htmlOptions']['class'] = 'value'.$item['htmlOptions']['class'];
		else
			$item['htmlOptions']['class'] = 'value';
		if(isset($item['itemOptions']['class']) AND $item['itemOptions']['class'] == 'has-icon')
		{
			echo CHtml::openTag('span', array('class' => 'icon'));
			echo CHtml::openTag('span', array('class' => 'icon-frame frame-12'));
			echo CHtml::image(
				"http://media.blizzard.com/wow/icons/18/{$item['icon']}.jpg",
				'', array('width' => 12, 'height' => 12));
			echo CHtml::closeTag('span');
			echo CHtml::closeTag('span'); 
		}

    	echo CHtml::tag('span', array('class' => 'name'), $item['label']);
		echo CHtml::tag('span', $item['htmlOptions'], $item['value']);
		echo CHtml::tag('span', array('class' => 'clear'), '<!-- -->');
    }
	
	protected function normalizeItems($items)
	{
		foreach($items as $i=>$item)
		{
			if(!isset($item['label']))
				$item['label']='';
			$items[$i]['label']=CHtml::encode($item['label']);
		}
		return array_values($items);
	}
}
