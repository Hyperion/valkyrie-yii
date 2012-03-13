<?php

class m120311_143652_blocked_ips extends CDbMigration
{
    private $_table = 'blocked_ips';
    
	public function up()
	{
        $this->createTable($this->_table, array(
            'id' => 'pk',
            'mask' => 'string NOT NULL',
        ));
	}

	public function down()
	{
        $this->dropTable($this->_table);
	}
}