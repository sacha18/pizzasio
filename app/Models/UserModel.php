<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\User;

class UserModel extends Model
{
    // Définition des attributs de la classe
    protected $table = 'user'; // Nom de la table dans la base de données
    protected $primaryKey = 'id'; // Clé primaire de la table
    protected $allowedFields = [ // Champs autorisés à être modifiés via les méthodes de cette classe
        'id',
        'username',
        'email',
        'photo',
        'password',
        'admin',
        'active',
        'auth_attempt'
    ];
    protected $useTimestamps = false; // Désactive les timestamps pour la création et la mise à jour automatique des enregistrements

    // Méthode pour récupérer un utilisateur par son ID
    public function getUserById($id)
    {
        return $this->find($id); // Récupère un utilisateur par son ID
    }

    // Méthode pour récupérer un utilisateur par son adresse e-mail
    public function getUserByMail($email)
    {
        return $this->where('email', $email)->first(); // Récupère un utilisateur par son adresse e-mail
    }

    // Méthode pour obtenir tous les utilisateurs
    public function getAllUser()
    {
        $builder = $this->builder(); // Initialise un constructeur de requête
        return $builder->get()->getResultArray(); // Exécute la requête et retourne tous les résultats sous forme de tableau
    }

    // Méthode pour définir le nombre de tentatives d'authentification pour un utilisateur
    public function setAuthAttempt($auth_attempt, $email)
    {
        return $this->set('active', $auth_attempt)->where('email', $email); // Définit le nombre de tentatives d'authentification pour un utilisateur spécifique
    }

    // Méthode pour créer un nouvel utilisateur
    public function createUser(User $user)
    {
        return $this->insert($user); // Insère un nouvel utilisateur dans la base de données
    }

    // Méthode pour mettre à jour un utilisateur existant
    public function updateUser(User $user)
    {
        return $this->update($user->getId(), $user); // Met à jour un utilisateur dans la base de données en fonction de son ID
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($id)
    {
        return $this->delete($id); // Supprime un utilisateur de la base de données en fonction de son ID
    }

    // Méthode pour obtenir une liste paginée d'utilisateurs
    function getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder(); // Initialise un constructeur de requête

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('email', $searchValue);
            $builder->orLike('username', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray(); // Exécute la requête et retourne les résultats sous forme de tableau
    }

    // Méthode pour obtenir le nombre total d'utilisateurs
    public function getTotalUser()
    {
        return $this->builder()->countAllResults(); // Compte le nombre total d'utilisateurs dans la base de données
    }

    // Méthode pour obtenir le nombre d'utilisateurs filtrés
    public function getFilteredUser($searchValue)
    {
        $builder = $this->builder(); // Initialise un constructeur de requête

        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('username', $searchValue);
            $builder->orlike('email', $searchValue);
        }
        return $builder->countAllResults(); // Exécute la requête et retourne le nombre total de résultats
    }
}
