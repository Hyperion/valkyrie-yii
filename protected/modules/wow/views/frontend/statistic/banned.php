<h1>Account Banned</h1>

<?php $this->widget('BootGridView', array(
    'id' => 'account-banned',
    'dataProvider' => $accountBanned->search(),
    'columns'=>array(
        array(
            'name'=>'Account',
            'value'=>'$data->account->username',
            'visible'=>Yii::app()->user->checkAccess('admin'),
        ),
        array(
            'class' =>'CCharsColumn',
            'name'=>'Characters',
            'value'=>'$data->characters',
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

<?php $this->widget('BootGridView', array(
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
