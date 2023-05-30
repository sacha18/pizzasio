<?php

$getParams = isset($_GET) ? $_GET : null;
$postParams = isset($_POST) ? $_POST : null;
$params = [
    "get" => $getParams,
    "post" => $postParams
];

if (isset($_GET['front'] )) {
    switch ($_GET['front']) {
        case 'inscription':
            require_once('./controller/controllerUtilisateur.php');
            Inscription();
            break;
        case 'connexion':
            require_once('./controller/controllerUtilisateur.php');
            Connexion();
            break;
        
            
            default:
            require_once('./controller/controllerSite.php');
            Default404();
            
            break;
        }
    }
    else {
        require_once('./controller/controllerSite.php');
        Accueil();
    }