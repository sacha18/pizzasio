<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Step;

class StepModel extends Model
{
    protected $table = 'step';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'order',
    ];
    protected $useTimestamps = false;

    public function getStepById($id)
    {
        return $this->find($id);
    }


    public function getAllStep()
    {

        $builder = $this->builder();
        return $builder->orderBy('order', 'ASC')->get()->getResultArray();
    }
    public function createStep(Step $step)
    {
        return $this->insert($step);
    }

    public function updateStep(Step $step)
    {
        return $this->update($step->getId(), $step);
    }

    public function deleteStep($id)
    {
        return $this->delete($id);
    }
    function getPaginatedStep($start, $length, $searchValue, $orderColumnName, $orderDirection)

    {
        $builder = $this->builder();

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('order', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }

    public function getTotalStep()
    {
        return $this->builder()->countAllResults();
    }

    public function getFilteredStep($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('order', $searchValue);
        }
        return $builder->countAllResults();
    }
}
