<?php

$getParams = isset($_GET) ? $_GET : null;
$postParams = isset($_POST) ? $_POST : null;
$params = [
    "get" => $getParams,
    "post" => $postParams
];

if (isset($_GET['front'] )) {
    switch ($_GET['front']) {
        //a supprimer à la fin
        case 'test' :
            require_once('./controller/controllerTest.php');
            Test($params);
            break;
        case 'inscription':
            require_once('./controller/controllerClient.php');
            Inscription();
            break;
        case 'connexion':
            require_once('./controller/controllerClient.php');
            Connexion();
            break;
        
            
            default:
            require_once('./controller/controllerSite.php');
            Default404();
            
            break;
        }
    }
    elseif (isset($_GET['form'])) {
        switch ($_GET['form']) {
            case 'inscription':
                require_once('./controller/controllerClient.php');
                Inscrire($postParams);
                break;
            case 'connexion':
                require_once('./controller/controllerClient.php');
                Connecter($postParams);
                break;
            
            default:
                break;
        }
    }
    else {
        require_once('./controller/controllerSite.php');
        Accueil();
    }