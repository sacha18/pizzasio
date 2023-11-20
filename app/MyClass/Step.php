<?php

namespace App\MyClass;

class Step
{
    protected $id;
    protected $name;
    protected $order;

    public function __construct(
        $id,
        $name,
        $order
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->order = $order;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getOrder()
    {
        return $this->order;
    }

}
