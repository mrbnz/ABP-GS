<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding("UTF-8");
}
require './config/funcionsInicials.php';
require './config/baseDeDades.php';
require './vendors/me/RouterController.php';

$router = new RouterController();
$router->process(array(treuWEBROOT($_SERVER['REQUEST_URI'])));
// Rendering the view
$router->renderView();
?>