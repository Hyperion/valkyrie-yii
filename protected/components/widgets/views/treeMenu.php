<?php
$this->widget('CTreeView',array(
    'id'=>'menu-treeview',
    'data'=>$tree_data ,
    'control'=>'#treecontrol',
    'animated'=>'fast',
    'collapsed'=>true,
    'htmlOptions'=>array(
        'class'=>'filetree'
    )
));
?>
