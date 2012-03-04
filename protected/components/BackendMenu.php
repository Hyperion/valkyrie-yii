<?php

class BackendMenu
{
    public static function refreshXmlMenu()
    {
        $menu = array();

        $configFileList = glob(YiiBase::getPathOfAlias('application.modules').'/*/config/*.xml');
        $configFileList = array_merge($configFileList, glob(YiiBase::getPathOfAlias('application.config').'/*.xml'));
        foreach ($configFileList as $configFile)
        {
            $config    = new SimpleXMLElement($configFile, NULL, true);
            $nodes     = $config->xpath('/config/backendmenu');
            $module    = Yii::app()->getModule((string) $config->name);
            $menuItems = self::parseXmlMenu($nodes, $module);
            $menu      = CMap::mergeArray($menu, $menuItems);
        }

        self::sortMenuItems($menu);

        foreach ($menu as $i => $v)
            $menu[$i]['linkOptions'] = array('class' => 'nav-top-item');

        Yii::app()->cache->set('backendmenu', $menu);
    }

    private static function parseXmlMenu($nodeElements, $module)
    {
        $menu = array();
        foreach ($nodeElements as $element)
        {
            $item = array();
            if ($element->label)
                if (method_exists($module, 't'))
                    $item['label']      = $module::t((string) $element->label);
                else
                    $item['label']      = (string) $element->label;
            if ($element->sort_order)
                $item['sort_order'] = (int) $element->sort_order;
            if ($element->url)
                $item['url']        = array((string) $element->url);
            if ($element->id)
                $item['id']    = (int) $element->id;
            if ($element->items)
                $item['items'] = self::parseXmlMenu($element->xpath("items/*"), $module);

            $menu[] = $item;
        }
        return $menu;
    }

    private static function sortMenuItems(&$menuItems)
    {
        uasort($menuItems, "BackendMenu::sortBySortOrder");
        foreach ($menuItems as $key => $item)
        {
            if (isset($item['items']))
                self::sortMenuItems($menuItems[$key]['items']);
        }
    }

    public static function sortBySortOrder($a, $b)
    {
        if ($a['sort_order'] == $b['sort_order'])
            return 0;
        return ($a['sort_order'] > $b['sort_order']) ? 1 : -1;
    }

}