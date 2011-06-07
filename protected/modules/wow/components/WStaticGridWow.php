<?php

Yii::import('zii.widgets.grid.CDataColumn');

class WStaticGridWow extends CWidget
{

    private $_formatter;

    public $dataProvider;
    public $pageEnd = 50;
    public $columns=array();
    public $rowCssClass=array('row1','row2');
    public $template;
    public $htmlOptions = array();
    public $summaryText;
    
    public function init()
    {
        $this->template = '<div class="table-options-top">{summary}</div>{items}<div class="table-options-bottom">{summary}</div>';
        $this->summaryText = 'Результаты <strong class="results-start">{start}</strong>-<strong class="results-end">{end}</strong> из <strong class="results-total">{count}</strong>';

        if($this->dataProvider===null)
            throw new CException(Yii::t('zii','The "dataProvider" property cannot be empty.'));

        $this->dataProvider->getData();

        $this->htmlOptions['id']=$this->getId();
        
        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='grid-view';
            
        $this->initColumns();

    }
    
    protected function initColumns()
    {
        if($this->columns===array())
        {
            // use the keys of the first row of data as the default columns
            $data=$this->dataProvider->getData();
            if(isset($data[0]) && is_array($data[0]))
                $this->columns=array_keys($data[0]);

        }
        $id=$this->getId();
        foreach($this->columns as $i=>$column)
        {
            if(is_string($column))
                $column=$this->createDataColumn($column);
            else
            {
                if(!isset($column['class']))
                    $column['class']='CDataColumn';
                $column=Yii::createComponent($column, $this);
            }
            if(!$column->visible)
            {
                unset($this->columns[$i]);
                continue;
            }
            if($column->id===null)
                $column->id=$id.'_c'.$i;
            $this->columns[$i]=$column;
        }

        foreach($this->columns as $column)
            $column->init();
    }
    
    protected function createDataColumn($text)
    {
        if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$text,$matches))
            throw new CException(Yii::t('zii','The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
        $column=new CDataColumn($this);
        $column->name=$matches[1];
        if(isset($matches[3]) && $matches[3]!=='')
            $column->type=$matches[3];
        if(isset($matches[5]))
            $column->header=$matches[5];
        return $column;
    }

    public function run()
    {
        $this->renderContent();
    }
    
    public function renderContent()
    {
        ob_start();
        echo preg_replace_callback("/{(\w+)}/",array($this,'renderSection'),$this->template);
        ob_end_flush();
    }
    
    protected function renderSection($matches)
    {
        $method='render'.$matches[1];
        if(method_exists($this,$method))
        {
            $this->$method();
            $html=ob_get_contents();
            ob_clean();
            return $html;
        }
        else
            return $matches[0];
    }
    
    public function renderEmptyText()
    {
        $emptyText=$this->emptyText===null ? Yii::t('zii','No results found.') : $this->emptyText;
        echo CHtml::tag('span', array('class'=>'empty'), $emptyText);
    }
    
    public function renderSummary()
    {
        if(($count=$this->dataProvider->getItemCount())<=0)
            return;

        $end = ($count < $this->pageEnd) ? $count :  $this->pageEnd;
	echo '<div class="table-options"><div class="option"><ul class="ui-pagination"></ul></div>';
        if(($summaryText=$this->summaryText)===null)
            $summaryText=Yii::t('zii','Total {count} result(s).');
        echo strtr($summaryText,array(
            '{count}'=>$count,
            '{start}'=>1,
            '{end}'=>$end,
            '{page}'=>1,
            '{pages}'=>1,
        ));
        echo '</div><span class="clear"><!-- --></span>';
    }

    public function renderItems()
    {
        if($this->dataProvider->getItemCount()>0 || $this->showTableOnEmpty)
        {
            echo "<div class=\"table full-width\"><table>\n";
            $this->renderTableHeader();
            $this->renderTableBody();
            echo "</table></div>";
        }
        else
            $this->renderEmptyText();
    }
    
    public function renderTableHeader()
    {
        echo "<thead>\n";

        echo "<tr>\n";
        foreach($this->columns as $column)
        {
            $column->headerHtmlOptions['id']=$column->id;
            echo CHtml::openTag('th',$column->headerHtmlOptions);
            
            $label = CHtml::encode($column->name);
            echo '<a href="javascript:;" class="sort-link"><span class = "arrow">'.$label.'</span></a>';
            echo '</th>';
        }
        echo "</tr>\n";
        echo "</thead>\n";
    }
    
   
    public function renderTableBody()
    {
        $data=$this->dataProvider->getData();
        $n=count($data);
        echo "<tbody>\n";

        if($n>0)
        {
            for($row=0;$row<$n;++$row)
                $this->renderTableRow($row);
        }
        else
        {
            echo '<tr><td colspan="'.count($this->columns).'">';
            $this->renderEmptyText();
            echo "</td></tr>\n";
        }
        echo "</tbody>\n";
    }

    public function renderTableRow($row)
    {
        if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
            echo '<tr class="'.$this->rowCssClass[$row%$n].'">';
        else
            echo '<tr>';
        foreach($this->columns as $column)
            $column->renderDataCell($row);
        echo "</tr>\n";
    }

    public function getHasFooter()
    {
        foreach($this->columns as $column)
            if($column->getHasFooter())
                return true;
        return false;
    }

    public function getFormatter()
    {
        if($this->_formatter===null)
            $this->_formatter=Yii::app()->format;
        return $this->_formatter;
    }

    public function setFormatter($value)
    {
        $this->_formatter=$value;
    }
}