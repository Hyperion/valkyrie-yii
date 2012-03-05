<?php

class m120305_122152_sliders extends CDbMigration
{

    private $_table = 'sliders';

    public function up()
    {
        $this->createTable($this->_table, array(
            'id'   => 'pk',
            'file' => 'string NOT NULL',
        ));
    }

    public function down()
    {
        $this->dropTable($this->_table);
    }

}