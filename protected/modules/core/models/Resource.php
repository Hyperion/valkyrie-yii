<?php

class Resource extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Resource the static model class
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
		return 'resource';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource' => 'Resource',
			'version' => 'Version',
			'description' => 'Description',
		);
	}
	
	public function getModuleList()
	{
		$configFileList = glob(YiiBase::getPathOfAlias('application.modules').'/*/config/*.xml');
        $installedFileModules = array();
		
        foreach($configFileList as $singleConfigFile)
		{
            $config = new SimpleXMLElement($singleConfigFile, NULL, true);
            $installedFileModules[(string)$config->name] = array(
				'resource' 		 => (string)$config->name,
				'description' 	 => (string)$config->description,
				'need_install'   => 1,
				'need_uninstall' => 0,
			);
        }
		
		$installedDbModules = array();
        $records = $this->findAll();
        foreach($records as $recordItem)
		{
            $installedDbModules[$recordItem->resource] = array(
				'resource' 		 => $recordItem->resource,
				'description'    => $recordItem->description,
				'need_install'   => 0,
				'need_uninstall' => 0,
			);
        }
		
		$moduleList = array();
		
        foreach($installedFileModules as $module)
		{
            if(isset($installedDbModules[$module['resource']]))
			{
                $module['need_install'] = 0;
            }
            $moduleList[] = $module;
        }
		
		foreach($installedDbModules as $module)
		{
            if(!isset($installedFileModules[$module['resource']]))
			{
                $module['need_uninstall'] = 1;
				$moduleList[] = $module;
            }
        }
		return $moduleList;
	}
	
	public function refreshModuleList($moduleList)
	{
		$string = "<?php\n return array(\n 'modules' => array(";
        foreach ($moduleList as $module) {
            if ($module['need_install'] == 0 && $module['need_uninstall'] == 0) {
                $string.="'".$module['resource']."',";
            }
        }
        $string.=")\n);";

		file_put_contents(YiiBase::getPathOfAlias('application.config.modules').'.php', $string); 
	}
	
	public function install($resourceName)
	{
		$configFile = YiiBase::getPathOfAlias('application.modules.'.$resourceName.'.config.'.$resourceName).'.xml';
		$config = new SimpleXMLElement($configFile, NULL, true);
		$this->resource    = (string)$config->name;
		$this->version     = (string)$config->version;
		$this->description = (string)$config->description;
 
        return $this->save();
	}
}