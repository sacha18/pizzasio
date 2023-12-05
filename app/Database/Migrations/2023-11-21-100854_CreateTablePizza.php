<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePizza extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],

            'active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'base' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
            'dough' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
        ]);

        $this->forge->addForeignKey('base', 'ingredient', 'id' );
        $this->forge->addForeignKey('dough', 'ingredient', 'id');
        $this->forge->addKey('id', true);
        $this->forge->createTable('pizza', true);

    }

    public function down()
    {
        $this->forge->dropTable('pizza', true);
    }
}
