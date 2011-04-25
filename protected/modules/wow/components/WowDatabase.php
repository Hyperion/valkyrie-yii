<?php

class WowDatabase extends CComponent
{
    static public $name;
    static public $db = false;
    static public $realmlist = false;
    
    static private $_key = false;
    static private $_realmInfo = false;
    static private $_aes = false;
    
    public function __construct()
    {
        if(!self::$_aes)
        {
            YiiBase::import('application.extensions.AES128');
            self::$_aes = new AES128();
            self::$_key = self::$_aes->makeKey('cherepica');
        }
    }
    
    public function setRealmInfo($realmData)
    {
        $realmInfo = CMap::mergeArray($realmData, $this->realmInfo);
        
        foreach($realmInfo as $k => $v)
            $realmInfo[$k]['password'] = self::$_aes->blockEncrypt($v['password'], self::$_key);
        
        $fname = YiiBase::getPathOfAlias('application.runtime.wow.realminfo').'.php';
        
        $string = "<?php\n return '".serialize($realmInfo)."';";

        $fh = fopen($fname, "w");
        fwrite($fh, $string);
		fclose($fh);
        
        self::$_realmInfo = false;
        
        return $this;
    }
    
    public function getRealmInfo()
    {
        if(is_array(self::$_realmInfo))
            return self::$_realmInfo;
            
        $fname = YiiBase::getPathOfAlias('application.runtime.wow.realminfo').'.php';
        
        if(!file_exists($fname))
        {
            $string = "<?php\n return '".serialize(array())."';";

            $fh = fopen($fname, "w");
			fwrite($fh, $string);
			fclose($fh);
        }
        
        self::$_realmInfo = unserialize(require($fname));
        
        foreach(self::$_realmInfo as $k => $v)
            self::$_realmInfo[$k]['password'] = self::$_aes->blockDecrypt($v['password'], self::$_key);
        
        return self::$_realmInfo;
    }
    
    public function getDb($name = null)
    {
        if((self::$db instanceof CDbConnection) and $name != 'realmlist')
            return self::$db;
        if((self::$realmlist instanceof CDbConnection) and $name == 'realmlist')
            return self::$realmlist;
            
        $name = ($name != null)? $name : self::$name;
        
        $dsn = 'mysql:host='.$this->realmInfo[$name]['host'].';dbname='.$this->realmInfo[$name]['database'];
        $username = $this->realmInfo[$name]['username'];
        $password = $this->realmInfo[$name]['password'];
        
        $db = new CDbConnection($dsn, $username, $password);
        $db->active = true;
        $db->charset = 'utf8';
        
        if($name == 'realmlist')
            self::$realmlist = $db;
        else
            self::$db = $db;
        
        return $db;
    }
}