<?php

namespace App\Controllers;

use App\MyClass\User;

class Login extends BaseController
{
    protected $acl   = false;
    protected $title = 'Connexion';

    public function postIndex()
    {
        
        if (($email = $this->request->getPost('email')) !== null
            && ($pass = $this->request->getPost('password')) !== null) {
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
                $this->redirect('Login');
                $this->error("Pas de compte associé");
            }
            if ($candidate) {
                if ($candidate->getActive()) {

                    if (password_verify(
                        $pass,
                        $candidate->getPassword()
                    )) {
                        $this->session->user = $candidate;
                        if ($this->request->getGet('backto') !== null) {
                            $this->success("Vous êtes bien connecté");
                            $this->redirect($this->request->getGet('backto'));
                        } else {
                            $this->redirect('/');
                        }
                    } else {
                        $candidate->auth_attempt++;
                        if ($candidate->auth_attempt > 5) {
                            $userModel->setAuthAttempt(false,$email);
                        }
                    }
                }
            }
        }
        $this->redirect('Login');
    }

    public function getIndex()
    {
        return view('login/index');
    }

    public function getOut()
    {
        $this->session->user = null;

        return $this->redirect('/Login');
    }
}