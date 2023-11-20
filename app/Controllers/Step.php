<?php

namespace App\Controllers;

use App\MyClass\Step as ClassStep;

class Step extends BaseController
{
    public function getIndex()
    {
        return $this->view('/step/index');
    }


    public function getEdit($id_step)
    {
        $this->addBreadcrumb('Administrateur', '#');
        $this->addBreadcrumb('Gestion des étapes', ['Step']);
        if ($id_step == 'new') {
            $this->addBreadcrumb('Création etape ', ['Step', 'edit', 'new']);
            return $this->view('/step/edit');
        }
        $this->title = "Gérer l'étape";
        $stepModel = model('StepModel');        
        $step = $stepModel->getStepById($id_step);
        $this->addBreadcrumb('Edition de ' . $step['name'], ['Step']);
        if ($step) {
            return $this->view('/step/edit', ['step' => $step]);
        }
        $this->error("L'étape n'existe pas.");
        return $this->redirect('Step');
    }

    public function postSearchStep()
    {
        $stepModel = model('stepModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables

        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];



        // Obtenez les données triées et filtrées pour la colonne "sku_syaleo"
        $data = $stepModel->getPaginatedStep($start, $length, $searchValue, $orderColumnName, $orderDirection);



        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $stepModel->getTotalStep();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $stepModel->getFilteredStep($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function postSave()
    {
        $stepModel = model('StepModel');
        $data = $this->request->getPost();
        $id = (isset($data['id'])) ? $data['id'] : null;

        $step = new ClassStep($id, $data['name'], $data['order']);
        if ($data['type'] == 'update') {
            $stepModel->updateStep($step);
            $this->success("L'étape a bien été modifé");
            return $this->redirect('Step');
        } else if ($data['type'] == 'insert') {
            $stepModel->createStep($step);
            $this->success("L'étape a bien été crée");
            return $this->redirect('Step');
        } else {
            $this->error('Il y a une erreur ');
            return $this->redirect('Step');
        }
    }
    public function getDelete()
    {
        $id = $this->request->getGet('id');
        $ingredientModel = model('StepModel');
        $ingredientModel->deleteStep($id);
        $this->success("L'étape a bien été supprimé");
        return $this->redirect('Step');
    }
}
