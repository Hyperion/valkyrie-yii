<?php

class m120128_155600_schema extends CDbMigration
{

    public $superuserName     = 'Admin';
    public $authenticatedName = 'Authenticated';
    public $guestName         = 'Guest';

    public function up()
    {
        $this->createTable('auth_items', array(
            'name'        => 'varchar(64) NOT NULL PRIMARY KEY',
            'type'        => 'integer NOT NULL',
            'description' => 'text',
            'bizrule'     => 'text',
            'data'        => 'text',
        ));

        $this->createTable('auth_items_child', array(
            'parent' => 'varchar(64) NOT NULL',
            'child'  => 'varchar(64) NOT NULL',
            'PRIMARY KEY (`parent`, `child`)',
            'FOREIGN KEY (`parent`) REFERENCES `auth_items` (`name`)',
            'FOREIGN KEY (`child`) REFERENCES `auth_items` (`name`)',
        ));

        $this->createTable('auth_assignments', array(
            'itemname' => 'varchar(64) NOT NULL',
            'userid'  => 'varchar(64) NOT NULL',
            'bizrule'  => 'text',
            'data'     => 'text',
            'PRIMARY KEY (`itemname`, `userid`)',
            'FOREIGN KEY (`itemname`) REFERENCES `auth_items` (`name`)',
        ));

        $this->createTable('rights', array(
            'itemname' => 'varchar(64) NOT NULL PRIMARY KEY',
            'type'     => 'integer NOT NULL',
            'weight'   => 'integer NOT NULL',
            'FOREIGN KEY (`itemname`) REFERENCES `auth_items` (`name`)',
        ));

        $roles = $this->getUniqueRoles();
        foreach ($roles as $roleName)
        {
            $sql     = "INSERT INTO auth_items (name, type, data)
                    VALUES (:name, :type, :data)";
            $command = $this->dbConnection->createCommand($sql);
            $command->bindValue(':name', $roleName);
            $command->bindValue(':type', CAuthItem::TYPE_ROLE);
            $command->bindValue(':data', 'N;');
            $command->execute();
        }
    }

    public function down()
    {
        $this->dropTable('rights');
        $this->dropTable('auth_assignments');
        $this->dropTable('auth_items_child');
        $this->dropTable('auth_items');
    }

    private function getUniqueRoles()
    {
        $roles = array(
            $this->superuserName,
            $this->authenticatedName,
            $this->guestName,
        );
        return array_unique($roles);
    }

}