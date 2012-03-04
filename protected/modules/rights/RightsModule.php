<?php

/**
 * Rights module class file.
 *
 * @author Christoffer Niska <cniska@live.com>
 * @copyright Copyright &copy; 2010 Christoffer Niska
 * @version 1.3.0
 * 
 * DO NOT CHANGE THE DEFAULT CONFIGURATION VALUES!
 * 
 * You may overload the module configuration values in your rights-module 
 * configuration like so:
 * 
 * 'modules'=>array(
 *     'rights'=>array(
 *         'userNameColumn'=>'name',
 *         'flashSuccessKey'=>'success',
 *         'flashErrorKey'=>'error',
 *     ),
 * ),
 */
class RightsModule extends CWebModule
{

    public $superuserName      = 'Admin';
    public $userClass          = 'User';
    public $userIdColumn       = 'id';
    public $userNameColumn     = 'username';
    public $enableBizRule      = true;
    public $enableBizRuleData  = false;
    public $displayDescription = true;
    public $flashSuccessKey    = 'success';
    public $flashErrorKey      = 'error';
    public $baseUrl            = '/rights';
    public $layout             = '/layouts/main';
    public $appLayout          = '//layouts/backend';
    public $cssFile;
    public $debug              = false;
    private $_assetsUrl;

    /**
     * Initializes the "rights" module.
     */
    public function init()
    {
        // Set required classes for import.
        $this->setImport(array(
            'rights.components.*',
            'rights.components.behaviors.*',
            'rights.components.dataproviders.*',
            'rights.controllers.*',
            'rights.models.*',
        ));

        // Set the required components.
        $this->setComponents(array(
            'authorizer' => array(
                'class'         => 'RAuthorizer',
                'superuserName' => $this->superuserName,
            ),
            'generator'     => array(
                'class' => 'RGenerator',
            ),
        ));

        // Normally the default controller is Assignment.
        $this->defaultController = 'assignment';

        Yii::app()->onModuleCreate(new CEvent($this));
    }

    /**
     * Registers the necessary scripts.
     */
    public function registerScripts()
    {
        // Get the url to the module assets
        $assetsUrl = $this->getAssetsUrl();

        // Register the necessary scripts
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile($assetsUrl.'/js/rights.js');
    }

    /**
     * Publishes the module assets path.
     * @return string the base URL that contains all published asset files of Rights.
     */
    public function getAssetsUrl()
    {
        if ($this->_assetsUrl === null)
        {
            $assetsPath = Yii::getPathOfAlias('rights.assets');

            // We need to republish the assets if debug mode is enabled.
            if ($this->debug === true)
                $this->_assetsUrl = Yii::app()->getAssetManager()->publish($assetsPath, false, -1, true);
            else
                $this->_assetsUrl = Yii::app()->getAssetManager()->publish($assetsPath);
        }

        return $this->_assetsUrl;
    }

    /**
     * @return RightsAuthorizer the authorizer component.
     */
    public function getAuthorizer()
    {
        return $this->getComponent('authorizer');
    }

    /**
     * @return RightsGenerator the generator component.
     */
    public function getGenerator()
    {
        return $this->getComponent('generator');
    }

    /**
     * @return the current version.
     */
    public function getVersion()
    {
        return '1.3.0';
    }

    public static function t($str = '', $params = array(), $dic = 'core')
    {
        return Yii::t("RightsModule.".$dic, $str, $params);
    }

}
