<?php
namespace App\Controllers;

use App\MyClass\Commande as ClassCommande;

class Commande extends BaseController
{
    public function getIndex()
    {
        return $this->view('/commande/index');
    }

    public function postSearchCommande()
    {
        $commandeModel = model('CommandeModel');

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
        $data = $commandeModel->getPaginatedCommande($start, $length, $searchValue, $orderColumnName, $orderDirection);



        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $commandeModel->getTotalCommande();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $commandeModel->getFilteredCommande($searchValue);

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
        $commandeModel = model('CommandeModel');
        $data = $this->request->getPost();
        $commande = new ClassCommande(
            $data['id_commande'], $data['date_commande'], $data['id_client'], $data['total_commande']);

        if ($data['type'] == 'update') {
            $commandeModel->updateCommande($commande);
            $this->success("La commande a bien été modifé");
            return $this->redirect('Commande');
        } else if ($data['type'] == 'insert') {
            $commandeModel->createCommande($commande);
            $this->success("La commande a bien été crée");
            return $this->redirect('Commande');
        } else {
            $this->error('Il y a une erreur ');
            return $this->redirect('Commande');
        }
    }

    public function getDelete()
    {
        $id = $this->request->getGet('id_commande');
        $commandeModel = model('CommandeModel');
        $commandeModel->deleteCommande($id);
        $this->success("La commande a bien été supprimé");
        return $this->redirect('Commande');
    }

    public function getAjaxCommandeContent()
    {
        $idClient = $this->request->getVar('idClient');
        $idCommande = $this->request->getVar('idCommande');
        $commandeModel = model('CommandeModel');
        $result = $commandeModel->getCommandeByIdClientAndIdCommand($idClient, $idCommande);

        if ($result) {
            return $this->response->setJSON($result);
        } else {
            return $this->response->setJSON(['error' => 'Commande not found.']);
        }
    }


}