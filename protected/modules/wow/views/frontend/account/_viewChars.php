<div class="view">
    <b>Имя:</b>
    <?=CHtml::link($model->name, array(
        '/wow/character/simple',
        'realm'=>$model->realm,
        'name'=>$model->name
    ))?>
    <br />
</div>
