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
            if($menu == 'backendmenu')
                $this->refreshXmlMenu('backendmenu');
            elseif($menu == 'usermenu')
                $this->refreshXmlMenu('usermenu');
            else
                Yii::app()->cache->set("menu_$menu", $this->toArray($menu));

            $data = Yii::app()->cache->get("menu_$menu");
        }

        return $data;
    }

    private function toArray($menu = 'mainmenu')
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
        Yii::app()->cache->set("menu_{$this->menu}", $this->toArray($this->menu));
    }

    protected function afterSave()
    {
        parent::afterSave();
        Yii::app()->cache->set("menu_{$this->menu}", $this->toArray($this->menu));
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        Yii::app()->cache->set("menu_{$this->menu}", $this->toArray($this->menu));
    }

    public function refreshXmlMenu($type = 'backendmenu')
    {
        $totalBackendMenuArray = array();

        $configFileList = glob(YiiBase::getPathOfAlias('application.modules').'/*/config/*.xml');
        foreach ($configFileList as $singleConfigFile)
        {
            $config = new SimpleXMLElement($singleConfigFile, NULL, true);
            switch($type)
            {
                case 'backendmenu':
                    $nodes = $config->xpath('/config/adminhtml/menu/*');
                    break;
                case 'usermenu':
                    $nodes = $config->xpath('/config/cphtml/menu/*');
                    break;
                default:
                    return;
                    break;
            }


            $menuItemsForModule = $this->parsingXmlMenu($nodes);
            $totalBackendMenuArray = CMap::mergeArray($totalBackendMenuArray, $menuItemsForModule);

        }
        $this->sortingMenuItems($totalBackendMenuArray);
        $outputMenu = $this->convertXmlMenuFormatToOutputFormat($totalBackendMenuArray);

        if($type == 'backendmenu')
            for($i = 0; $i < count($outputMenu); $i++)
                $outputMenu[$i]['linkOptions'] = array('class' => 'nav-top-item');

        Yii::app()->cache->set("menu_$type", $outputMenu);
    }

    protected function convertXmlMenuFormatToOutputFormat($xmlMenuFormat)
    {
        $outputMenu = array();
        foreach($xmlMenuFormat as $single)
        {
            $menuItem = array();
            $menuItem['label'] = $single['label'];
            if(isset($single['url']))
                $menuItem['url'] = array($single['url']);

            if(isset($single['items']))
                $menuItem['items'] = $this->convertXmlMenuFormatToOutputFormat($single['items']);
            $outputMenu[] = $menuItem;
        }
        return $outputMenu;
    }

    protected function parsingXmlMenu($nodeElements)
    {
        $returnArray = array();
        foreach($nodeElements as $element)
        {

            $nodeName = $element->getName();
            $returnArray[$nodeName] = array();
            if($element->label)
                $returnArray[$nodeName]['label'] = $element->label."";
            if($element->sort_order)
                $returnArray[$nodeName]['sort_order'] = $element->sort_order."";
            if($element->url)
                $returnArray[$nodeName]['url'] = $element->url."";
            if($element->items)
                $returnArray[$nodeName]['items'] = $this->parsingXmlMenu($element->xpath("items/*"));
        }
        return $returnArray;
    }

    protected function sortingMenuItems(&$menuItems)
    {
        uasort($menuItems, "Menu::sortingByKeySortOrder");
        foreach($menuItems as $key => $item)
        {
            if(isset($item['items']))
                $this->sortingMenuItems($menuItems[$key]['items']);
        }
    }

    public static function sortingByKeySortOrder($a, $b)
    {
        if ($a['sort_order'] == $b['sort_order']) return 0;
        return ($a['sort_order'] > $b['sort_order']) ? 1 : -1;
    }
}
