<?php
require_once(realpath(__DIR__ . "/../view/part/head.php"));

function Test () {
    require_once('./model/modelClient.php');
echo getNumClientByEmail('kilian.audouin@sfr.fr');
}
