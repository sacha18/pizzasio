<?php

namespace App\Controllers; // Déclare le namespace pour les controllers de l'application

use App\MyClass\Category as ClassCategory; // Utilise une classe Category depuis un autre namespace en la renommant en ClassCategory pour éviter les conflits

class Category extends BaseController // Déclare la classe Category qui hérite de BaseController
{
    public function getIndex()
    {
        // Méthode pour afficher la page d'index des catégories
        return $this->view('/category/index'); // Retourne la vue pour la page d'index des catégories
    }

    public function getEdit($id_category)
    {
        // Méthode pour éditer une catégorie ou en créer une nouvelle

        // Ajoute des éléments à la navigation (breadcrumb)
        $this->addBreadcrumb('Administrateur', '#');
        $this->addBreadcrumb('Gestion des catégories', ['Category']);

        if ($id_category == 'new') {
            // Si l'ID de la catégorie est 'new', on est en mode création
            $stepModel = model('StepModel'); // Charge le modèle StepModel
            $steps = $stepModel->getAllStep(); // Récupère toutes les étapes
            $this->addBreadcrumb('Création catégorie', ['Category', 'edit', 'new']);
            return $this->view('/category/edit', ['steps' => $steps]); // Retourne la vue d'édition avec les étapes
        }

        $this->title = "Gérer la catégorie"; // Définit le titre de la page
        $categoryModel = model('CategoryModel'); // Charge le modèle CategoryModel
        $cat = $categoryModel->getCategoryById($id_category); // Récupère la catégorie par ID

        // Ajoute la catégorie actuelle à la navigation
        $this->addBreadcrumb('Edition de ' . $cat['name'], ['Category']);

        if ($cat) {
            // Si la catégorie existe, retourne la vue d'édition avec les données de la catégorie
            return $this->view('/category/edit', ['cat' => $cat]);
        }

        // Si la catégorie n'existe pas, affiche un message d'erreur et redirige
        $this->error("La catégorie n'existe pas.");
        return $this->redirect('Category');
    }

    public function postSearchCategory()
    {
        // Méthode pour rechercher des catégories

        $categoryModel = model('CategoryModel'); // Charge le modèle CategoryModel

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
        $data = $categoryModel->getPaginatedCategory($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Récupère le nombre total de catégories sans filtre
        $totalRecords = $categoryModel->getTotalCategory();

        // Récupère le nombre total de catégories filtrées
        $filteredRecords = $categoryModel->getFilteredCategory($searchValue);

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
        // Méthode pour sauvegarder une catégorie (création ou mise à jour)

        $categoryModel = model('CategoryModel'); // Charge le modèle CategoryModel
        $data = $this->request->getPost(); // Récupère les données POST
        $id = (isset($data['id'])) ? $data['id'] : null; // Récupère l'ID de la catégorie ou null
        $id_step = (isset($data['id_step'])) ? $data['id_step'] : 3; // Récupère l'ID de l'étape ou 3 par défaut

        // Crée une nouvelle instance de ClassCategory avec les données récupérées
        $category = new ClassCategory($id, $data['name'], $data['icon'], $id_step);

        if ($data['type'] == 'update') {
            // Si le type est 'update', met à jour la catégorie
            $categoryModel->updateCategory($category);
            $this->success("La catégorie a bien été modifiée");
            return $this->redirect('Category');
        } else if ($data['type'] == 'insert') {
            // Si le type est 'insert', crée une nouvelle catégorie
            $categoryModel->createCategory($category);
            $this->success("La catégorie a bien été créée");
            return $this->redirect('Category');
        } else {
            // Si le type n'est ni 'update' ni 'insert', affiche une erreur
            $this->error('Il y a une erreur');
            return $this->redirect('Category');
        }
    }

    public function getDelete()
    {
        // Méthode pour supprimer une catégorie

        $id = $this->request->getGet('id'); // Récupère l'ID de la catégorie à supprimer
        $categoryModel = model('CategoryModel'); // Charge le modèle CategoryModel
        $categoryModel->deleteCategory($id); // Supprime la catégorie par ID
        $this->success("La catégorie a bien été supprimée"); // Affiche un message de succès
        return $this->redirect('Category'); // Redirige vers la liste des catégories
    }
}
