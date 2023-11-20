<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEtapeIngredient extends Migration
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
            'order' => [
                'type' => 'INT',
                'constraint' => 2,
                'unisgned'  => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('step', true);

    }

    public function down()
    {
        $this->forge->dropTable('step', true);
    }
}
