<?php

class m120317_090444_add_ip_to_users_table extends CDbMigration
{
    private $_table = 'users';
	public function up()
	{
        $this->addColumn($this->_table, 'last_ip', 'string');
	}

	public function down()
	{
		$this->dropColumn($this->_table, 'last_ip');
	}

}