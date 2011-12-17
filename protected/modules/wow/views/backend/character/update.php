<script type="text/javascript">
    /*<![CDATA[*/
    updateForm = function(id){
        var settings = $.fn.yiiGridView.settings[id];
        var values = [];
        $('#'+id+' .'+settings.tableClass+' > tbody > tr.selected > td').each(function(i){
            values.push($(this).text());
        });
        $('#Character_race').val(values[1]);
        $('#Character_gender').val(values[2]);
        $('#Character_playerBytes').val(values[3]);
        $('#Character_playerBytes2').val(values[4]);
    };
    /*]]>*/
</script>
<?php
$this->breadcrumbs = array(
    'Characters' => array('index'),
    $model->name => array('view', 'id' => $model->guid),
    'Update',
);
?>

<h1>Update Character <?php echo $model->name; ?></h1>
<div class="bloc">
    <div class="title"><?php echo $model->name; ?></div>
    <div class="content">
        <?php echo $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>

<div class="bloc">
    <div class="title">Персонажи</div>
    <div class="content">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'characters-grid',
            'pagerCssClass' => 'pagination',
            'pager' => array(
                'class' => 'CLinkPager',
                'cssFile' => false,
                'firstPageLabel' => '<<',
                'lastPageLabel' => '>>',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'header' => false,
            ),
            'cssFile' => false,
            'dataProvider' => $filter->search(true),
            'filter' => $filter,
            'columns' => array(
                'name',
                array('name' => 'race', 'value' => '$data->race', 'filter' => false),
                array('name' => 'gender', 'value' => '$data->gender', 'filter' => false),
                array('name' => 'playerBytes', 'value' => '$data->playerBytes', 'filter' => false),
                array('name' => 'playerBytes2', 'value' => '$data->playerBytes2', 'filter' => false),
            ),
            'selectionChanged' => 'updateForm',
        ));
        ?>
    </div>
</div>
