<?php

namespace App\Models;

use App\MyClass\Commande;
use CodeIgniter\Model;

class CommandeModel extends Model
{
    // Définition de la table de la base de données
    protected $table = 'commande';

    // Champs autorisés à être insérés ou mis à jour
    protected $allowedFields = [
        'id_commande', 'date_commande',
        'id_client', 'total_commande',
    ];

    // Désactivation de l'utilisation des timestamps
    protected $useTimestamps = false;

    // Méthode pour insérer une nouvelle commande
    public function insertCommande($data)
    {
        return $this->insert($data);
    }

    // Méthode pour insérer les lignes de commande associées à une commande
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

    // Méthode pour récupérer les lignes de commande par l'ID de la commande
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
            // Ajouter le nom de la pizza et l'URL de l'image à l'objet ligne de commande
            $ligne['name'] = $pizza['name'];
            $ligne['image'] = $pizza['img_url'];
        }

        return $result;
    }

    // Méthode pour récupérer les commandes par l'ID du client
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

    // Méthode pour récupérer une commande par l'ID du client et l'ID de la commande
    public function getCommandeByIdClientAndIdCommand($id_client, $id_commande)
    {
        $commande = $this->where('id_client', $id_client)
            ->where('id_commande', $id_commande)
            ->first();

        if ($commande) {
            $ligne_commande = $this->getLigneCommandeByIdCommande($id_commande);
            $data = ['commande' => $commande, 'ligne_commande' => $ligne_commande];
            return $data;
        } else {
            return null;
        }
    }

    // Méthode pour obtenir les commandes paginées avec recherche et tri
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

    // Méthode pour obtenir le nombre total de commandes
    public function getTotalCommande()
    {
        return $this->builder()->countAllResults();
    }

    // Méthode pour obtenir le nombre total de commandes filtrées pour la recherche
    public function getFilteredCommande($searchValue)
    {
        $builder = $this->builder();
        if (!empty($searchValue)) {
            $builder->like('id_commande', $searchValue);
        }
        return $builder->countAllResults();
    }

    // Méthode pour mettre à jour une commande
    public function updateCommande(Commande $Commande)
    {
        return $this->update($Commande->getIdCommande(), $Commande);
    }

    // Méthode pour créer une commande
    public function createCommande(Commande $Commande)
    {
        return $this->insert($Commande);
    }

    // Méthode pour supprimer une commande
    public function deleteCommande($id)
    {
        return $this->delete($id);
    }

}
