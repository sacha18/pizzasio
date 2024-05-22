<?php

namespace App\Models;

use CodeIgniter\Model;
use App\MyClass\Pizza;

class PizzaModel extends Model
{
    protected $table = 'pizza';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id', 'name', 'base', 'dough', 'active',
    ];
    protected $useTimestamps = false;

    public function createPizza($name, $base, $pate, $img_url)
    {
        $builder = $this->db->table($this->table);
        $builder->set('name', $name);
        $builder->set('active', 1);
        $builder->set('base', $base);
        $builder->set('dough', $pate);
        $builder->set('img_url', $img_url);

        $builder->insert();
        return $this->db->insertID();
    }

    public function updatePizza($data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data['name'])) $builder->set('name', (string) $data['name']);
        if (isset($data['base'])) $builder->set('base', (int) $data['base']);
        if (isset($data['dough'])) $builder->set('dough', (int) $data['dough']);
        if (isset($data['active'])) $builder->set('active', (bool) $data['active']);
        if (isset($data['img_url'])) $builder->set('img_url', (bool) $data['img_url']);

        if (isset($data['id'])) {
            $builder->where('id', $data['id']);
            $builder->update();
        }
    }

    public function deletePizzaDoughOrBase($data)
    {
        $builder = $this->db->table($this->table);
        if (isset($data['dough_suppr'])) $builder->set('dough', null);
        if (isset($data['base_suppr'])) $builder->set('base', null);
        if (isset($data['id'])) {
            $builder->where('id', $data['id']);
            $builder->update();
        }
    }

    public function getPizzaById($id) {
        return $this->find($id);
    }

    function getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection)

    {
        $builder = $this->builder();

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
        return $builder->get()->getResultArray();
    }

    public function getTotalPizza()
    {
        return $this->builder()->countAllResults();
    }

    public function getAllPizza()
    {
        $builder = $this->builder();
        return $builder->get()->getResultArray();
    }

    public function getPizzasWithIngredients() {
        $builder = $this->db->table($this->table);
        $builder->select('pizza.id, pizza.name, pizza.active, ib.name AS base, ip.name AS dough, pizza.price, ing.id AS ingredient_id, ing.name AS ingredient_name');
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


    public function getFilteredPizza($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('id', $searchValue);
            $builder->orlike('name', $searchValue);
            $builder->orlike('active', $searchValue);
        }
        return $builder->countAllResults();
    }
}
