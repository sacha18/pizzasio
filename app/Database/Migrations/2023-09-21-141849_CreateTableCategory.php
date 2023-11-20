<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryIngredient extends Migration
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
            'icon' => [
                'type' => 'TEXT',
                'constraint' => '255',
                'null' => true,
            ],
            'id_step' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
        ]);

        $this->forge->addForeignKey('id_step', 'step', 'id');
        $this->forge->addKey('id', true);
        $this->forge->createTable('category', true);

    }

    public function down()
    {
        $this->forge->dropTable('category', true);
    }
}
