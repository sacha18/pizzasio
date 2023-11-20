<?php

namespace App\MyClass;

class User
{
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $admin;
    public $active;
    public $auth_attempt;
    protected $photo;

    public function __construct(
        $id,
        $username,
        $email,
        $password,
        $admin,
        $active,
        $auth_attempt,
        $photo
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->admin = $admin;
        $this->active = $active;
        $this->auth_attempt = $auth_attempt;
        $this->photo = $photo;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getAuthAttempt()
    {
        return $this->auth_attempt;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPassword(string $pass)
    {
        if ($pass !== null) {
            $this->password = password_hash($pass, PASSWORD_BCRYPT);
        }
    }

    public function isAdmin()
    {
        return $this->admin === 't';
    }

    public function photoPath($base = false)
    {
        if ($base) {
            return ROOTPATH . '/public/assets/media/avatars/';
        }

        return ROOTPATH . '/public/assets/media/avatars/user_' . $this->id . '.jpg';
    }

    public function photoUrl()
    {
        if ($this->photo) {
            return $this->photo;
        }

        return '/assets/media/avatars/blank.png';
    }
}
