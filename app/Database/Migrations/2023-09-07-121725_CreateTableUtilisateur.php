<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUtilisateur extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unisgned'  => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'password' => [
                'null'  => true,
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'admin' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'active' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'auth_attempt' => [
                'type' => 'INTEGER',
                'default' => 0,
            ],
            'photo' => [
                'type' => 'text',
                'null' => true,
            ],
        ]);

        $this->forge->addField('created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['email']);
        $this->forge->createTable('user', true);

        $um = model('UserModel');
        $user = new \App\MyClass\User (
            null,
            "admin",
            'admin@pizza',
            null,
            true,
            true,
            0,
            null
        );
        $user->setPassword('pizza');
        $um->createUser($user);
    }

    public function down()
    {
        echo 'drop table user';
        $this->forge->dropTable('user', true);
    }
}
