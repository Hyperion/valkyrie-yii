<h1>Account Banned</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'account-banned',
    'dataProvider' => $accountBanned->search(),
    'columns'=>array(
        array(
            'name'=>'Username',
            'value'=>'$data->account->username',
        ),
        array(
            'name'=>'bandate',
            'value'=>'Yii::app()->dateFormatter->formatDateTime($data->bandate, "long", "short")',
        ),
        array(
            'name'=>'unbandate',
            'value'=>
                '($data->bandate >= $data->unbandate) ? "Permanent" : Yii::app()->dateFormatter->formatDateTime($data->unbandate, "long", "short")',
        ),
        'bannedby',
        'banreason',
    ),
)); ?>

<h1>Ip Banned</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'ip-banned',
    'dataProvider' => $ipBanned->search(),
    'columns'=>array(
        'ip',
        array(
            'name'=>'bandate',
            'value'=>'Yii::app()->dateFormatter->formatDateTime($data->bandate, "long", "short")',
        ),
        array(
            'name'=>'unbandate',
            'value'=>
                '($data->bandate >= $data->unbandate) ? "Permanent" : Yii::app()->dateFormatter->formatDateTime($data->unbandate, "long", "short")',
        ),
        'bannedby',
        'banreason',
    ),
)); ?>