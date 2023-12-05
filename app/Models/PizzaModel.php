<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Pizza;

class PizzaModel extends Model
{
    protected $table = 'pizza';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'base', 'dough', 'active',
    ];
    protected $useTimestamps = false;

    public function createPizza($name, $base, $pate)
    {
        $builder = $this->db->table($this->table);
        $builder->set('name', $name);
        $builder->set('base', $base);
        $builder->set('dough', $pate);

        $builder->set('active', 0);

        $builder->insert();
        return $this->db->insertID();
    }

    public function updatePizza($data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data['name'])) $builder->set('name', (string) $data['name']);
        if (isset($data['base'])) $builder->set('base', (int) $data['base']);
        if (isset($data['dough'])) $builder->set('dough', (int) $data['dough']);
        if (isset($data['active'])) $builder->set('active', (bool) $data['active']);

        if (isset($data['id'])) {
            $builder->where('id', $data['id']);
            $builder->update();
        }
    }

    public function getPizzaById($id) {
        return $this->find($id);
    }
}
