<?php

namespace App\Controllers;

use App\MyClass\Pizza as ClassPizza;

class Pizza extends BaseController
{
    public function getIndex()
    {
        return $this->view('/pizza/index');
    }


    public function getEdit($id_pizza)
    {
        $this->addBreadcrumb('Pizza', '#');
        $this->addBreadcrumb('Gestion des pizza', ['Pizza']);
        $stepModel = model('StepModel');
        $steps = $stepModel->getAllStep();
        $categoryModel = model('CategoryModel');
        $categories = $categoryModel->getAllCategory();
        $stepModel = model('StepModel');
        $step = $stepModel->getAllStep();

        $ingredientModel = model('IngredientModel');
        $pate = $ingredientModel->getIngredientByIdCategory(10);
        $base = $ingredientModel->getIngredientByIdCategory(13);
        if ($id_pizza == 'new') {
            $this->addBreadcrumb('Création pizza ', ['Pizza', 'edit', 'new']);
            return $this->view('/pizza/edit', [
                'steps' => $steps,
                'categories' => $categories,
                'step' => $step,
                'pate' => $pate,
                'base' => $base
            ]);
        }
        $pizzaModel = model('PizzaModel');
        $pizza = $pizzaModel->getPizzaById($id_pizza);
        $this->title = "Gérer la pizza";
        if ($pizza) {
            $composePizzaModel = model('ComposePizzaModel');
            $pizza_ing = $composePizzaModel->getIngredientByPizzaId($pizza['id'], true);
            $this->addBreadcrumb('Edition de ' . $pizza['name'], ['Pizza']);
            $old_price = 7;

            foreach ($pizza_ing as $ing) {
                $old_price += $ing->price;
            }
            return $this->view('/pizza/edit', [
                'steps' => $steps,
                'categories' => $categories,
                'step' => $step,
                'pate' => $pate,
                'base' => $base,
                'pizza' => $pizza,
                'pizza_ing' => $pizza_ing,
                'old_price' => $old_price,
            ]);
        }

        return $this->redirect('Pizza');
    }

    public function getAjaxPizzaContent()
    {
        $pizzaModel = model('PizzaModel');
        $composePizzaModel = model('ComposePizzaModel');
        $ingredientModel = model('IngredientModel');
        $idPizza = $this->request->getVar('idPizza');
        $pizza = $pizzaModel->getPizzaById($idPizza);
        if ($pizza) {
            $pizza_ing = $composePizzaModel->getIngredientByPizzaId($pizza['id']);
            $base = $ingredientModel->getIngredientById($pizza['base']);
            $pate = $ingredientModel->getIngredientById($pizza['dough']);
        }
        $result = array();
        $result['pizza'] = $pizza;
        $result['ingredients'] = $pizza_ing;
        $result['base'] = $base;
        $result['pate'] = $pate;
        return $this->response->setJSON($result);
    }

    public function postSearchPizza()
    {
        $pizzaModel = model('PizzaModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables

        $orderColumnIndex = $this->request->getPost('order')[0]['column'];
        $orderDirection = $this->request->getPost('order')[0]['dir'];
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'];


        // Obtenez les données triées et filtrées pour la colonne "sku_syaleo"
        $data = $pizzaModel->getPaginatedPizza($start, $length, $searchValue, $orderColumnName, $orderDirection);


        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $pizzaModel->getTotalPizza();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $pizzaModel->getFilteredPizza($searchValue);

        $result = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function postResult()
    {
        $data = $this->request->getPost();
        $pizzaModel = model('PizzaModel');
        $id = $pizzaModel->createPizza($data['name'], $data['base'], $data['dough'], $data['img_url']);
        $composePizzaModel = model('ComposePizzaModel');
        $data_ing = array();
        foreach ($data['ingredients'] as $ing) {
            $data_ing[] = ['id_pizza' => (int)$id, 'id_ingredient' => (int)$ing];
        }
        $data_ing[] = ['id_pizza' => (int)$id, 'id_ingredient' => (int)$data['base']];
        $data_ing[] = ['id_pizza' => (int)$id, 'id_ingredient' => (int)$data['dough']];
        $composePizzaModel->insertPizzaIngredients($data_ing);
        return $this->redirect('Pizza');
    }

    public function postEditedResult()
    {
        $data = $this->request->getPost();
        $pizzaModel = model('PizzaModel');
        $composePizzaModel = model('ComposePizzaModel');

        if (isset($data)) {
            $pizzaModel->updatePizza($data);
            if (isset($data['ing_suppr'])) {
                $composePizzaModel->deletePizzaIngredients($data);
            }
        }
        if (isset($data['ingredients'])) {
            $data_ing = array();
            foreach ($data['ingredients'] as $ing) {
                $data_ing[] = ['id_pizza' => (int)$data['id'], 'id_ingredient' => (int)$ing];
            }
            $composePizzaModel->insertPizzaIngredients($data_ing);
        }
        return $this->redirect('Pizza');
    }


    public function getAjaxIngredients()
    {
        $idCateg = $this->request->getVar('idCateg');
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->getIngredientByIdCategory($idCateg);

        return $this->response->setJSON($ingredients);
    }

    public function postAjaxToogleActive()
    {
        $id = $this->request->getPost('id');
        $isActive = $this->request->getPost('active');

        $pizzaModel = model('PizzaModel');
        $data = ['id' => $id, 'active' => $isActive];
        $pizzaModel->updatePizza($data);

        // Vous pouvez retourner une réponse JSON si nécessaire
        return $this->response->setJSON(['success' => true]);
    }



}
