<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableComposePizza extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pizza' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
            'id_ingredient' => [
                'type' => 'INT',
                'unisgned'  => true,
            ],
        ]);

        $this->forge->addForeignKey('id_pizza', 'pizza', 'id');
        $this->forge->addForeignKey('id_ingredient', 'ingredient', 'id');
        $this->forge->createTable('compose_pizza', true);

    }

    public function down()
    {
        $this->forge->dropTable('compose_pizza', true);
    }
}
