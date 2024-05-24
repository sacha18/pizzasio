<?php

namespace App\Controllers; // Déclare le namespace pour les controllers de l'application

use App\MyClass\Commande as ClassCommande; // Utilise une classe Commande depuis un autre namespace en la renommant en ClassCommande pour éviter les conflits

class Commande extends BaseController // Déclare la classe Commande qui hérite de BaseController
{
    public function getIndex()
    {
        // Méthode pour afficher la page d'index des commandes
        return $this->view('/commande/index'); // Retourne la vue pour la page d'index des commandes
    }

    public function postSearchCommande()
    {
        // Méthode pour rechercher des commandes

        $commandeModel = model('CommandeModel'); // Charge le modèle CommandeModel

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
        $data = $commandeModel->getPaginatedCommande($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Récupère le nombre total de commandes sans filtre
        $totalRecords = $commandeModel->getTotalCommande();

        // Récupère le nombre total de commandes filtrées
        $filteredRecords = $commandeModel->getFilteredCommande($searchValue);

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
        // Méthode pour sauvegarder une commande (création ou mise à jour)

        $commandeModel = model('CommandeModel'); // Charge le modèle CommandeModel
        $data = $this->request->getPost(); // Récupère les données POST

        // Crée une nouvelle instance de ClassCommande avec les données récupérées
        $commande = new ClassCommande(
            $data['id_commande'], $data['date_commande'], $data['id_client'], $data['total_commande']
        );

        if ($data['type'] == 'update') {
            // Si le type est 'update', met à jour la commande
            $commandeModel->updateCommande($commande);
            $this->success("La commande a bien été modifiée");
            return $this->redirect('Commande');
        } else if ($data['type'] == 'insert') {
            // Si le type est 'insert', crée une nouvelle commande
            $commandeModel->createCommande($commande);
            $this->success("La commande a bien été créée");
            return $this->redirect('Commande');
        } else {
            // Si le type n'est ni 'update' ni 'insert', affiche une erreur
            $this->error('Il y a une erreur');
            return $this->redirect('Commande');
        }
    }

    public function getDelete()
    {
        // Méthode pour supprimer une commande

        $id = $this->request->getGet('id_commande'); // Récupère l'ID de la commande à supprimer
        $commandeModel = model('CommandeModel'); // Charge le modèle CommandeModel
        $commandeModel->deleteCommande($id); // Supprime la commande par ID
        $this->success("La commande a bien été supprimée"); // Affiche un message de succès
        return $this->redirect('Commande'); // Redirige vers la liste des commandes
    }

    public function getAjaxCommandeContent()
    {
        // Méthode pour obtenir le contenu d'une commande via AJAX

        $idClient = $this->request->getVar('idClient'); // Récupère l'ID du client
        $idCommande = $this->request->getVar('idCommande'); // Récupère l'ID de la commande
        $commandeModel = model('CommandeModel'); // Charge le modèle CommandeModel
        $result = $commandeModel->getCommandeByIdClientAndIdCommand($idClient, $idCommande); // Récupère la commande par ID client et ID commande

        if ($result) {
            // Si la commande existe, retourne les données de la commande en JSON
            return $this->response->setJSON($result);
        } else {
            // Si la commande n'existe pas, retourne un message d'erreur en JSON
            return $this->response->setJSON(['error' => 'Commande not found.']);
        }
    }
}
