<?php

namespace App\Controllers;

use App\MyClass\Category as ClassCategory;

class Category extends BaseController
{
    public function getIndex()
    {
        
        return $this->view('/category/index');
    }


    public function getEdit($id_category)
    {
        $this->addBreadcrumb('Administrateur', '#');
        $this->addBreadcrumb('Gestion des catégories', ['Category']);
        if ($id_category == 'new') {
            $this->addBreadcrumb('Création catégorie ', ['Category', 'edit', 'new']);
            return $this->view('/category/edit');
        }
        $this->title = "Gérer l'catégorie";
        $categoryModel = model('CategoryModel');        
        $cat = $categoryModel->getCategoryById($id_category);
        $this->addBreadcrumb('Edition de ' . $cat['name'], ['Category']);
        if ($cat) {
            return $this->view('/category/edit', ['cat' => $cat]);
        }
        $this->error("La catégorie n'existe pas.");
        return $this->redirect('Category');
    }

    public function postSearchCategory()
    {
        $categoryModel = model('categoryModel');

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
        $data = $categoryModel->getPaginatedCategory($start, $length, $searchValue, $orderColumnName, $orderDirection);



        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $categoryModel->getTotalCategory();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $categoryModel->getFilteredCategory($searchValue);

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
        $categoryModel = model('categoryModel');
        $data = $this->request->getPost();
        $id = (isset($data['id'])) ? $data['id'] : null;
        $id_step = (isset($data['id_step'])) ? $data['id_step'] : 3;



        $category = new ClassCategory($id, $data['name'], $data['icon'], $id_step);
        if ($data['type'] == 'update') {
            $categoryModel->updateCategory($category);
            $this->success("La catégorie a bien été modifé");
            return $this->redirect('Category');
        } else if ($data['type'] == 'insert') {
            $categoryModel->createCategory($category);
            $this->success("La catégorie a bien été crée");
            return $this->redirect('Category');
        } else {
            $this->error('Il y a une erreur ');
            return $this->redirect('Category');
        }
    }
    public function getDelete()
    {
        $id = $this->request->getGet('id');
        $categoryModel = model('categoryModel');
        $categoryModel->deleteCategory($id);
        $this->success("La catégorie a bien été supprimé");
        return $this->redirect('Category');
    }
}
