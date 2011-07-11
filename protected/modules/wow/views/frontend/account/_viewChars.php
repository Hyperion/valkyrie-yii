<div class="view">
    <b>Name:</b>
    <?=CHtml::link($data->name, array(
        '/wow/character/simple',
        'realm'=>$data->realm,
        'name'=>$data->name
    ))?>
    <br />
</div>
