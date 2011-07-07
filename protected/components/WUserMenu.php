<?php

class WUserMenu extends CWidget
{
    public $items=array();

    public function init()
    {
        $route=$this->getController()->getRoute();
        $this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
    }

    public function run()
    {
        $this->renderMenu($this->items);
    }

    protected function renderMenu($items)
    {
        if(count($items))
        {
            echo CHtml::openTag('ul')."\n";
            $this->renderMenuRecursive($items);
            echo CHtml::closeTag('ul');
        }
    }

    protected function renderMenuRecursive($items)
    {
        $count=0;
        $n=count($items);
        foreach($items as $item)
        {
            $count++;
            $options=array();
            if($item['active'])
                $options['class']='active';

            echo CHtml::openTag('li', $options);

            echo $this->renderMenuItem($item);

            if(isset($item['items']) && count($item['items']))
            {
                echo "<div class=\"flyout-menu\" id=\"{$item['id']}-menu\" style=\"display: none\">";
                echo "\n".CHtml::openTag('ul')."\n";
                $this->renderMenuRecursive($item['items']);
                echo CHtml::closeTag('ul')."\n";
                echo "</div>";
            }

            echo CHtml::closeTag('li')."\n";
        }
    }

    protected function renderMenuItem($item)
    {
        $item['url'] = isset($item['url']) ? $item['url'] : '#';
        if(isset($item['id']))
            return CHtml::link($item['label'],$item['url'],array(
                'class' => 'border-3 menu-arrow',
                'onClick' => "openAccountDropdown(this, '{$item['id']}'); return false;"
            ));
        else
            return CHtml::link($item['label'],$item['url']);
    }

    protected function normalizeItems($items,$route,&$active)
    {
        foreach($items as $i=>$item)
        {
            $items[$i]['label']=CHtml::encode($item['label']);

            $hasActiveChild=false;
            if(isset($item['items']))
            {
                $items[$i]['items']=$this->normalizeItems($item['items'],$route,$hasActiveChild);
                if(empty($items[$i]['items']))
                    unset($items[$i]['items']);
            }
            if(!isset($item['active']))
            {
                if($hasActiveChild || $this->isItemActive($item,$route))
                    $active=$items[$i]['active']=true;
                else
                    $items[$i]['active']=false;
            }
            else if($item['active'])
                $active=true;
        }
        return array_values($items);
    }

    protected function isItemActive($item,$route)
    {
        if(isset($item['url']) && is_array($item['url']) && !strcasecmp(trim($item['url'][0],'/'),$route))
        {
            if(count($item['url'])>1)
            {
                foreach(array_splice($item['url'],1) as $name=>$value)
                {
                    if(!isset($_GET[$name]) || $_GET[$name]!=$value)
                        return false;
                }
            }
            return true;
        }
        return false;
    }
}
