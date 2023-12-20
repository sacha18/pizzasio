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

    public function getResult()
    {

        $composePizzaModel = model('ComposePizzaModel');

        $a = $composePizzaModel->getIngredientByPizzaId(1);
        return $this->view('/dev/result', ['a' => $a]);
    }

    public function postResult()

    {        
        $composePizzaModel = model('ComposePizzaModel');

        $oldIngredients = $composePizzaModel->getIngredientByPizzaId($_POST['id']);
                
        return $this->view('/dev/result', ['a' => $_POST, 'old' => $oldIngredients]);
    }

    public function getAjaxIngredients()
    {
        $idCateg = $this->request->getVar('idCateg');
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getIngredientByIdCategory($idCateg);

        return $this->response->setJSON($ingredients);
    }
}
