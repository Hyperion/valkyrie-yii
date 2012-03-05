<?php

class WGridWow extends BootGridView
{
    public function init()
    {
    	$this->template = '<div class="table-options">{pager}{summary}<span class="clear"><!-- --></span></div><div class="table full-width">{items}</div><div class="table-options">{pager}{summary}<span class="clear"><!-- --></span></div>';
    	$this->summaryText = 'Результаты <strong class="results-start">{start}</strong>-<strong class="results-end">{end}</strong> из <strong class="results-total">{count}</strong>';
        parent::init();
    }
    public function renderTableHeader()
    {
        if(!$this->hideHeader)
        {
            echo "<thead>\n";

            if($this->filterPosition===self::FILTER_POS_HEADER)
               $this->renderFilter();

            echo "<tr>\n";
            foreach($this->columns as $column)
            {
                $column->headerHtmlOptions['id']=$column->id;
    		echo CHtml::openTag('th',$column->headerHtmlOptions);
    		
    		if($this->enableSorting && $column->sortable && $column->name!==null)
    		{
    		    $label = ($column->header) ? $column->header : CHtml::encode($this->dataProvider->model->getAttributeLabel($column->name));
        	    echo $this->dataProvider->getSort()->link(
        	    	$column->name,
        	    	"<span class = \"arrow\">{$label}</span>",
        	    	array('class' => 'sort-link',)
        	    );
        	}
    		else if($column->name!==null && $column->header===null)
    		{
    		    echo '<span class="sort-tab">';
        	    if($this->dataProvider instanceof CActiveDataProvider)
            	        echo CHtml::encode($this->dataProvider->model->getAttributeLabel($column->name));
        	    else
            	        echo CHtml::encode($this->name);
            	    echo '</span>';
    		}
                else
                {
                    echo '<span class="sort-tab">';
                    echo trim($column->header)!=='' ? $column->header : $this->blankDisplay;
                    echo '</span>';
                }
    		
    		echo '</th>';
            }
            echo "</tr>\n";

            if($this->filterPosition===self::FILTER_POS_BODY)
                $this->renderFilter();

            echo "</thead>\n";
        }
        else if($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
        {
            echo "<thead>\n";
            $this->renderFilter();
            echo "</thead>\n";
        }
    }
}