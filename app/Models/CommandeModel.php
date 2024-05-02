<?php

namespace App\Models;

use App\MyClass\Commande;
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
            $size = $p['size'];

            $data = array(
                'id_commande' => $id_commande,
                'id_pizza' => $id_pizza,
                'price_commande' => $prix,
                'size' => $size,
            );

            $builder->insert($data);
        }
    }

    public function getLigneCommandeByIdCommande($id)
    {
        $builder = $this->db->table('ligne_commande');
        $result = $builder->where('id_commande', $id)->get()->getResultArray();

        // Charger le modèle de pizza
        $pizzaModel = model('PizzaModel');

        // Boucler à travers chaque élément de la ligne de commande
        foreach ($result as &$ligne) {
            // Obtenir les détails de la pizza correspondant à l'id_pizza
            $pizza = $pizzaModel->getPizzaById($ligne['id_pizza']);
            // Ajouter le nom de la pizza à l'objet ligne de commande
            $ligne['name'] = $pizza['name'];
            $ligne['image'] = $pizza['img_url'];
        }

        return $result;
    }


    public function getCommandeByIdClient($id_client)
    {
        $data = [];
        $commandes = $this->where('id_client', $id_client)->findAll();
        foreach ($commandes as $commande) {
            $ligne_commande = $this->getLigneCommandeByIdCommande($commande['id_commande']);
            $data[] = ['commande' => $commande, 'ligne_commande' => $ligne_commande];
        }
        return $data;
    }

    public function getCommandeByIdClientAndIdCommand($id_client, $id_commande)
    {
        $commande = $this->where('id_client', $id_client)
            ->where('id_commande', $id_commande)
            ->first();

        if ($commande) {
            $ligne_commande = $this->getLigneCommandeByIdCommande($id_commande);
            $pizzaModel = model('PizzaModel');
            $data = ['commande' => $commande, 'ligne_commande' => $ligne_commande];
            return $data;
        } else {
            return null;
        }
    }

    function getPaginatedCommande($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id_commande', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray();
    }


    public function getTotalCommande()
    {
        return $this->builder()->countAllResults();
    }
    public function getFilteredCommande($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id_commande', $searchValue);
        }
        return $builder->countAllResults();
    }

    public function updateCommande(Commande $Commande)
    {
        return $this->update($Commande->getIdCommande(), $Commande);
    }

    public function createCommande(Commande $Commande)
    {
        return $this->insert($Commande);
    }

    public function deleteCommande($id)
    {
        return $this->delete($id);
    }

}
