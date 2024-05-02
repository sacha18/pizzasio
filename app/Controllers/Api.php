<?php

namespace App\Controllers;
use App\MyClass\User;


class Api extends BaseController
{
    public function getIndex()
    {
        return $this->view('api\index');
    }

    public $acl = false;
    protected $start_session = false;
    public function getAllPizza()
    {
        $pizzaModel = model('PizzaModel');
        $allPiza = $pizzaModel->getAllPizza();
        return $this->json($allPiza);
    }

    public function postMakeCommande()
    {
        $requestBody = $this->request->getBody();

        $data = json_decode($requestBody, true);

        if (isset($data['id_client'])) {
            $id_client = $data['id_client'];

            $commandeModel = model('CommandeModel');
            $id_commande = $commandeModel->insertCommande(['id_client' => $id_client]);
        } else {
            return $this->json(['error' => 'id_client is missing in request body'], 400);
        }

        if (isset($data['pizza'])) {
            $commandeModel = model('CommandeModel');
            $commandeModel->insertLigneCommande($id_commande, $data['pizza']);
            return $this->json(['success' => 'La commande ' . $id_commande . ' a bien été effectuée.'], 200);
        } else {
            return $this->json(['error' => 'id_client is missing in request body'], 400);
        }
    }

    public function getCommande()
    {
        $idUrl = (int)$this->request->getVar('id');

        if ($idUrl != null) {
            $commandeModel = model('CommandeModel');
            $commande = $commandeModel->getCommandeByIdClient($idUrl);
            if ($commande != null) {
                return $this->json($commande);
            } else {
                return $this->json(["error" => "Commande not found"], 500);
            }
        } else {
            return $this->json(["error" => "ID not found"], 500);
        }
    }


    public function getPizza()
    {
        $idUrl = (int)$this->request->getVar('id');

        if ($idUrl != null) {
            $pizzaModel = model('PizzaModel');
            $pizza = $pizzaModel->getPizzaById($idUrl);
            if ($pizza != null) {
                return $this->json($pizza);
            } else {
                return $this->json(["error" => "Pizza not found"], 500);
            }
        } else {
            return $this->json(["error" => "ID not found"], 500);
        }
    }

    public function getLogin() {

        if (($email = $this->request->getVar('email')) !== null
            && ($pass = $this->request->getVar('password')) !== null) {
            $userModel = model('UserModel');
            $candidateData = $userModel->getUserByMail($email);

            if ($candidateData) {
                $candidate = new User(
                    $candidateData['id'],
                    $candidateData['username'],
                    $candidateData['email'],
                    $candidateData['password'],
                    $candidateData['admin'],
                    $candidateData['active'],
                    $candidateData['auth_attempt'],
                    $candidateData['photo']
                );

            } else {
                return $this->json(["error" => "User not found"],500);
            }
            if ($candidate) {
                if ($candidate->getActive()) {

                    if (password_verify(
                        $pass,
                        $candidate->getPassword()
                    )) {
                        return $this->json(["id_user" => $candidate->getId()]);
                    } else {
                        $candidate->auth_attempt++;
                        if ($candidate->auth_attempt > 5) {
                            return $this->json(["error" => "User blocked, please contact an administrator"], 500);
                        }
                        return $this->json(["error" => "Password incorrect", "auth_attempt" => $candidate->auth_attempt], 500);
                    }
                }
            }

            $this->redirect('Login');
        }
    }
}
