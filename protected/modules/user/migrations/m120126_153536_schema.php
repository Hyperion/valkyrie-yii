<?php

class m120126_153536_schema extends CDbMigration
{

    public function up()
    {
        $this->createTable('users', array(
            'id'         => 'pk',
            'username'   => 'varchar(20) NOT NULL UNIQUE',
            'password'   => 'varchar(128) NOT NULL',
            'email'      => 'varchar(128) NOT NULL UNIQUE',
            'activkey'   => 'varchar(128) NOT NULL',
            'createtime' => 'integer NOT NULL DEFAULT "0"',
            'lastvisit'  => 'integer NOT NULL DEFAULT "0"',
            'status'     => 'boolean NOT NULL DEFAULT "0"',
        ));

        $this->createIndex('status', 'users', 'status');

        $this->createTable('profile_fields', array(
            'id'              => 'pk',
            'varname'         => 'varchar(50) NOT NULL',
            'title'           => 'varchar(255) NOT NULL',
            'field_type'      => 'varchar(50) NOT NULL',
            'field_size'      => 'int(3) NOT NULL DEFAULT "0"',
            'field_size_min'  => 'int(3) NOT NULL DEFAULT "0"',
            'required'        => 'int(1) NOT NULL DEFAULT "0"',
            'match'           => 'varchar(255) NOT NULL',
            'range'           => 'varchar(255) NOT NULL',
            'error_message'   => 'varchar(255) NOT NULL',
            'other_validator' => 'varchar(5000) NOT NULL',
            'default'         => 'varchar(255) NOT NULL',
            'widget'          => 'varchar(255) NOT NULL',
            'widgetparams'    => 'varchar(5000) NOT NULL',
            'position'        => 'int(3) NOT NULL DEFAULT "0"',
            'visible'         => 'int(1) NOT NULL DEFAULT "0"',
        ));
        
        $this->createIndex('varname', 'profile_fields', 'varname, widget, visible');
        
        $this->createTable('profiles', array('user_id' => 'integer NOT NULL PRIMARY KEY'));
    }

    public function down()
    {
        $this->dropTable('users');
        $this->dropTable('profile_fields');
        $this->dropTable('profiles');
    }

}