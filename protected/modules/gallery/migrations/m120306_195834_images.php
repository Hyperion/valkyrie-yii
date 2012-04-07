<?php

class m120306_195834_images extends CDbMigration
{

    private $_table = 'images';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id'          => 'pk',
            'description' => 'text',
            'user_id'     => 'integer NOT NULL DEFAULT 0',
            'album_id'    => 'INTEGER NOT NULL DEFAULT 0',
            'user_guid'   => 'varchar(75) NOT NULL',
            'create_time' => 'integer NOT NULL',
            'last_visit'  => 'integer NOT NULL',
            'image'       => 'string NOT NULL',
            'url'         => 'string NOT NULL',
            'thumb_url'   => 'string NOT NULL',
            'mime_type'   => 'string NOT NULL',
            'size'        => 'INTEGER NOT NULL',
            'width'       => 'INTEGER NOT NULL',
            'height'      => 'INTEGER NOT NULL',
        ));

        $this->createIndex('user_id', $this->_table, 'user_id');
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }

}