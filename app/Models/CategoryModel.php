<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Category;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'icon', 'id_step',
    ];
    protected $useTimestamps = false;

    public function getCategoryById($id)
    {
        return $this->find($id);
    }

    public function getCategoryByIdStep($id_step)
    {
        return $this->where('id_step', $id_step)->findAll();
    }

    public function getAllCategory()
    {

        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }
    public function createCategory(Category $category)
    {
        return $this->insert($category);
    }

    public function updateCategory(Category $Category)
    {
        return $this->update($Category->getId(), $Category);
    }

    public function deleteCategory($id)
    {
        return $this->delete($id);
    }
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

    public function getTotalCategory()
    {
        return $this->builder()->countAllResults();
    }

    public function getFilteredCategory($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
        }
        return $builder->countAllResults();
    }
}
