<h1>Account Banned</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'characters-list',
    'dataProvider' => $accountBanned->search(),
    'itemView'=>'_view',
)); ?>

<h1>Ip Banned</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'id' => 'characters-list',
    'dataProvider' => $ipBanned->search(),
    'itemView'=>'_view',
)); ?>