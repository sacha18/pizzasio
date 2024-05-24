<?php

namespace App\Models;

use CodeIgniter\Model;

class ComposePizzaModel extends Model
{
    // Définition de la table de la base de données
    protected $table = 'compose_pizza';

    // Champs autorisés à être insérés ou mis à jour
    protected $allowedFields = [
        'id_pizza', 'id_ingredient',
    ];

    // Désactivation de l'utilisation des timestamps
    protected $useTimestamps = false;

    // Méthode pour insérer les ingrédients d'une pizza
    public function insertPizzaIngredients($data)
    {
        $builder = $this->db->table($this->table);
        $builder->insertBatch($data);
    }

    // Méthode pour supprimer les ingrédients d'une pizza
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

    // Méthode pour obtenir les ingrédients par l'ID de la pizza
    public function getIngredientByPizzaId($id_pizza, $withoutDoughAndBase = false)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ingredient.name, ingredient.id, ingredient.price');
        $builder->join('ingredient', 'ingredient.id = compose_pizza.id_ingredient');
        $builder->join('category', 'ingredient.id_category = category.id');
        $builder->where('compose_pizza.id_pizza', $id_pizza);

        if ($withoutDoughAndBase) {
            $builder->join('step', 'category.id_step = step.id');
            $builder->groupStart();
            $builder->where('category.name NOT LIKE', '%Pâte%');
            $builder->orWhere('step.name NOT LIKE', '%Pâte%');
            $builder->groupEnd();
            $builder->groupStart();
            $builder->where('category.name NOT LIKE', '%Base%');
            $builder->orWhere('step.name NOT LIKE', '%Base%');
            $builder->groupEnd();
        }

        $query = $builder->get();
        return $query->getResult();
    }

}
