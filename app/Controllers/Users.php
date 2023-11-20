<?php

namespace App\Controllers;

use App\MyClass\User;

class Users extends BaseController
{
    protected $menu = 'users';

    public function getIndex()
    {
        $um = model('UserModel');
        return $this->view('/user/users', ['allUsers' => $um->getAllUser()]);
    }

    public function getEdit($id_user)
    {
        $this->addBreadcrumb('Administrateur', '#');
        $this->addBreadcrumb('Gestion des utilisateurs', ['Users']);
        if ($id_user == 'new') {
            $this->addBreadcrumb('Création utilisateur ', ['Users', 'edit', 'new']);
            return $this->view('/user/edit');
        }
        $this->title = "Gérer l'utilisateur";
        $um = model('UserModel');
        $u = $um->getUserById($id_user);
        $this->addBreadcrumb('Edition de ' . $u['username'], ['Users']);
        if ($u) {
            return $this->view('/user/edit', ['u' => $u]);
        }
        $this->error("L'utilisateur n'existe pas.");
        return $this->redirect('Users');
    }

    public function postSearchUser()
    {
        $userModel = model('UserModel');

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
        $data = $userModel->getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection);



        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $userModel->getTotalUser();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $userModel->getFilteredUser($searchValue);

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
        $userModel = model('UserModel');
        $data = $this->request->getPost();
        $id = (isset($data['id'])) ? $data['id'] : null;
        $admin = (isset($data['admin'])) ? true : false;
        $active = (isset($data['active'])) ? true : false;

        $user = new User($id, $data['username'], $data['email'], null, $admin, $active, 0, null);
        if (isset($data['password'])) $user->setPassword($data['password']);

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
    public function getDelete()
    {
        $id = $this->request->getGet('id');
        $userModel = model('UserModel');
        $userModel->deleteUser($id);
        $this->success("L'utilisateur a bien été supprimé");
        return $this->redirect('Users');
    }
}
