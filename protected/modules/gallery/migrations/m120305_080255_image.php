<?php

class m120305_080255_image extends CDbMigration
{
    protected $_table = 'images';
    
	public function up()
	{
        $this->createTable($this->_table, array(
            'id' => 'pk',
        ));
	}

	public function down()
	{
		echo "m120305_080255_image does not support migration down.\n";
		return false;
	}
}