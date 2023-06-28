<!DOCTYPE html>
<html lang="en">
<?php require_once(realpath(__DIR__ ."/../../config.inc.php"));
require_once(realpath(__DIR__ . '/../../class/autoloader.php'));
Autoloader::register();
?>

<head>
    <link rel="stylesheet" href="<?= SITE_URL; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="stylesheet" href="<?= SITE_URL; ?>/assets/css/bootstrap.min.js">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<? SITE_URL; ?>/assets/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
</head>
<header>
    <?php session_start(); ?>
    <?php if (isset($_SESSION['mail'])) {
        echo $_SESSION['mail'] ;

    } else {
        echo 'PAS DE SESSION';
    } ?>
</header>
<body>