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

    public function deletePizzaDoughOrBase($data)
    {
        $builder = $this->db->table($this->table);
        if (isset($data['dough_suppr'])) $builder->set('dough', null);
        if (isset($data['base_suppr'])) $builder->set('base', null);
        if (isset($data['id'])) {
            $builder->where('id', $data['id']);
            $builder->update();
        }
    }

    public function getPizzaById($id) {
        return $this->find($id);
    }

    function getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection)

    {
        $builder = $this->builder();

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }

    public function getTotalPizza()
    {
        return $this->builder()->countAllResults();
    }

    public function getAllPizza()
    {
        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }

    public function getAllPizzaWithName()
    {
        $builder =  $this->builder();
        $builder->select('pizza.*, base.name AS base, dough.name AS dough');
        $builder->join('ingredient AS base', 'base.id = pizza.base', 'left');
        $builder->join('ingredient AS dough', 'dough.id = pizza.dough', 'left');
        return $builder->get()->getResultArray();
    }

    public function getFilteredPizza($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }
        return $builder->countAllResults();
    }
}
