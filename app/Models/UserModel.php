<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\User;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'username', 'email', 'photo',
        'password', 'admin', 'active', 'auth_attempt'
    ];
    protected $useTimestamps = false;

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function getUserByMail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getAllUser()
    {

        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }

    public function setAuthAttempt($auth_attempt, $email)
    {
        return $this->set('active', $auth_attempt)->where('email', $email);
    }
    public function createUser(User $user)
    {
        return $this->insert($user);
    }

    public function updateUser(User $user)
    {
        return $this->update($user->getId(), $user);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    function getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection)

    {
        $builder = $this->builder();

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
        return $builder->get()->getResultArray();
    }

    public function getTotalUser()
    {
        return $this->builder()->countAllResults();
    }

    public function getFilteredUser($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('username', $searchValue);
            $builder->orlike('email', $searchValue);
        }
        return $builder->countAllResults();
    }
}
