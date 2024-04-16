<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commande';
    protected $allowedFields = [
        'id_commande', 'date_commande',
        'id_client', 'total_commande',
    ];
    protected $useTimestamps = false;

    public function insertCommande($data)
    {
        return $this->insert($data);
    }

    public function insertLigneCommande($id_commande, $pizza)
    {
        $builder = $this->db->table('ligne_commande');

        foreach ($pizza as $p) {
            $id_pizza = $p["id"];
            $prix = $p['price'];

            $data = array(
                'id_commande' => $id_commande,
                'id_pizza' => $id_pizza,
                'price_commande' => $prix
            );

            $builder->insert($data);
        }
    }
}
