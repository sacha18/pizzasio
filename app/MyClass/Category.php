<?php

namespace App\MyClass;

class Category
{
    protected $id;
    protected $name;
    protected $icon;
    protected $id_step;


    public function __construct(
        $id,
        $name,
        $icon,
        $id_step
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
        $this->id_step = $id_step;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getIcon()
    {
        return $this->icon;
    }
    public function getIdStep()
    {
        return $this->id_step;
    }

}
