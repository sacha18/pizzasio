<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id'           => '?integer',
        'username'     => 'string',
        'email'        => 'string',
        'password'     => 'string',
        'admin'        => 'boolean',
        'active'       => 'boolean',
        'auth_attempt' => '?integer',
        'photo'        => '?string'
    ];

    /*
        public $id;
        public $username;
        public $email;
        public $password;
        public $admin;
        public $active;
        public $auth_attempt;
        */

    public function setPassword(string $pass)
    {
        if ($pass !== null) {
            $this->attributes['password'] = password_hash($pass, PASSWORD_BCRYPT);
        }

        return $this;
    }

    public function getActive()
    {
        if (!isset($this->attributes['active'])) return false;
        return $this->attributes['active'] === 't';
    }

    public function getAdmin()
    {
        if (!isset($this->attributes['admin'])) return false;
        return $this->attributes['admin'] === 't';
    }

    public function isAdmin()
    {
        if (!isset($this->attributes['admin'])) return false;
        return $this->attributes['admin'] === 't';
    }

    /**
     * Photos
     *
     * @param mixed $base
     */
    public function photo_path($base = false)
    {
        if ($base) {
            return ROOTPATH . '/public/assets/media/avatars/';
        }

        return ROOTPATH . '/public/assets/media/avatars/user_' . $this->id . '.jpg';
    }

    public function photo_url()
    {
        if ($this->photo) {
            return $this->photo;
        }

        return '/assets/media/avatars/blank.png';
    }
}