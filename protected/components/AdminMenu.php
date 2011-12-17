<?php

/**
 * Description of AdminMenu
 *
 * @author gabriel
 */

class AdminMenu
{
    static function getData()
    {
        $data = Yii::app()->cache->get('backendmenu');

        if(!$data)
        {
            self::refreshXmlMenu();
            $data = Yii::app()->cache->get('backendmenu');
        }

        return $data;
    }
    
    
    private static function refreshXmlMenu()
    {
        $menu = array();

        $configFileList = glob(YiiBase::getPathOfAlias('application.modules').'/*/config/*.xml');
        foreach ($configFileList as $configFile)
        {
            $config = new SimpleXMLElement($configFile, NULL, true);
            $nodes = $config->xpath('/config/backendmenu/*');

            $menuItems = self::parseXmlMenu($nodes);
            $menu = CMap::mergeArray($menu, $menuItems);

        }

        self::sortMenuItems($menu);

        foreach($menu as $i=>$v)
            $menu[$i]['linkOptions'] = array('class' => 'nav-top-item');

        Yii::app()->cache->set('backendmenu', $menu);
    }
    
    private static function parseXmlMenu($nodeElements)
    {
        $menu = array();
        foreach($nodeElements as $element)
        {
            $item = array();
            if($element->label)
                $item['label'] = $element->label."";
            if($element->sort_order)
                $item['sort_order'] = $element->sort_order."";
            if($element->url)
                $item['url'] = array($element->url."");
            if($element->id)
                $item['id'] = $element->id."";
            if($element->items)
                $item['items'] = self::parseXmlMenu($element->xpath("items/*"));

            $menu[] = $item;
        }
        return $menu;
    }

    private static function sortMenuItems(&$menuItems)
    {
        uasort($menuItems, "AdminMenu::sortBySortOrder");
        foreach($menuItems as $key => $item)
        {
            if(isset($item['items']))
                self::sortMenuItems($menuItems[$key]['items']);
        }
    }
    
    public static function sortBySortOrder($a, $b)
    {
        if ($a['sort_order'] == $b['sort_order']) return 0;
        return ($a['sort_order'] > $b['sort_order']) ? 1 : -1;
    }
}