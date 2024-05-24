<?php

namespace App\Controllers; // Déclare le namespace pour les controllers de l'application

use App\MyClass\Ingredient as ClassIngredient; // Utilise une classe Ingredient depuis un autre namespace en la renommant en ClassIngredient pour éviter les conflits

class Ingredient extends BaseController // Déclare la classe Ingredient qui hérite de BaseController
{
    public function getIndex()
    {
        // Méthode pour afficher la page d'index des ingrédients
        return $this->view('/ingredient/index'); // Retourne la vue pour la page d'index des ingrédients
    }

    public function getEdit($id_ingredient)
    {
        // Méthode pour éditer un ingrédient ou en créer un nouveau

        // Ajoute des éléments à la navigation (breadcrumb)
        $this->addBreadcrumb('Administrateur', '#');
        $this->addBreadcrumb('Gestion des ingredients', ['Ingredient']);
        $categoryModel = model('CategoryModel'); // Charge le modèle CategoryModel

        if ($id_ingredient == 'new') {
            // Si l'ID de l'ingrédient est 'new', on est en mode création
            $this->addBreadcrumb('Création ingredient', ['Ingredient', 'edit', 'new']);
            return $this->view('/ingredient/edit', ['categ' => $categoryModel->getAllCategory()]); // Retourne la vue d'édition avec toutes les catégories
        }

        $this->title = "Gérer l'ingrédient"; // Définit le titre de la page
        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel
        $ing = $ingredientModel->getIngredientById($id_ingredient); // Récupère l'ingrédient par ID

        // Ajoute l'ingrédient actuel à la navigation
        $this->addBreadcrumb('Edition de ' . $ing['name'], ['Ingredient']);

        if ($ing) {
            // Si l'ingrédient existe, retourne la vue d'édition avec les données de l'ingrédient et toutes les catégories
            return $this->view('/ingredient/edit', ['ing' => $ing, 'categ' => $categoryModel->getAllCategory()]);
        }

        // Si l'ingrédient n'existe pas, affiche un message d'erreur et redirige
        $this->error("L'ingrédient n'existe pas.");
        return $this->redirect('Ingredient');
    }

    public function postSearchIngredient()
    {
        // Méthode pour rechercher des ingrédients

        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel

        // Récupère les paramètres de pagination et de recherche envoyés par DataTables
        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Récupère les informations de tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Récupère les données triées et filtrées
        $data = $ingredientModel->getPaginatedIngredient($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Récupère le nombre total d'ingrédients sans filtre
        $totalRecords = $ingredientModel->getTotalIngredient();

        // Récupère le nombre total d'ingrédients filtrés
        $filteredRecords = $ingredientModel->getFilteredIngredient($searchValue);

        // Prépare le résultat à retourner en JSON
        $result = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ];
        return $this->response->setJSON($result); // Retourne le résultat en JSON
    }

    public function postSave()
    {
        // Méthode pour sauvegarder un ingrédient (création ou mise à jour)

        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel
        $data = $this->request->getPost(); // Récupère les données POST
        $id = (isset($data['id'])) ? $data['id'] : null; // Récupère l'ID de l'ingrédient ou null
        $bio = (isset($data['bio'])) ? true : false; // Vérifie si l'ingrédient est bio
        $vegan = (isset($data['vegan'])) ? true : false; // Vérifie si l'ingrédient est vegan
        $id_category = (isset($data['id_category'])) ? $data['id_category'] : 1; // Récupère l'ID de la catégorie ou 1 par défaut

        // Crée une nouvelle instance de ClassIngredient avec les données récupérées
        $ingredient = new ClassIngredient($id, $data['name'], $data['stock'], $data['price'], $bio, $vegan, $id_category);

        if ($data['type'] == 'update') {
            // Si le type est 'update', met à jour l'ingrédient
            $ingredientModel->updateIngredient($ingredient);
            $this->success("L'ingrédient a bien été modifié");
            return $this->redirect('Ingredient');
        } else if ($data['type'] == 'insert') {
            // Si le type est 'insert', crée un nouvel ingrédient
            $ingredientModel->createIngredient($ingredient);
            $this->success("L'ingrédient a bien été créé");
            return $this->redirect('Ingredient');
        } else {
            // Si le type n'est ni 'update' ni 'insert', affiche une erreur
            $this->error('Il y a une erreur');
            return $this->redirect('Ingredient');
        }
    }

    public function getDelete()
    {
        // Méthode pour supprimer un ingrédient

        $id = $this->request->getGet('id'); // Récupère l'ID de l'ingrédient à supprimer
        $ingredientModel = model('IngredientModel'); // Charge le modèle IngredientModel
        $ingredientModel->deleteIngredient($id); // Supprime l'ingrédient par ID
        $this->success("L'ingrédient a bien été supprimé"); // Affiche un message de succès
        return $this->redirect('Ingredient'); // Redirige vers la liste des ingrédients
    }
}
