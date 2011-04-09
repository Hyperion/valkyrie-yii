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

    public function refreshCache($menu = 'mainmenu')
    {
        $fh = fopen(YiiBase::getPathOfAlias('application.cache')."/".$menu.".ser", "w");
        fwrite($fh, serialize($this->toArray($menu)));
        fclose($fh);
    }
    
    public function getData($menu = 'mainmenu')
    {
        $fname = YiiBase::getPathOfAlias('application.cache')."/".$menu.".ser";
        if (!file_exists($fname)) {
            $fh = fopen($fname, "w");
            fwrite($fh, serialize($this->toArray($menu)));
            fclose($fh);
        }
        // Read file content and return array of menu
        $fh = fopen($fname, "r");
        $outputMenu = fread($fh, filesize($fname));
        $outputMenu = unserialize($outputMenu);
        fclose($fh);

        return $outputMenu;
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
        $this->refreshCache($this->menu);
    }

    protected function afterSave()
    {
        parent::afterSave();
        $this->refreshCache($this->menu);
    }

    protected function afterDelete()
    {
        parent::afterDelete();
        $this->refreshCache($this->menu);
    }
}