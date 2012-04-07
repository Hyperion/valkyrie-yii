<?php

class m120406_212129_wow_databases extends CDbMigration
{
    private $_table = 'wow_databases';
    
    public function up()
	{
        $this->createTable($this->_table, array(
            'id' => 'pk',
            'name' => 'string NOT NULL  DEFAULT "Realmlist"',
            'host' => 'string NOT NULL',
            'type' => 'string NOT NULL DEFAULT "realm"',
            'adapter' => 'string NOT NULL DEFAULT "mysql"',
            'username' => 'string',
            'password' => 'varbinary(256)',
            'database' => 'string',
        ));
	}

	public function down()
	{
		$this->dropTable($this->_table);
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}