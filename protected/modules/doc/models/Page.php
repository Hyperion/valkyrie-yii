<?php

class Page extends CModel
{
	private $_content;
	private $_image = false;
	private $_html = false;
	private $_translated = false;
	private $_path;
	private $_name;
	private $_title = false;
	private $_language;
	
	public function __construct($section, $name, $language)
	{
		$this->_path = YiiBase::getPathOfAlias('application.modules.doc.pages.'.$section);
		$this->_name = $name;
		$this->_language = $language;
		if(preg_match('{\.gif$|\.jpe?g$|\.png$}si', $name))
		{
			$this->_path = $this->_path.'/images/';
			$this->_image = true;
		}
	}
	
	public function attributeNames()
	{
		return array(
			'content',
			'title',
		);
	}
	
	public function getContent()
	{
		return $this->_content;
	}
	
	public function getTitle()
	{
		return $this->_title;
	}
	
	public function isImage()
	{
		return $this->_image;
	}
	
	public function loadPage()
	{
		if(file_exists($this->_path.'/'.$this->_language.'/'.$this->_name.'.txt'))
			$this->_translated = true;
			
		if($this->_image)
			$fname = $this->_path.'/'.$this->_name;
		elseif($this->_translated)
			$fname = $this->_path.'/'.$this->_language.'/'.$this->_name.'.txt';
		else
			$fname = $this->_path.'/'.$this->_name.'.txt';
			
		if(file_exists($fname))
		{
			$this->_content = file_get_contents($fname);
			if(!$this->_image)
				if($this->_name != 'toc')
					$this->_title = substr($this->_content, 0, strpos($this->_content, "\n"));
				else
					$this->_title = 'Table of content';
			return true;
		}
		else
			return false;
	}
}