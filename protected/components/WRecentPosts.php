<?php

Yii::import('zii.widgets.CPortlet');

class WRecentPosts extends CPortlet
{
	public $title='Recent Materials';
	public $maxComments=10;

	public function getRecentPosts()
	{
		return Material::model()->findRecentPosts($this->maxComments);
	}

	protected function renderContent()
	{
		$this->render('recentPosts');
	}
}
