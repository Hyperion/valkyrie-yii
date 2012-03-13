<?php
$this->breadcrumbs = array(
    'Жалобы' => array('admin'),
    'Управление',
);
?>
<div class="alert alert-block alert-success" style="display: none"></div>

<h1>Управление жалобами</h1>

<p>
    В качестве фильтров в поиске можно использовать специальные символы(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    или <b>=</b>).
</p>
<p>
    Для изменения статуса кликните по значению в таблице.
</p>

<?php
$this->widget('BootGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'filter'      => false,
            'htmlOptions' => array('width' => 50),
        ),
        'report_text',
        array(
            'name'   => 'status',
            'value'  => 'CHtml::link($data->statusText, "#", array("class" => "editable", "id" => $data->id, "onClick" => "updateRow()"));',
            'type'   => 'raw',
            'filter' => array('Не проверено', 'Проверено'),
        //TODO: create editable column
        ),
        array(
            'name'  => 'username',
            'value' => 'CHtml::link($data->user->username, array("/user/user/view", "id"   => $data->user_id))',
            'type'  => 'raw',
        ),
        array(
            'name'   => 'url',
            'value'  => 'CHtml::link("Ссылка", $data->url)',
            'filter' => false,
            'type'   => 'raw',
        ),
        array(
            'class'    => 'CButtonColumn',
            'template' => '{delete}',
            'buttons'  => array(
                'delete' => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Delete confirmation'),
                    ),
                ),
            ),
        ),
    ),
));
?>

<script type="text/javascript">
    function updateRow() {
        $('.editable').editable('<?php echo $this->createUrl('/report/update'); ?>', {
            data   : "{'0':'Не проверено','1':'Проверено'}",
            type   : 'select',
            submit : 'OK',
            name   : 'status'
        });
    }
</script>