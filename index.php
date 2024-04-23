<?php

require_once 'bookLogic.php';


$uri = $_SERVER['REQUEST_URI'];
$book = new bookLogic($uri, $_GET, $_POST);
$book->run();