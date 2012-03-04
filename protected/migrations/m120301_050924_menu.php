<?php

class m120301_050924_menu extends CDbMigration
{

    private $_table = 'menu';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id'    => 'pk',
            'rgt'   => 'integer NOT NULL',
            'lft'   => 'integer NOT NULL',
            'level' => 'integer NOT NULL',
            'title' => 'varchar(100) NOT NULL',
            'url'   => 'varchar(255) NOT NULL',
            'alt'   => 'text DEFAULT NULL',
        ));

        $this->createIndex('rgt', $this->_table, 'rgt');
        $this->createIndex('lft', $this->_table, 'lft');
        $this->createIndex('level', $this->_table, 'level');

        $this->insert($this->_table, array(
            'rgt'   => 2,
            'lft'   => 1,
            'level' => 1,
            'title' => 'Menu',
        ));
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }

}