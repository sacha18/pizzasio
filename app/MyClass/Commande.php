<?php

namespace App\MyClass;

class Commande
{
    protected $id_commande;
    protected $date_commande;
    protected $id_client;
    protected $id_step;


    public function __construct(
        $id_commande,
        $date_commande,
        $id_client,
        $total_commande
    ) {
        $this->$id_commande = $id_commande;
        $this->$date_commande = $date_commande;
        $this->id_client = id_client;
        $this->total_commande = total_commande;
    }
    public function getIdCommande()
    {
        return $this->id_commande;
    }
    public function getDateCommande()
    {
        return $this->date_commande;
    }
    public function getIdClient()
    {
        return $this->id_client;
    }
    public function getTotalCommande()
    {
        return $this->total_commande;
    }

}