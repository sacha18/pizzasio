<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Pizza;

class PizzaModel extends Model
{
    // Définition des attributs de la classe
    protected $table = 'pizza'; // Nom de la table dans la base de données
    protected $primaryKey = 'id'; // Clé primaire de la table
    protected $allowedFields = [ // Champs autorisés à être modifiés via les méthodes de cette classe
        'id',
        'name',
        'active',
        'base',
        'dough',
        'price',
        'img_url',
    ];
    protected $useTimestamps = false; // Désactive les timestamps pour la création et la mise à jour automatique des enregistrements

    // Méthode pour créer une nouvelle pizza
    public function createPizza($name, $base, $pate, $img_url)
    {
        $builder = $this->db->table($this->table); // Initialise un constructeur de requête
        $builder->set('name', $name); // Définit le nom de la pizza
        $builder->set('active', 1); // Définit l'état actif de la pizza
        $builder->set('base', $base); // Définit la base de la pizza
        $builder->set('dough', $pate); // Définit la pâte de la pizza
        $builder->set('img_url', $img_url); // Définit l'URL de l'image de la pizza
        $builder->set('active', 0); // Désactive temporairement la pizza
        $builder->insert(); // Exécute l'insertion dans la base de données
        return $this->db->insertID(); // Retourne l'ID de la nouvelle pizza créée
    }

    // Méthode pour mettre à jour une pizza
    public function updatePizza($data)
    {
        $builder = $this->db->table($this->table); // Initialise un constructeur de requête

        // Vérifie si des données sont fournies pour mettre à jour
        if (isset($data['id'])) {
            // Met à jour les champs de la pizza spécifiée
            $builder->where('id', $data['id']);
            if (isset($data['name'])) $builder->set('name', (string) $data['name']);
            if (isset($data['base'])) $builder->set('base', (int) $data['base']);
            if (isset($data['dough'])) $builder->set('dough', (int) $data['dough']);
            if (isset($data['active'])) $builder->set('active', (bool) $data['active']);
            if (isset($data['img_url'])) $builder->set('img_url', (bool) $data['img_url']);
            $builder->update(); // Exécute la mise à jour dans la base de données
        }
    }

    // Méthode pour supprimer la pâte ou la base d'une pizza
    public function deletePizzaDoughOrBase($data)
    {
        $builder = $this->db->table($this->table); // Initialise un constructeur de requête

        // Vérifie si des données sont fournies pour la suppression
        if (isset($data['id'])) {
            // Supprime la pâte ou la base de la pizza spécifiée
            if (isset($data['dough_suppr'])) $builder->set('dough', null);
            if (isset($data['base_suppr'])) $builder->set('base', null);
            $builder->where('id', $data['id']);
            $builder->update(); // Exécute la mise à jour dans la base de données
        }
    }

    // Méthode pour récupérer une pizza par son ID
    public function getPizzaById($id) {
        return $this->find($id); // Récupère une pizza par son ID
    }

    // Méthode pour obtenir une liste paginée de pizzas
    function getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder(); // Initialise un constructeur de requête

        // Recherche
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }
        $builder->limit($length, $start);
        return $builder->get()->getResultArray(); // Exécute la requête et retourne les résultats sous forme de tableau
    }

    // Méthode pour obtenir le nombre total de pizzas
    public function getTotalPizza()
    {
        return $this->builder()->countAllResults(); // Compte le nombre total de pizzas dans la base de données
    }

    // Méthode pour obtenir toutes les pizzas
    public function getAllPizza()
    {
        $builder = $this->builder(); // Initialise un constructeur de requête
        return $builder->get()->getResultArray(); // Exécute la requête et retourne tous les résultats sous forme de tableau
    }

    // Méthode pour récupérer toutes les pizzas avec leurs ingrédients
    public function getPizzasWithIngredients() {
        $builder = $this->db->table($this->table); // Initialise un constructeur de requête
        $builder->select('pizza.id, pizza.name, pizza.active, ib.name AS base, ip.name AS dough, pizza.price, pizza.img_url, ing.id AS ingredient_id, ing.name AS ingredient_name');
        $builder->join('ingredient AS ib', 'pizza.base = ib.id');
        $builder->join('ingredient AS ip', 'pizza.dough = ip.id');
        $builder->join('compose_pizza AS cp', 'pizza.id = cp.id_pizza');
        $builder->join('ingredient AS ing', 'cp.id_ingredient = ing.id');
        $query = $builder->get();
        $result = $query->getResult();

        // Tableau pour stocker les pizzas avec leurs ingrédients
        $pizzasWithIngredients = array();

        // Parcourir les résultats pour regrouper les pizzas avec leurs ingrédients
        foreach ($result as $pizza) {
            $pizzaId = $pizza->id;
            $pizzaName = $pizza->name;
            $ingredientId = $pizza->ingredient_id;
            $ingredientName = $pizza->ingredient_name;

            // Vérifier si la pizza existe déjà dans le tableau
            if (!isset($pizzasWithIngredients[$pizzaId])) {
                // Si la pizza n'existe pas, l'ajouter au tableau
                $pizzasWithIngredients[$pizzaId] = array(
                    'id' => $pizzaId,
                    'name' => $pizzaName,
                    'active' => $pizza->active,
                    'base' => $pizza->base,
                    'dough' => $pizza->dough,
                    'price' => $pizza->price,
                    'img_url' => $pizza->img_url,
                    'ingredients' => array()
                );
            }

            // Vérifier si l'ingrédient existe déjà dans la liste des ingrédients de la pizza
            $ingredientExists = false;
            foreach ($pizzasWithIngredients[$pizzaId]['ingredients'] as &$ingredient) {
                if ($ingredient['id'] == $ingredientId) {
                    // Si l'ingrédient existe déjà, augmenter son compteur
                    $ingredient['count']++;
                    $ingredientExists = true;
                    break;
                }
            }

            // Si l'ingrédient n'existe pas dans la liste des ingrédients de la pizza, l'ajouter
            if (!$ingredientExists) {
                $pizzasWithIngredients[$pizzaId]['ingredients'][] = array(
                    'id' => $ingredientId,
                    'name' => $ingredientName,
                    'count' => 1
                );
            }
        }

        // Convertir le tableau associatif en un tableau indexé
        $pizzasWithIngredients = array_values($pizzasWithIngredients);

        return $pizzasWithIngredients;
    }

    // Méthode pour récupérer le nombre de pizzas filtrées
    public function getFilteredPizza($searchValue)
    {
        $builder = $this->builder(); // Initialise un constructeur de requête

        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }
        return $builder->countAllResults(); // Exécute la requête et retourne le nombre total de résultats
    }
}

