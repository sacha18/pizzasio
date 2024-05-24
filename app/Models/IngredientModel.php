<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Ingredient;

class IngredientModel extends Model
{
    // Définition de la table de la base de données
    protected $table = 'ingredient';

    // Clé primaire de la table
    protected $primaryKey = 'id';

    // Champs autorisés à être insérés ou mis à jour
    protected $allowedFields = [
        'id', 'name', 'stock', 'price',
        'bio', 'vegan', 'id_category'
    ];

    // Désactivation de l'utilisation des timestamps
    protected $useTimestamps = false;

    // Méthode pour obtenir un ingrédient par son ID
    public function getIngredientById($id)
    {
        return $this->find($id);
    }

    // Méthode pour obtenir tous les ingrédients
    public function getAllIngredient()
    {
        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }

    // Méthode pour obtenir les ingrédients par l'ID de la catégorie
    public function getIngredientByIdCategory($id_category)
    {
        return $this->where('id_category', $id_category)->findAll();
    }

    // Méthode pour créer un nouvel ingrédient
    public function createIngredient(Ingredient $ingredient)
    {
        return $this->insert($ingredient);
    }

    // Méthode pour mettre à jour un ingrédient
    public function updateIngredient(Ingredient $ingredient)
    {
        return $this->update($ingredient->getId(), $ingredient);
    }

    // Méthode pour supprimer un ingrédient
    public function deleteIngredient($id)
    {
        return $this->delete($id);
    }

    // Méthode pour obtenir les ingrédients avec pagination
    public function getPaginatedIngredient($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orLike('bio', $searchValue);
            $builder->orLike('vegan', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }

    // Méthode pour obtenir le nombre total d'ingrédients
    public function getTotalIngredient()
    {
        return $this->builder()->countAllResults();
    }

    // Méthode pour obtenir le nombre total d'ingrédients filtrés par recherche
    public function getFilteredIngredient($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orLike('bio', $searchValue);
            $builder->orLike('vegan', $searchValue);
        }
        return $builder->countAllResults();
    }
}
