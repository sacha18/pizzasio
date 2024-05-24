<?php

namespace App\Controllers;

use App\MyClass\User;

class Users extends BaseController
{
    // Propriété pour définir le menu actif
    protected $menu = 'users';

    // Méthode pour afficher la liste des utilisateurs
    public function getIndex()
    {
        $um = model('UserModel');
        return $this->view('/user/users', ['allUsers' => $um->getAllUser()]);
    }

    // Méthode pour afficher le formulaire d'édition d'un utilisateur
    public function getEdit($id_user)
    {
        // Ajout des éléments au fil d'ariane
        $this->addBreadcrumb('Administrateur', '#');
        $this->addBreadcrumb('Gestion des utilisateurs', ['Users']);

        // Si l'ID de l'utilisateur est "new", c'est une création, sinon c'est une édition
        if ($id_user == 'new') {
            $this->addBreadcrumb('Création utilisateur ', ['Users', 'edit', 'new']);
            return $this->view('/user/edit');
        }

        // Définition du titre de la page
        $this->title = "Gérer l'utilisateur";

        // Récupération des données de l'utilisateur
        $um = model('UserModel');
        $u = $um->getUserById($id_user);

        // Ajout de l'élément au fil d'ariane
        $this->addBreadcrumb('Edition de ' . $u['username'], ['Users']);

        // Si l'utilisateur existe, affichage du formulaire d'édition
        if ($u) {
            return $this->view('/user/edit', ['u' => $u]);
        }

        // Redirection si l'utilisateur n'existe pas
        $this->error("L'utilisateur n'existe pas.");
        return $this->redirect('Users');
    }

    // Méthode pour effectuer une recherche d'utilisateurs
    public function postSearchUser()
    {
        $userModel = model('UserModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];
        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];

        // Obtention des données triées et filtrées
        $data = $userModel->getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtention du nombre total d'enregistrements
        $totalRecords = $userModel->getTotalUser();

        // Obtention du nombre total d'enregistrements filtrés
        $filteredRecords = $userModel->getFilteredUser($searchValue);

        // Construction du résultat à renvoyer au format JSON
        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    // Méthode pour sauvegarder les modifications apportées à un utilisateur
    public function postSave()
    {
        $userModel = model('UserModel');
        $data = $this->request->getPost();
        $id = (isset($data['id'])) ? $data['id'] : null;
        $admin = (isset($data['admin'])) ? true : false;
        $active = (isset($data['active'])) ? true : false;

        $user = new User($id, $data['username'], $data['email'], null, $admin, $active, 0, null);
        if (isset($data['password'])) $user->setPassword($data['password']);

        // Vérification du type d'action : mise à jour ou création
        if ($data['type'] == 'update') {
            $userModel->updateUser($user);
            $this->success("L'utilisateur a bien été modifé");
            return $this->redirect('Users');
        } else if ($data['type'] == 'insert') {
            $userModel->createUser($user);
            $this->success("L'utilisateur a bien été crée");
            return $this->redirect('Users');
        } else {
            $this->error('Il y a une erreur ');
            return $this->redirect('Users');
        }
    }

    // Méthode pour supprimer un utilisateur
    public function getDelete()
    {
        $id = $this->request->getGet('id');
        $userModel = model('UserModel');
        $userModel->deleteUser($id);
        $this->success("L'utilisateur a bien été supprimé");
        return $this->redirect('Users');
    }
}
