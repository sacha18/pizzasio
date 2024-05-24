<?php

namespace App\Controllers; // Déclare le namespace pour les controllers de l'application

use App\MyClass\Step as ClassStep; // Utilise la classe Step depuis le namespace App\MyClass

class Step extends BaseController // Déclare la classe Step qui hérite de BaseController
{
    public function getIndex()
    {
        // Méthode pour afficher la page principale de gestion des étapes
        return $this->view('/step/index'); // Retourne la vue pour la page index des étapes
    }

    public function getEdit($id_step)
    {
        // Méthode pour afficher la page d'édition ou de création d'une étape

        $this->addBreadcrumb('Administrateur', '#'); // Ajoute un élément au breadcrumb
        $this->addBreadcrumb('Gestion des étapes', ['Step']); // Ajoute un élément au breadcrumb

        if ($id_step == 'new') {
            // Si l'ID de l'étape est 'new', affiche la page de création d'étape
            $this->addBreadcrumb('Création etape ', ['Step', 'edit', 'new']);
            return $this->view('/step/edit');
        }

        $this->title = "Gérer l'étape"; // Définit le titre de la page
        $stepModel = model('StepModel'); // Charge le modèle StepModel
        $step = $stepModel->getStepById($id_step); // Récupère les données de l'étape par ID
        $this->addBreadcrumb('Edition de ' . $step['name'], ['Step']); // Ajoute un élément au breadcrumb

        if ($step) {
            // Si l'étape existe, affiche la page d'édition de l'étape
            return $this->view('/step/edit', ['step' => $step]);
        }

        // Si l'étape n'existe pas, affiche un message d'erreur et redirige
        $this->error("L'étape n'existe pas.");
        return $this->redirect('Step');
    }

    public function postSearchStep()
    {
        // Méthode pour gérer les recherches d'étapes via DataTables

        $stepModel = model('StepModel'); // Charge le modèle StepModel

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Obtenez les données triées et filtrées pour la colonne spécifiée
        $data = $stepModel->getPaginatedStep($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $stepModel->getTotalStep();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $stepModel->getFilteredStep($searchValue);

        // Crée un tableau de résultats à retourner en JSON
        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];

        return $this->response->setJSON($result); // Retourne les résultats en JSON
    }

    public function postSave()
    {
        // Méthode pour sauvegarder une nouvelle étape ou mettre à jour une étape existante

        $stepModel = model('StepModel'); // Charge le modèle StepModel
        $data = $this->request->getPost(); // Récupère les données du formulaire POST
        $id = isset($data['id']) ? $data['id'] : null; // Récupère l'ID de l'étape s'il existe

        $step = new ClassStep($id, $data['name'], $data['order']); // Crée une instance de la classe Step

        if ($data['type'] == 'update') {
            // Si le type est 'update', met à jour l'étape
            $stepModel->updateStep($step);
            $this->success("L'étape a bien été modifée");
            return $this->redirect('Step');
        } elseif ($data['type'] == 'insert') {
            // Si le type est 'insert', crée une nouvelle étape
            $stepModel->createStep($step);
            $this->success("L'étape a bien été créée");
            return $this->redirect('Step');
        } else {
            // Si le type n'est pas reconnu, affiche une erreur
            $this->error('Il y a une erreur ');
            return $this->redirect('Step');
        }
    }

    public function getDelete()
    {
        // Méthode pour supprimer une étape

        $id = $this->request->getGet('id'); // Récupère l'ID de l'étape depuis la requête GET
        $stepModel = model('StepModel'); // Charge le modèle StepModel
        $stepModel->deleteStep($id); // Supprime l'étape par ID

        $this->success("L'étape a bien été supprimée"); // Affiche un message de succès
        return $this->redirect('Step'); // Redirige vers la page principale de gestion des étapes
    }
}
