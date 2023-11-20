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
        // $all = array();
        // foreach ($steps as $step) {
        //     $line_step = array();
            
        //     foreach ($categories as $cat) {
        //         $line_step = array();
        //         if ($cat['id_step'] == $step['id']) {
        //             $line_categ[] = $cat;
        //             foreach ($ingredient as $ing) {
        //                 $line_ing = array();

        //                 if ($ing['id_category'] == $cat['id']) {
        //                     $line_int[] = $ing;
        //                 }
        //                 $line_categ[] = $line_ing;
        //             }

        //         }
        //         $line_step[] = $line_categ;
        //     }
        //     $all[] = $line_step;
        // }
        if ($id_pizza == 'new') {
            $this->addBreadcrumb('Création pizza ', ['Pizza', 'edit', 'new']);
            return $this->view('/pizza/edit', ['steps' => $steps, 'categories' => $categories, 'step' => $step]);
        }
        $this->title = "Gérer la pizza";
        $pizzaModel = model('PizzaModel');
        $pizza = $pizzaModel->getPizzaById($id_pizza);
        $this->addBreadcrumb('Edition de ' . $pizza['name'], ['Pizza']);


        
        if ($pizza) {
            return $this->view('/pizza/edit', ['pizza' => $pizza]);
        }

        return $this->redirect('Pizza');
    }

    // public function getDelete()
    // {
    //     $id = $this->request->getGet('id');
    //     $pizzaModel = model('PizzaModel');        
    //     $pizzaModel->deletePizz($id);
    //     $this->success("La pizza a bien été supprimé");
    //     return $this->redirect('Pizza');
    // }
}
