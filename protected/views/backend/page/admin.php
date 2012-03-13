<?php
$this->breadcrumbs = array(
    'Страницы' => array('admin'),
    'Управление',
);
?>
<div class="alert alert-block alert-success" style="display: none"></div>

<h1>Управление страницами</h1>

<p>
    В качестве фильтров в поиске можно использовать специальные символы(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    или <b>=</b>).
</p>

<?php
echo CHtml::link('<i class="icon-white icon-plus"></i> Добавить страницу', array('create'), array(
    'class'                    => 'ajax-dialog-create btn-primary btn',
    'data-ajax-dialog-title' => Yii::t('app', 'Create a new page'),
));
?>

<?php
$this->widget('BootGridView', array(
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        'title',
        'url',
        array(
            'class'   => 'CButtonColumn',
            'buttons' => array(
                'delete' => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Delete confirmation'),
                    ),
                ),
                'update'                   => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Update page'),
                    ),
                ),
                'view'                     => array(
                    'click'   => 'ajaxDialogOpen',
                    'options' => array(
                        'data-ajax-dialog-title' => Yii::t('app', 'Preview page'),
                    ),
                )
            ),
        ),
    ),
));
?>

<?php
$this->ajaxOptions['renderCallback'] = "js:function(data){
    $.cleditor.buttons.image.uploadUrl = '" . Yii::app()->request->baseUrl . "/index.php/page/handleUpload';
    setTimeout(function() {\$('#Page_text').cleditor({'width':'95%','height':250});},250);
    }";
$this->ajaxLinks[] = '.ajax-dialog-create';
?>
