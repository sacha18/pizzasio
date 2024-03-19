<?php

namespace App\Controllers;
use App\MyClass\User;


class Api extends BaseController
{
    public function getIndex()
    {
        return $this->view('api\index');
    }
}
