<?php

class TreeMenu extends CWidget
{

    public $visible = true;

    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }

    protected function treeList($id = 0, $table, &$cnt = 0)
    {
        $objects = '';
        $child   = '';
        $act     = '';
        $data    = null;
        switch($table)
        {
            case "pages":
                {
                    $objects = Page::model()->findAll();
                    $act     = 'view';
                    break;
                }
        }
        if($objects)
        {
            $data = array();
            foreach($objects as $object)
            {
                $cnt++;
                $param = array('url' => $object->url);
                $tmp_ = (($child) ? $this->treeList($object['id'], $table, $cnt) : null);
                if($child)
                {
                    $tmp    = $this->treeList($object['id'], $child, $cnt);
                    $tmp_   = array_merge((array) $tmp_, (array) $tmp);
                }
                if($table == 'pages')
                    $link   = "http://{$_SERVER['SERVER_NAME']}/{$object->url}.html";
                else
                    $link   = Yii::app()->createUrl((($child) ? $child : $table) . '/' . $act, $param);
                $data[] = array(
                    "text" => CHtml::link($object->title, "#", array(
                        "onClick" => 'changeURL("' . $link . '","' . $object->title . '","' . $object->alt . '"); $("#mydialog").dialog("close"); return false;',
                        "title"   => $object->alt,
                        "alt"     => $object->alt
                            )
                    )
                    . ' | '
                    . CHtml::link("Просмотр", $link, array("target"      => "blank_")),
                    "id"          => $cnt,
                    'htmlOptions' => array(
                        'class'    => 'treeview-gray',
                    ),
                    "children" => $tmp_,
                );
            }
        }
        return $data;
    }

    protected function renderContent()
    {

        $data = array();
        $cnt    = 0;
        $data[] = array(
            "text"        =>
            '<a onClick="changeURL(\'http://'.$_SERVER['SERVER_NAME'].'/\'); return false;" alt="Главная" title="Главная">Главная</a>',
            "id"          => $cnt,
            'htmlOptions' => array(
                'class'    => 'treeview-gray',
                'style'    => 'min-width:450px',
            ),
            "children" => "",
        );

        $data[] = array(
            "text"        =>
            'Статичные страницы',
            "id"          => $cnt,
            'htmlOptions' => array(
                'class'    => 'treeview-gray',
            ),
            "children" => $this->treeList(0, "pages", $cnt),
        );
        $data[]    = array(
            "text"        =>
            '<a onClick="changeURL(\'http://'.$_SERVER['SERVER_NAME'].'/site/contact\'); return false;" href="#" alt="Контакты" title="Контакты">Контакты</a>',
            "id"          => $cnt + 1,
            'htmlOptions' => array(
                'class'    => 'treeview-gray',
            ),
            "children" => '',
        );
        $this->render('treeMenu', array('tree_data' => $data));
    }

}