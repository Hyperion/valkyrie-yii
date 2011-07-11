<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id
 * @property string $label
 * @property string $url
 * @property integer $position
 * @property string $menu
 */
class Menu extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Menu the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('label, url, position, menu', 'required'),
            array('position', 'numerical', 'integerOnly'=>true),
            array('label, url, menu', 'length', 'max'=>50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, label, url, position, menu', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'label' => 'Label',
            'url' => 'Url',
            'position' => 'Position',
            'menu' => 'Menu',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('label',$this->label,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('position',$this->position);
        $criteria->compare('menu',$this->menu,true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        ));
    }

    public function getData($menu = 'mainmenu')
    {
        $data = Yii::app()->cache->get("menu_$menu");

        if(!$data)
        {
            if($menu == 'backendmenu' || $menu == 'usermenu')
                self::refreshXmlMenu($menu);
            else
                Yii::app()->cache->set("menu_$menu", self::toArray($menu));

            $data = Yii::app()->cache->get("menu_$menu");
        }

        return $data;
    }

    private static function toArray($menu = 'mainmenu')
    {
        $menu = $this::model()->findAll(array(
            'order'=>'position',
            'condition'=>'menu=:menu',
            'params'=>array(':menu'=>$menu)
        ));
        $data = array();
        foreach($menu as $item)
        {
            $data[] = array(
              'label' => $item->label,
              'url'   => array($item->url)
            );
        }
        return $data;
    }

    protected function afterCreate()
    {
        parent::afterCreate();
        Yii::app()->cache->set("menu_{$this->menu}", self::toArray($this->menu));
    }

    protected function afterSave()
    {
        parent::afterSave();
        Yii::app()->cache->set("menu_{$this->menu}", self::toArray($this->menu));
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        Yii::app()->cache->set("menu_{$this->menu}", self::toArray($this->menu));
    }

    public static function refreshXmlMenu($type = 'backendmenu')
    {
        $menu = array();

        $configFileList = glob(YiiBase::getPathOfAlias('application.modules').'/*/config/*.xml');
        foreach ($configFileList as $configFile)
        {
            $config = new SimpleXMLElement($configFile, NULL, true);
            switch($type)
            {
                case 'backendmenu':
                case 'usermenu':
                    $nodes = $config->xpath("/config/$type/*");
                    break;
                default:
                    return;
                    break;
            }

            $menuItems = self::parseXmlMenu($nodes);
            $menu = CMap::mergeArray($menu, $menuItems);

        }

        self::sortMenuItems($menu);

        if($type == 'backendmenu')
            foreach($menu as $i=>$v)
                $menu[$i]['linkOptions'] = array('class' => 'nav-top-item');

        Yii::app()->cache->set("menu_$type", $menu);
    }

    protected static function parseXmlMenu($nodeElements)
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

    protected static function sortMenuItems(&$menuItems)
    {
        uasort($menuItems, "Menu::sortBySortOrder");
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
