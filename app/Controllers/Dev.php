<?php

namespace App\Controllers;
class Dev extends BaseController
{
    public function getIndex()
    {
        $categoryModel = model('categoryModel');
        $categories = $categoryModel->getCategoryByIdStep(5);
        return $this->view('/dev/index', ['categories' => $categories]);
    }

    public function postResult()
    {
        $data = $this->request->getPost();
        return $this->view('/dev/result', ['data' => $data]);
    }

    public function getAjaxIngredients() {
        $idCateg = $this->request->getVar('idCateg');
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getIngredientByIdCategory($idCateg);

        return $this->response->setJSON($ingredients);
    }
}

