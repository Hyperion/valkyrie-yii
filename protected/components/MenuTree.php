<?php

class MenuTree
{

    public static function getItems($r_level = 2)
    {
        $nodes = Menu::model()->findAll(array('order' => 'lft'));
        $level  = 1;
        $path   = array();

        foreach($nodes as $f)
        {
            if($f->level > $level)
            {
                if($f->level != $level + 1 || !count($path[$level]))
                    throw new CHttpException(404, 'Netsed set error.');

                $path[$f->level]   = &$path[$level][count($path[$level]) - 1]['items'];
            }
            $path[$f->level][] = array(
                'label' => $f->title,
                'url'   => $f->url,
                'linkOptions' => array('alt' => $f->alt),
                //'items' => array()
            );
            $level = $f->level;
        }

        return $path[$r_level];
    }

}
