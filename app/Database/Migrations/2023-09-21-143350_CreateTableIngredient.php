<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableIngredient extends Migration
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
            'stock' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'price' => [
                'type' => 'FLOAT',
                'unisgned'  => true,
            ],
            'bio' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'vegan' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'id_category' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
        ]);

        $this->forge->addForeignKey('id_category', 'category', 'id');
        $this->forge->addKey('id', true);
        $this->forge->createTable('ingredient', true);

    }

    public function down()
    {
        $this->forge->dropTable('ingredient', true);
    }
}
