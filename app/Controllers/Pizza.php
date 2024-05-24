<?php

namespace App\Controllers; // Déclare le namespace pour les controllers de l'application

use App\MyClass\Pizza as ClassPizza; // Utilise la classe Pizza depuis le namespace App\MyClass

class Pizza extends BaseController // Déclare la classe Pizza qui hérite de BaseController
{
    public function getIndex()
    {
        // Méthode pour afficher la page principale de gestion des pizzas
        return $this->view('/pizza/index'); // Retourne la vue pour la page index des pizzas
    }

    public function getEdit($id_pizza)
    {
        // Méthode pour afficher la page d'édition ou de création d'une pizza

        $this->addBreadcrumb('Pizza', '#'); // Ajoute un élément au breadcrumb
        $this->addBreadcrumb('Gestion des pizza', ['Pizza']); // Ajoute un élément au breadcrumb

        $stepModel = model('StepModel'); // Charge le modèle StepModel
        $steps = $stepModel->getAllStep(); // Récupère toutes les étapes

        $categoryModel = model('CategoryModel'); // Charge le modèle CategoryModel
        $categories = $categoryModel->getAllCategory(); // Récupère toutes les catégories

        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel
        $pate = $ingredientModel->getIngredientByIdCategory(10); // Récupère les ingrédients de la catégorie pâte
        $base = $ingredientModel->getIngredientByIdCategory(13); // Récupère les ingrédients de la catégorie base

        if ($id_pizza == 'new') {
            // Si l'ID de la pizza est 'new', affiche la page de création de pizza
            $this->addBreadcrumb('Création pizza ', ['Pizza', 'edit', 'new']);
            return $this->view('/pizza/edit', [
                'steps' => $steps,
                'categories' => $categories,
                'step' => $steps,
                'pate' => $pate,
                'base' => $base
            ]);
        }

        $pizzaModel = model('PizzaModel'); // Charge le modèle PizzaModel
        $pizza = $pizzaModel->getPizzaById($id_pizza); // Récupère les données de la pizza par ID
        $this->title = "Gérer la pizza"; // Définit le titre de la page

        if ($pizza) {
            // Si la pizza existe, affiche la page d'édition de la pizza
            $composePizzaModel = model('ComposePizzaModel'); // Charge le modèle ComposePizzaModel
            $pizza_ing = $composePizzaModel->getIngredientByPizzaId($pizza['id'], true); // Récupère les ingrédients de la pizza

            $this->addBreadcrumb('Edition de ' . $pizza['name'], ['Pizza']); // Ajoute un élément au breadcrumb
            $old_price = 7;

            // Calcule le prix ancien de la pizza en ajoutant le prix des ingrédients
            foreach ($pizza_ing as $ing) {
                $old_price += $ing->price;
            }

            return $this->view('/pizza/edit', [
                'steps' => $steps,
                'categories' => $categories,
                'step' => $steps,
                'pate' => $pate,
                'base' => $base,
                'pizza' => $pizza,
                'pizza_ing' => $pizza_ing,
                'old_price' => $old_price,
            ]);
        }

        return $this->redirect('Pizza'); // Redirige vers la page principale de gestion des pizzas si la pizza n'existe pas
    }

    public function getAjaxPizzaContent()
    {
        // Méthode pour obtenir le contenu d'une pizza via une requête AJAX

        $pizzaModel = model('PizzaModel'); // Charge le modèle PizzaModel
        $composePizzaModel = model('ComposePizzaModel'); // Charge le modèle ComposePizzaModel
        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel

        $idPizza = $this->request->getVar('idPizza'); // Récupère l'ID de la pizza depuis la requête
        $pizza = $pizzaModel->getPizzaById($idPizza); // Récupère les données de la pizza par ID

        if ($pizza) {
            // Si la pizza existe, récupère les ingrédients, la base et la pâte
            $pizza_ing = $composePizzaModel->getIngredientByPizzaId($pizza['id']);
            $base = $ingredientModel->getIngredientById($pizza['base']);
            $pate = $ingredientModel->getIngredientById($pizza['dough']);
        }

        // Crée un tableau de résultats à retourner en JSON
        $result = array();
        $result['pizza'] = $pizza;
        $result['ingredients'] = $pizza_ing;
        $result['base'] = $base;
        $result['pate'] = $pate;

        return $this->response->setJSON($result); // Retourne les résultats en JSON
    }

