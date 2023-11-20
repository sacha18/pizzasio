<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Ingredient;

class IngredientModel extends Model
{
    protected $table = 'ingredient';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'stock', 'price',
        'bio', 'vegan', 'id_category'
    ];
    protected $useTimestamps = false;

    public function getIngredientById($id)
    {
        return $this->find($id);
    }


    public function getAllIngredient()
    {

        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }
    

    public function getIngredientByIdCategory($id_category)
    {
        return $this->where('id_category', $id_category)->findAll();
    }


    public function createIngredient(Ingredient $ingredient)
    {
        return $this->insert($ingredient);
    }

    public function updateIngredient(Ingredient $ingredient)
    {
        return $this->update($ingredient->getId(), $ingredient);
    }

    public function deleteIngredient($id)
    {
        return $this->delete($id);
    }
    function getPaginatedIngredient($start, $length, $searchValue, $orderColumnName, $orderDirection)

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

    public function getTotalIngredient()
    {
        return $this->builder()->countAllResults();
    }

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
