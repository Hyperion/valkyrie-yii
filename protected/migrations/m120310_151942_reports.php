<?php

class m120310_151942_reports extends CDbMigration
{

    private $_table = 'reports';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id'               => 'pk',
            'create_time'      => 'integer',
            'status'           => 'boolean NOT NULL DEFAULT 0',
            'report_text'      => 'text',
            'owner_id'         => 'integer',
            'owner_controller' => 'string NOT NULL',
            'owner_module'     => 'string',
            'user_id'          => 'integer',
        ));
        
        $this->createIndex('report', $this->_table, 'owner_id, owner_controller, owner_module', true);
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }
}