    public function postSearchPizza()
    {
        // Méthode pour gérer les recherches de pizzas via DataTables

        $pizzaModel = model('PizzaModel'); // Charge le modèle PizzaModel

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Obtenez les données triées et filtrées pour la colonne "sku_syaleo"
        $data = $pizzaModel->getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $pizzaModel->getTotalPizza();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $pizzaModel->getFilteredPizza($searchValue);

        // Crée un tableau de résultats à retourner en JSON
        $result = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ];
        return $this->response->setJSON($result); // Retourne les résultats en JSON
    }

    public function postResult()
    {
        // Méthode pour gérer l'ajout d'une nouvelle pizza

        $data = $this->request->getPost(); // Récupère les données du formulaire POST
        $pizzaModel = model('PizzaModel'); // Charge le modèle PizzaModel

        // Crée une nouvelle pizza et récupère son ID
        $id = $pizzaModel->createPizza($data['name'], $data['base'], $data['dough'], $data['img_url']);

        $composePizzaModel = model('ComposePizzaModel'); // Charge le modèle ComposePizzaModel
        $data_ing = array();

        // Prépare les données des ingrédients de la pizza
        foreach ($data['ingredients'] as $ing) {
            $data_ing[] = ['id_pizza' => (int)$id, 'id_ingredient' => (int)$ing];
        }
        $data_ing[] = ['id_pizza' => (int)$id, 'id_ingredient' => (int)$data['base']];
        $data_ing[] = ['id_pizza' => (int)$id, 'id_ingredient' => (int)$data['dough']];

        // Insère les ingrédients de la pizza dans la base de données
        $composePizzaModel->insertPizzaIngredients($data_ing);

        return $this->redirect('Pizza'); // Redirige vers la page principale de gestion des pizzas
    }

    public function postEditedResult()
    {
        // Méthode pour gérer la mise à jour des pizzas existantes

        $data = $this->request->getPost(); // Récupère les données du formulaire POST
        $pizzaModel = model('PizzaModel'); // Charge le modèle PizzaModel
        $composePizzaModel = model('ComposePizzaModel'); // Charge le modèle ComposePizzaModel

        if (isset($data)) {
            // Met à jour les informations de la pizza
            $pizzaModel->updatePizza($data);

            if (isset($data['ing_suppr'])) {
                // Supprime les ingrédients spécifiés de la pizza
                $composePizzaModel->deletePizzaIngredients($data);
            }
        }

        if (isset($data['ingredients'])) {
            // Ajoute les nouveaux ingrédients à la pizza
            $data_ing = array();
            foreach ($data['ingredients'] as $ing) {
                $data_ing[] = ['id_pizza' => (int)$data['id'], 'id_ingredient' => (int)$ing];
            }
            $composePizzaModel->insertPizzaIngredients($data_ing);
        }

        return $this->redirect('Pizza'); // Redirige vers la page principale de gestion des pizzas
    }

    public function getAjaxIngredients()
    {
        // Méthode pour obtenir les ingrédients par catégorie via une requête AJAX

        $idCateg = $this->request->getVar('idCateg'); // Récupère l'ID de la catégorie depuis la requête
        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel
        $ingredients = $ingredientModel->getIngredientByIdCategory($idCateg); // Récupère les ingrédients par catégorie

        return $this->response->setJSON($ingredients); // Retourne les résultats en JSON
    }

    public function postAjaxToogleActive()
    {
        // Méthode pour activer/désactiver une pizza via une requête AJAX

        $id = $this->request->getPost('id'); // Récupère l'ID de la pizza depuis la requête POST
        $isActive = $this->request->getPost('active'); // Récupère le statut actif depuis la requête POST

        $pizzaModel = model('PizzaModel'); // Charge le modèle PizzaModel
        $data = ['id' => $id, 'active' => $isActive]; // Prépare les données pour la mise à jour
        $pizzaModel->updatePizza($data); // Met à jour le statut actif de la pizza

        return $this->response->setJSON(['success' => true]); // Retourne une réponse JSON indiquant le succès de l'opération
    }
}
