<?php

class m120228_203920_pages extends CDbMigration
{

    private $_table = 'pages';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id'          => 'pk',
            'title'       => 'varchar(100) NOT NULL',
            'alt'         => 'text DEFAULT NULL',
            'url'         => 'varchar(150) NOT NULL UNIQUE',
            'text'        => 'text DEFAULT NULL',
            'description' => 'varchar(150) DEFAULT NULL',
            'keywords'    => 'varchar(150) DEFAULT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }

}