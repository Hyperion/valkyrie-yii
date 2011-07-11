<h1>Characters</h1>

<?php
$this->widget('zii.widgets.CListView', array(
        'id' => 'characters-list',
        'dataProvider' => $dataProvider,
        'itemView'=>'_viewChars',
)); ?>
