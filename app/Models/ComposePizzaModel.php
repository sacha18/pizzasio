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

    public function deletePizzaIngredients($data)
    {
        $builder = $this->db->table($this->table);
        foreach ($data['ing_suppr'] as $delId) {
            $builder
                ->where('id_pizza', $data['id'])
                ->where('id_ingredient', $delId)
                ->limit(1)
                ->delete();
        }
    }

    public function getIngredientByPizzaId($id_pizza)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ingredient.name, ingredient.id, ingredient.price');
        $builder->join('ingredient', 'ingredient.id = 
        compose_pizza.id_ingredient');
        $builder->join('category', 'ingredient.id_category = category.id');
        $builder->join('step', 'category.id_step = step.id');
        $builder->where('compose_pizza.id_pizza', $id_pizza);
        $builder->where('category.name LIKE ', '%Pâte%')->orWhere('step.name NOT LIKE ', '%Pâte%');
        $builder->where('category.name LIKE ', '%Base%')->orWhere('step.name NOT LIKE ', '%Base%');
        $query = $builder->get();
        $data = $query->getResult();
        return $data;
    }
}
