<?php

namespace App\Controllers; // Déclare le namespace pour les controllers de l'application

use App\MyClass\User; // Utilise la classe User depuis le namespace App\MyClass

class Login extends BaseController // Déclare la classe Login qui hérite de BaseController
{
    protected $acl   = false; // Désactive le contrôle d'accès pour cette classe
    protected $title = 'Connexion'; // Définit le titre de la page

    public function postIndex()
    {
        // Méthode pour gérer les soumissions du formulaire de connexion

        // Vérifie si les champs email et password sont présents dans la requête POST
        if (($email = $this->request->getPost('email')) !== null
            && ($pass = $this->request->getPost('password')) !== null) {

            $userModel = model('UserModel'); // Charge le modèle UserModel
            $candidateData = $userModel->getUserByMail($email); // Récupère les données de l'utilisateur par email

            if ($candidateData) {
                // Si des données utilisateur sont trouvées, crée une instance de User avec les données récupérées
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
                // Si aucun utilisateur n'est trouvé, redirige vers la page de connexion avec un message d'erreur
                $this->redirect('Login');
                $this->error("Pas de compte associé");
            }

            if ($candidate) {
                // Vérifie si l'utilisateur est actif
                if ($candidate->getActive()) {

                    // Vérifie si le mot de passe fourni correspond au mot de passe hashé de l'utilisateur
                    if (password_verify($pass, $candidate->getPassword())) {
                        // Si le mot de passe est correct, enregistre l'utilisateur dans la session
                        $this->session->user = $candidate;

                        if ($this->request->getGet('backto') !== null) {
                            // Si un paramètre 'backto' est présent dans la requête GET, redirige vers cette URL
                            $this->success("Vous êtes bien connecté");
                            $this->redirect($this->request->getGet('backto'));
                        } else {
                            // Sinon, redirige vers la page d'accueil
                            $this->redirect('/');
                        }
                    } else {
                        // Si le mot de passe est incorrect, incrémente le compteur de tentatives de connexion
                        $candidate->auth_attempt++;

                        if ($candidate->auth_attempt > 5) {
                            // Si le nombre de tentatives dépasse 5, désactive le compte de l'utilisateur
                            $userModel->setAuthAttempt(false, $email);
                        }
                    }
                }
            }
        }
        // Redirige vers la page de connexion par défaut
        $this->redirect('Login');
    }

    public function getIndex()
    {
        // Méthode pour afficher la page de connexion
        return view('login/index'); // Retourne la vue pour la page de connexion
    }

    public function getOut()
    {
        // Méthode pour gérer la déconnexion de l'utilisateur
        $this->session->user = null; // Supprime l'utilisateur de la session

        return $this->redirect('/Login'); // Redirige vers la page de connexion
    }
}
