<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PizzaSeeder extends Seeder
{
    public function run()
    {

        for ($i = 0; $i < 10; $i++) {

            $pizzaData = $this->generatePizza();
            $this->db->table('pizza')->insert($pizzaData);
            $numIngredients = rand(2, 5); 
            $lastPizzaId = $this->db->insertID();
            for ($j = 0; $j < $numIngredients; $j++) {
                $this->db->table('compose_pizza')->insert($this->generateIngredient($lastPizzaId));
            }        }
    }

    private function generatePizza(): array
    {
        $ingredientModel = model('IngredientModel');
        $pate = $ingredientModel->getIngredientByIdCategory(10);
        $base = $ingredientModel->getIngredientByIdCategory(13);

        $allBase = [];
        for ($j = 0; $j < sizeof($base); $j++) {
            array_push($allBase, $base[$j]['id']);
        }
        $faker = Factory::create();

        // Select a random base and dough
        $allPate = [];
        for ($j = 0; $j < sizeof($pate); $j++) {
            array_push($allPate, $pate[$j]['id']);
        }

        $pizzaNames = [
            'Margherita',
            'Provençale',
            'Quatre Saisons',
            'Reine',
            'Napolitaine',
            'Carbonara',
            'Végétarienne',
            '4 Fromages',
            'Hawaïenne',
            'Saumon et Crème Fraîche',
            // Ajoutez d'autres noms de pizzas au besoin
        ];
        

        // Generate a pizza with a name, base, dough, and price
        return [
            'name' => $faker->randomElement($pizzaNames),
            'active' => 1,
            'base' => $faker->randomElement($allBase),
            'dough' => $faker->randomElement($allPate),
        ];
    }

    private function generateIngredient($i): array
    {
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getIngredientByIdCategory(12);

        $allIngredients = [];
        for ($j = 0; $j < sizeof($ingredients); $j++) {
            array_push($allIngredients, $ingredients[$j]['id']);
        }
        $faker = Factory::create();
        return [
            'id_pizza' => $i,
            'id_ingredient' => $faker->randomElement($allIngredients),
        ];
    }
}
