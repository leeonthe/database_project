<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once 'bookLogic.php';


$uri = $_SERVER['REQUEST_URI'];
$book = new bookLogic($_GET);
$book->run();