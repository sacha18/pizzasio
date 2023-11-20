<?php

namespace App\MyClass;

class Ingredient
{
    protected $id;
    protected $name;
    protected $stock;
    protected $price;
    protected $bio;
    protected $vegan;
    protected $id_category;

    public function __construct(
        $id,
        $name,
        $stock,
        $price,
        $bio,
        $vegan,
        $id_category
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->stock = $stock;
        $this->price = $price;
        $this->bio = $bio;
        $this->vegan = $vegan;
        $this->id_category = $id_category;

    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getStock()
    {
        return $this->stock;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getBio()
    {
        return $this->bio;
    }
    public function getVegan()
    {
        return $this->vegan;
    }
    public function getIdCategory()
    {
        return $this->id_category;
    }

}
