<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Category;

class CategoryModel extends Model
{
    // Définition de la table de la base de données
    protected $table = 'category';

    // Clé primaire de la table
    protected $primaryKey = 'id';

    // Champs autorisés à être insérés ou mis à jour
    protected $allowedFields = [
        'id', 'name', 'icon', 'id_step',
    ];

    // Désactivation de l'utilisation des timestamps
    protected $useTimestamps = false;

    // Méthode pour récupérer une catégorie par son ID
    public function getCategoryById($id)
    {
        return $this->find($id);
    }

    // Méthode pour récupérer les catégories par l'ID de l'étape associée
    public function getCategoryByIdStep($id_step)
    {
        return $this->where('id_step', $id_step)->findAll();
    }

    // Méthode pour récupérer toutes les catégories
    public function getAllCategory()
    {
        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }

    // Méthode pour créer une nouvelle catégorie
    public function createCategory(Category $category)
    {
        return $this->insert($category);
    }

    // Méthode pour mettre à jour une catégorie
    public function updateCategory(Category $Category)
    {
        return $this->update($Category->getId(), $Category);
    }

    // Méthode pour supprimer une catégorie
    public function deleteCategory($id)
    {
        return $this->delete($id);
    }

    // Méthode pour obtenir les catégories paginées avec recherche et tri
    function getPaginatedCategory($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }

    // Méthode pour obtenir le nombre total de catégories
    public function getTotalCategory()
    {
        return $this->builder()->countAllResults();
    }

    // Méthode pour obtenir le nombre total de catégories filtrées pour la recherche
    public function getFilteredCategory($searchValue)
    {
        $builder = $this->builder();
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
        }
        return $builder->countAllResults();
    }
}
