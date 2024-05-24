<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Step;

class StepModel extends Model
{
    // Définition des attributs de la classe
    protected $table = 'step'; // Nom de la table dans la base de données
    protected $primaryKey = 'id'; // Clé primaire de la table
    protected $allowedFields = [ // Champs autorisés à être modifiés via les méthodes de cette classe
        'id',
        'name',
        'order',
    ];
    protected $useTimestamps = false; // Désactive les timestamps pour la création et la mise à jour automatique des enregistrements

    // Méthode pour récupérer une étape par son ID
    public function getStepById($id)
    {
        return $this->find($id); // Récupère une étape par son ID
    }

    // Méthode pour obtenir toutes les étapes
    public function getAllStep()
    {
        $builder = $this->builder(); // Initialise un constructeur de requête
        return $builder->orderBy('order', 'ASC')->get()->getResultArray(); // Exécute la requête et retourne tous les résultats sous forme de tableau, triés par ordre croissant
    }

    // Méthode pour créer une nouvelle étape
    public function createStep(Step $step)
    {
        return $this->insert($step); // Insère une nouvelle étape dans la base de données
    }

    // Méthode pour mettre à jour une étape existante
    public function updateStep(Step $step)
    {
        return $this->update($step->getId(), $step); // Met à jour une étape dans la base de données en fonction de son ID
    }

    // Méthode pour supprimer une étape
    public function deleteStep($id)
    {
        return $this->delete($id); // Supprime une étape de la base de données en fonction de son ID
    }

    // Méthode pour obtenir une liste paginée d'étapes
    function getPaginatedStep($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder(); // Initialise un constructeur de requête

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
        return $builder->get()->getResultArray(); // Exécute la requête et retourne les résultats sous forme de tableau
    }

    // Méthode pour obtenir le nombre total d'étapes
    public function getTotalStep()
    {
        return $this->builder()->countAllResults(); // Compte le nombre total d'étapes dans la base de données
    }

    // Méthode pour obtenir le nombre d'étapes filtrées
    public function getFilteredStep($searchValue)
    {
        $builder = $this->builder(); // Initialise un constructeur de requête

        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('order', $searchValue);
        }
        return $builder->countAllResults(); // Exécute la requête et retourne le nombre total de résultats
    }
}
