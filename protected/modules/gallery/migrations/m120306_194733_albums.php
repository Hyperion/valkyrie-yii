<?php

class m120306_194733_albums extends CDbMigration
{

    private $_table = 'albums';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id'          => 'pk',
            'name'        => 'string NOT NULL',
            'description' => 'text',
            'user_id'     => 'integer NOT NULL',
            'create_time' => 'integer NOT NULL',
            'cover_id'    => 'integer NOT NULL DEFAULT 0',
            'visible'     => 'boolean DEFAULT 0',
            'visits'      => 'INTEGER NOT NULL DEFAULT 0',
        ));

        $this->createIndex('user_id', $this->_table, 'user_id');
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }

}