<?php

namespace App\Models;

use CodeIgniter\Model;

class ComposePizzaModel extends Model
{
    protected $table = 'compose_pizza';
    protected $allowedFields = [
        'id_pizza', 'id_ingredient',
    ];
    protected $useTimestamps = false;

    public function insertPizzaIngredients($data)
    {
        $builder = $this->db->table($this->table);
        $builder->insertBatch($data);
    }

    public function updatePizzaIngredient($data)
    {
    }

    public function getIngredientByPizzaId($id_pizza)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ingredient.name, ingredient.id');
        $builder->join('ingredient', 'ingredient.id = 
        compose_pizza.id_ingredient');
        $builder->where('compose_pizza.id_pizza', $id_pizza);
        $query = $builder->get();
        $data = $query->getResult();
        return $data;
    }
}
