<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAlterPizza extends Migration
{
    public function up()
    {
        $fields = [
            'price' => [
                'type' => 'FLOAT',
                'default' => 0.00
            ],
        ];

        $this->forge->addColumn('pizza', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('price', true);
    }
}
